<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Archetype;

class ArchetypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_archetype()
    {
        $archetype = Archetype::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/archetypes', $archetype
        );

        $this->assertApiResponse($archetype);
    }

    /**
     * @test
     */
    public function test_read_archetype()
    {
        $archetype = Archetype::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/archetypes/'.$archetype->id
        );

        $this->assertApiResponse($archetype->toArray());
    }

    /**
     * @test
     */
    public function test_update_archetype()
    {
        $archetype = Archetype::factory()->create();
        $editedArchetype = Archetype::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/archetypes/'.$archetype->id,
            $editedArchetype
        );

        $this->assertApiResponse($editedArchetype);
    }

    /**
     * @test
     */
    public function test_delete_archetype()
    {
        $archetype = Archetype::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/archetypes/'.$archetype->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/archetypes/'.$archetype->id
        );

        $this->response->assertStatus(404);
    }
}
