<?php

namespace App\Http\Controllers;

use App\Http\Services\TaskService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;

class StripeCheckout extends Controller
{
    private function setApiKey()
    {
        return new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
    }
    public function checkout($patient_id, $treatment_plan_id, $mode)
    {
        if ($mode == 'initial-deposit') {
            $patient = DB::table('patients')->where('id', $patient_id)->first();
            $treatment_plan = DB::table('p_treatment_plans')->where('patient_id', $patient->id)->where('id', $treatment_plan_id)->first();
            if (@$treatment_plan) {
                $order_id = @DB::table('orders')->where('treatment_plan_id', $treatment_plan->id)->where('is_deleted', 0)->first()->id;
                if (!@$order_id) {
                    $order_id = DB::table('orders')->insertGetId([
                        "user_id" => Auth::user()->id,
                        "patient_id" => $patient->id,
                        "treatment_plan_id" => $treatment_plan->id,
                        "datetime" => date("Y-m-d H:i:s"),
                    ]);
                }
                if (@$order_id) {
                    $amount = 150;
                    $stripe = self::setApiKey();
                    $payment_id = DB::table('payments')->insertGetId([
                        "order_id" => $order_id,
                        "patient_id" => $patient->id,
                        "treatment_plan_id" => $treatment_plan_id,
                        "amount" => $amount,
                        'mode' => $mode,
                    ]);
                    $checkout_session = $stripe->checkout->sessions->create([
                        'line_items' => [[
                            'price_data' => [
                                'currency' => 'EUR',
                                'product_data' => [
                                    'name' => "Patient: " . $patient->first_name . ' ' . $patient->last_name,
                                    'description' => "You need to pay initial deposit before submitting."
                                ],
                                'unit_amount' => $amount * 100,
                            ],
                            'quantity' => 1,
                        ]],
                        'mode' => 'payment',
                        'success_url' => route('checkout.success', ['payment_id' => $payment_id], true) . "?session_id={CHECKOUT_SESSION_ID}",
                        'cancel_url' => route('checkout.error', ['payment_id' => $payment_id], true) . "?session_id={CHECKOUT_SESSION_ID}",
                    ]);
                    DB::table('payments')->where('id', $payment_id)->update([
                        "session_id" => $checkout_session->id,
                    ]);
                    return redirect($checkout_session->url);
                }
            }
        }
        if ($mode == 'final-deposit') {
            $patient = DB::table('patients')->where('id', $patient_id)->first();
            $treatment_plan = DB::table('p_treatment_plans')->where('patient_id', $patient->id)->where('id', $treatment_plan_id)->first();
            if (@$treatment_plan) {
                $order_id = @DB::table('orders')->where('treatment_plan_id', $treatment_plan->id)->where('is_deleted', 0)->first()->id;
                if (@$order_id) {
                    $calculation = new \App\Http\Services\PriceCalculation();
                    $amount = $calculation->calc(Auth::user()->tier, $treatment_plan);
                    $stripe = self::setApiKey();
                    $payment_id = DB::table('payments')->insertGetId([
                        "order_id" => $order_id,
                        "patient_id" => $patient->id,
                        "treatment_plan_id" => $treatment_plan_id,
                        "amount" => $amount,
                        'mode' => $mode,
                    ]);
                    $checkout_session = $stripe->checkout->sessions->create([
                        'line_items' => [[
                            'price_data' => [
                                'currency' => 'EUR',
                                'product_data' => [
                                    'name' => "Patient: " . $patient->first_name . ' ' . $patient->last_name,
                                    'description' => "You need to pay final deposit before approving."
                                ],
                                'unit_amount' => $amount * 100,
                            ],
                            'quantity' => 1,
                        ]],
                        'mode' => 'payment',
                        'success_url' => route('checkout.success', ['payment_id' => $payment_id], true) . "?session_id={CHECKOUT_SESSION_ID}",
                        'cancel_url' => route('checkout.error', ['payment_id' => $payment_id], true) . "?session_id={CHECKOUT_SESSION_ID}",
                    ]);
                    DB::table('payments')->where('id', $payment_id)->update([
                        "session_id" => $checkout_session->id,
                    ]);
                    return redirect($checkout_session->url);
                }
            }
        }
        abort(403, "Unauthorized request!");
    }
    public function success(Request $request, $payment_id)
    {
        try {
            $sessionId = $request->get('session_id');
            $stripe = self::setApiKey();
            $session = $stripe->checkout->sessions->retrieve($sessionId);
            if (!$session) {
                abort(402, "Invalid request!");
            }
            $payment = DB::table('payments as pay')
                ->where('pay.id', $payment_id)
                ->where('pay.session_id', $session->id)
                ->where('pay.is_paid', 0)
                ->Join("patients as p", function ($join) {
                    $join->on("pay.patient_id", "=", "p.id")
                        ->where("p.is_deleted", 0);
                })
                ->select("pay.*", "p.user_id")
                ->first();
            if (@$payment) {
                DB::table('payments')->where('id', $payment_id)->update([
                    "is_paid" => 1,
                    "paid_at" => date("Y-m-d H:i:s"),
                ]);
                if ($payment->mode == 'initial-deposit') {
                    DB::table('p_treatment_plans')->where('id', $payment->treatment_plan_id)->update([
                        "is_submitted" => 1,
                        "status" => "Submitted",
                        "is_editable" => 1,
                    ]);
                    //add statff tasks
                    $task_id = (new TaskService($payment->treatment_plan_id))->create_task("staff", "Case Review");
                } else {
                    DB::table('p_treatment_plans')->where('id', $payment->treatment_plan_id)->update([
                        "is_completed" => 1,
                        "status" => "Completed"
                    ]);
                    (new TaskService($payment->treatment_plan_id))->complete_task("doctor", $payment->user_id);
                }
                $order_amount = @DB::table('orders')->where('id', $payment->order_id)->first()->deposit;
                DB::table('orders')->where('id', $payment->order_id)->update([
                    "deposit" =>  $order_amount ? $order_amount + $payment->amount : $payment,
                ]);
                return redirect('/patient/case-overview/' . $payment->treatment_plan_id)->with('success', 'You have successfully completed payment.');
            }
            abort(402, "Invalid request!");
        } catch (Exception $e) {
            dd($e);
            abort(200, "Invalid request!");
        }
    }
    public function error(Request $request, $payment_id)
    {
        abort(500, "Internal Server Error. Unable to complete payment.");
    }
}
