<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Officer;

class OfficerApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_officer()
    {
        $officer = Officer::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/officers', $officer
        );

        $this->assertApiResponse($officer);
    }

    /**
     * @test
     */
    public function test_read_officer()
    {
        $officer = Officer::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/officers/'.$officer->id
        );

        $this->assertApiResponse($officer->toArray());
    }

    /**
     * @test
     */
    public function test_update_officer()
    {
        $officer = Officer::factory()->create();
        $editedOfficer = Officer::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/officers/'.$officer->id,
            $editedOfficer
        );

        $this->assertApiResponse($editedOfficer);
    }

    /**
     * @test
     */
    public function test_delete_officer()
    {
        $officer = Officer::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/officers/'.$officer->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/officers/'.$officer->id
        );

        $this->response->assertStatus(404);
    }
}
