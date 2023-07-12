<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Suspension;

class SuspensionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_suspension()
    {
        $suspension = Suspension::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/suspensions', $suspension
        );

        $this->assertApiResponse($suspension);
    }

    /**
     * @test
     */
    public function test_read_suspension()
    {
        $suspension = Suspension::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/suspensions/'.$suspension->id
        );

        $this->assertApiResponse($suspension->toArray());
    }

    /**
     * @test
     */
    public function test_update_suspension()
    {
        $suspension = Suspension::factory()->create();
        $editedSuspension = Suspension::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/suspensions/'.$suspension->id,
            $editedSuspension
        );

        $this->assertApiResponse($editedSuspension);
    }

    /**
     * @test
     */
    public function test_delete_suspension()
    {
        $suspension = Suspension::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/suspensions/'.$suspension->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/suspensions/'.$suspension->id
        );

        $this->response->assertStatus(404);
    }
}
