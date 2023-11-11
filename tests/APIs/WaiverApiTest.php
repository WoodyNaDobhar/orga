<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Waiver;

class WaiverApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_waiver()
    {
        $waiver = Waiver::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/waivers', $waiver
        );

        $this->assertApiResponse($waiver);
    }

    /**
     * @test
     */
    public function test_read_waiver()
    {
        $waiver = Waiver::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/waivers/'.$waiver->id
        );

        $this->assertApiResponse($waiver->toArray());
    }

    /**
     * @test
     */
    public function test_update_waiver()
    {
        $waiver = Waiver::factory()->create();
        $editedWaiver = Waiver::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/waivers/'.$waiver->id,
            $editedWaiver
        );

        $this->assertApiResponse($editedWaiver);
    }

    /**
     * @test
     */
    public function test_delete_waiver()
    {
        $waiver = Waiver::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/waivers/'.$waiver->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/waivers/'.$waiver->id
        );

        $this->response->assertStatus(404);
    }
}
