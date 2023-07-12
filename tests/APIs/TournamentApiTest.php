<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tournament;

class TournamentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_tournament()
    {
        $tournament = Tournament::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/tournaments', $tournament
        );

        $this->assertApiResponse($tournament);
    }

    /**
     * @test
     */
    public function test_read_tournament()
    {
        $tournament = Tournament::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/tournaments/'.$tournament->id
        );

        $this->assertApiResponse($tournament->toArray());
    }

    /**
     * @test
     */
    public function test_update_tournament()
    {
        $tournament = Tournament::factory()->create();
        $editedTournament = Tournament::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/tournaments/'.$tournament->id,
            $editedTournament
        );

        $this->assertApiResponse($editedTournament);
    }

    /**
     * @test
     */
    public function test_delete_tournament()
    {
        $tournament = Tournament::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/tournaments/'.$tournament->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/tournaments/'.$tournament->id
        );

        $this->response->assertStatus(404);
    }
}
