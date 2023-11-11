<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Chaptertype;

class ChaptertypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_chaptertype()
    {
        $chaptertype = Chaptertype::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/chaptertypes', $chaptertype
        );

        $this->assertApiResponse($chaptertype);
    }

    /**
     * @test
     */
    public function test_read_chaptertype()
    {
        $chaptertype = Chaptertype::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/chaptertypes/'.$chaptertype->id
        );

        $this->assertApiResponse($chaptertype->toArray());
    }

    /**
     * @test
     */
    public function test_update_chaptertype()
    {
        $chaptertype = Chaptertype::factory()->create();
        $editedChaptertype = Chaptertype::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/chaptertypes/'.$chaptertype->id,
            $editedChaptertype
        );

        $this->assertApiResponse($editedChaptertype);
    }

    /**
     * @test
     */
    public function test_delete_chaptertype()
    {
        $chaptertype = Chaptertype::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/chaptertypes/'.$chaptertype->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/chaptertypes/'.$chaptertype->id
        );

        $this->response->assertStatus(404);
    }
}
