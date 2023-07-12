<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Due;

class DueApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_due()
    {
        $due = Due::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/dues', $due
        );

        $this->assertApiResponse($due);
    }

    /**
     * @test
     */
    public function test_read_due()
    {
        $due = Due::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/dues/'.$due->id
        );

        $this->assertApiResponse($due->toArray());
    }

    /**
     * @test
     */
    public function test_update_due()
    {
        $due = Due::factory()->create();
        $editedDue = Due::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/dues/'.$due->id,
            $editedDue
        );

        $this->assertApiResponse($editedDue);
    }

    /**
     * @test
     */
    public function test_delete_due()
    {
        $due = Due::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/dues/'.$due->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/dues/'.$due->id
        );

        $this->response->assertStatus(404);
    }
}
