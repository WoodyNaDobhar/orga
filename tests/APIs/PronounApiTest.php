<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Pronoun;

class PronounApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_pronoun()
    {
        $pronoun = Pronoun::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/pronouns', $pronoun
        );

        $this->assertApiResponse($pronoun);
    }

    /**
     * @test
     */
    public function test_read_pronoun()
    {
        $pronoun = Pronoun::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/pronouns/'.$pronoun->id
        );

        $this->assertApiResponse($pronoun->toArray());
    }

    /**
     * @test
     */
    public function test_update_pronoun()
    {
        $pronoun = Pronoun::factory()->create();
        $editedPronoun = Pronoun::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/pronouns/'.$pronoun->id,
            $editedPronoun
        );

        $this->assertApiResponse($editedPronoun);
    }

    /**
     * @test
     */
    public function test_delete_pronoun()
    {
        $pronoun = Pronoun::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/pronouns/'.$pronoun->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/pronouns/'.$pronoun->id
        );

        $this->response->assertStatus(404);
    }
}
