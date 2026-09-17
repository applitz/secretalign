<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ImageClassifierTest extends TestCase
{
    private const PIXEL = 'data:image/jpeg;base64,/9j/4AAQSkZJRg=='; // dummy data URI (valid shape)

    private function fakeOpenRouter(string $slot, float $confidence = 1.0): void
    {
        Http::fake([
            'openrouter.ai/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => json_encode(['slot' => $slot, 'confidence' => $confidence, 'reason' => 'test'])]],
                ],
            ], 200),
        ]);
    }

    public function test_it_classifies_a_batch_and_returns_slots(): void
    {
        $this->fakeOpenRouter('Front');

        $resp = $this->postJson('/patient/154/images/classify', [
            'images' => [
                ['index' => 0, 'data_uri' => self::PIXEL],
                ['index' => 1, 'data_uri' => self::PIXEL],
            ],
        ]);

        $resp->assertOk()
            ->assertJson(['status' => 'success'])
            ->assertJsonCount(2, 'results')
            ->assertJsonPath('results.0.slot', 'Front');
    }

    public function test_it_rejects_more_than_15_images(): void
    {
        $this->fakeOpenRouter('Front');

        $images = [];
        for ($i = 0; $i < 16; $i++) {
            $images[] = ['index' => $i, 'data_uri' => self::PIXEL];
        }

        $this->postJson('/patient/154/images/classify', ['images' => $images])
            ->assertStatus(422)
            ->assertJsonPath('status', 'error');
    }

    public function test_it_rejects_a_non_image_data_uri(): void
    {
        $this->fakeOpenRouter('Front');

        $this->postJson('/patient/154/images/classify', [
            'images' => [['index' => 0, 'data_uri' => 'data:application/pdf;base64,AAAA']],
        ])->assertStatus(422);
    }

    public function test_it_returns_503_when_key_is_missing(): void
    {
        config(['services.openrouter.key' => '']);

        $this->postJson('/patient/154/images/classify', [
            'images' => [['index' => 0, 'data_uri' => self::PIXEL]],
        ])->assertStatus(503);
    }

    public function test_unknown_slot_from_model_falls_back_to_general_upload(): void
    {
        // Model returns a slot that isn't in the canonical list on every attempt.
        Http::fake([
            'openrouter.ai/*' => Http::response([
                'choices' => [['message' => ['content' => '{"slot":"Nonsense","confidence":0.9}']]],
            ], 200),
        ]);

        $this->postJson('/patient/154/images/classify', [
            'images' => [['index' => 0, 'data_uri' => self::PIXEL]],
        ])->assertOk()->assertJsonPath('results.0.slot', 'General Upload');
    }
}
