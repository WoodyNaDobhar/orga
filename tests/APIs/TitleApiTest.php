<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Title;

class TitleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_title()
    {
        $title = Title::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/titles', $title
        );

        $this->assertApiResponse($title);
    }

    /**
     * @test
     */
    public function test_read_title()
    {
        $title = Title::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/titles/'.$title->id
        );

        $this->assertApiResponse($title->toArray());
    }

    /**
     * @test
     */
    public function test_update_title()
    {
        $title = Title::factory()->create();
        $editedTitle = Title::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/titles/'.$title->id,
            $editedTitle
        );

        $this->assertApiResponse($editedTitle);
    }

    /**
     * @test
     */
    public function test_delete_title()
    {
        $title = Title::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/titles/'.$title->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/titles/'.$title->id
        );

        $this->response->assertStatus(404);
    }
}
