<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Reign;

class ReignApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_reign()
    {
        $reign = Reign::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/reigns', $reign
        );

        $this->assertApiResponse($reign);
    }

    /**
     * @test
     */
    public function test_read_reign()
    {
        $reign = Reign::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/reigns/'.$reign->id
        );

        $this->assertApiResponse($reign->toArray());
    }

    /**
     * @test
     */
    public function test_update_reign()
    {
        $reign = Reign::factory()->create();
        $editedReign = Reign::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/reigns/'.$reign->id,
            $editedReign
        );

        $this->assertApiResponse($editedReign);
    }

    /**
     * @test
     */
    public function test_delete_reign()
    {
        $reign = Reign::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/reigns/'.$reign->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/reigns/'.$reign->id
        );

        $this->response->assertStatus(404);
    }
}
