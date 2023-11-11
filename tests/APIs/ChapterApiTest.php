<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Chapter;

class ChapterApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_chapter()
    {
        $chapter = Chapter::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/chapters', $chapter
        );

        $this->assertApiResponse($chapter);
    }

    /**
     * @test
     */
    public function test_read_chapter()
    {
        $chapter = Chapter::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/chapters/'.$chapter->id
        );

        $this->assertApiResponse($chapter->toArray());
    }

    /**
     * @test
     */
    public function test_update_chapter()
    {
        $chapter = Chapter::factory()->create();
        $editedChapter = Chapter::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/chapters/'.$chapter->id,
            $editedChapter
        );

        $this->assertApiResponse($editedChapter);
    }

    /**
     * @test
     */
    public function test_delete_chapter()
    {
        $chapter = Chapter::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/chapters/'.$chapter->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/chapters/'.$chapter->id
        );

        $this->response->assertStatus(404);
    }
}
