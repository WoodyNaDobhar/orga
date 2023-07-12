<?php

namespace Tests\Repositories;

use App\Models\Archetype;
use App\Repositories\ArchetypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ArchetypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected ArchetypeRepository $archetypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->archetypeRepo = app(ArchetypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_archetype()
    {
        $archetype = Archetype::factory()->make()->toArray();

        $createdArchetype = $this->archetypeRepo->create($archetype);

        $createdArchetype = $createdArchetype->toArray();
        $this->assertArrayHasKey('id', $createdArchetype);
        $this->assertNotNull($createdArchetype['id'], 'Created Archetype must have id specified');
        $this->assertNotNull(Archetype::find($createdArchetype['id']), 'Archetype with given id must be in DB');
        $this->assertModelData($archetype, $createdArchetype);
    }

    /**
     * @test read
     */
    public function test_read_archetype()
    {
        $archetype = Archetype::factory()->create();

        $dbArchetype = $this->archetypeRepo->find($archetype->id);

        $dbArchetype = $dbArchetype->toArray();
        $this->assertModelData($archetype->toArray(), $dbArchetype);
    }

    /**
     * @test update
     */
    public function test_update_archetype()
    {
        $archetype = Archetype::factory()->create();
        $fakeArchetype = Archetype::factory()->make()->toArray();

        $updatedArchetype = $this->archetypeRepo->update($fakeArchetype, $archetype->id);

        $this->assertModelData($fakeArchetype, $updatedArchetype->toArray());
        $dbArchetype = $this->archetypeRepo->find($archetype->id);
        $this->assertModelData($fakeArchetype, $dbArchetype->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_archetype()
    {
        $archetype = Archetype::factory()->create();

        $resp = $this->archetypeRepo->delete($archetype->id);

        $this->assertTrue($resp);
        $this->assertNull(Archetype::find($archetype->id), 'Archetype should not exist in DB');
    }
}
