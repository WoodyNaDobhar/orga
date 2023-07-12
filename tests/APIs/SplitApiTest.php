<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Split;

class SplitApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_split()
    {
        $split = Split::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/splits', $split
        );

        $this->assertApiResponse($split);
    }

    /**
     * @test
     */
    public function test_read_split()
    {
        $split = Split::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/splits/'.$split->id
        );

        $this->assertApiResponse($split->toArray());
    }

    /**
     * @test
     */
    public function test_update_split()
    {
        $split = Split::factory()->create();
        $editedSplit = Split::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/splits/'.$split->id,
            $editedSplit
        );

        $this->assertApiResponse($editedSplit);
    }

    /**
     * @test
     */
    public function test_delete_split()
    {
        $split = Split::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/splits/'.$split->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/splits/'.$split->id
        );

        $this->response->assertStatus(404);
    }
}
