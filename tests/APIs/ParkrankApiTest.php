<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Parkrank;

class ParkrankApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_parkrank()
    {
        $parkrank = Parkrank::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/parkranks', $parkrank
        );

        $this->assertApiResponse($parkrank);
    }

    /**
     * @test
     */
    public function test_read_parkrank()
    {
        $parkrank = Parkrank::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/parkranks/'.$parkrank->id
        );

        $this->assertApiResponse($parkrank->toArray());
    }

    /**
     * @test
     */
    public function test_update_parkrank()
    {
        $parkrank = Parkrank::factory()->create();
        $editedParkrank = Parkrank::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/parkranks/'.$parkrank->id,
            $editedParkrank
        );

        $this->assertApiResponse($editedParkrank);
    }

    /**
     * @test
     */
    public function test_delete_parkrank()
    {
        $parkrank = Parkrank::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/parkranks/'.$parkrank->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/parkranks/'.$parkrank->id
        );

        $this->response->assertStatus(404);
    }
}
