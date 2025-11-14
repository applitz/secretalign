<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.superadmin']);
    }
    public function view_events(Request $request)
    {
        $search =  $request->get('search');
        $events = DB::table('events')->where('is_deleted', 0)->orderBy('date', 'desc')->paginate(20);
        return view("events.view_events", compact("events"));
    }
    public function add_event()
    {
        return view("events.add_event");
    }
    public function edit_event($id)
    {
        $event = DB::table('events')->where('id', $id)->where('is_deleted', 0)->first();
        if(@$event) {
            return view("events.edit_event", compact("event"));
        }
        abort(404, "page not found");
    }
    public function save_event(Request $request)
    {
        $this->validate($request, [
            "event_name" => "required",
            "date" => "required",
            "description" => "required",
        ]);
        DB::table('events')->insert([
            "user_id" => Auth::user()->id,
            "event_name" => $request->input('event_name'),
            "date" => date("Y-m-d", strtotime($request->input('date'))),
            "external_link" => $request->input('link'),
            "description" => $request->input('description')
        ]);
        return redirect()->back()->with('success', 'New event created');
    }
    public function update_event(Request $request)
    {
        $this->validate($request, [
            "event_name" => "required",
            "date" => "required",
            "description" => "required"
        ]);
        DB::table('events')->where('id', $request->input('eventId'))->update([
           "date" => $request->input('date'),
            "event_name" => $request->input('event_name'),
            "external_link" => $request->input('link'),
            "updated_at" => date("Y-m-d H:i:s"),
            "description" => $request->input('description'),
        ]);
        return redirect()->back()->with('success', 'Event updated');
    }
    public function delete_event(Request $request)
    {
        DB::table('events')->where('id', $request->post('eventId'))->update([
            "is_deleted" => 1,
            "deleted_at" => date("Y-m-d H:i:s"),
        ]);
        Session::flash('success', 'Event deleted');
       return response()->json(1);
    }
}
