<?php

namespace Tests\Repositories;

use App\Models\Persona;
use App\Repositories\PersonaRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PersonaRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected PersonaRepository $personaRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->personaRepo = app(PersonaRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_persona()
    {
        $persona = Persona::factory()->make()->toArray();

        $createdPersona = $this->personaRepo->create($persona);

        $createdPersona = $createdPersona->toArray();
        $this->assertArrayHasKey('id', $createdPersona);
        $this->assertNotNull($createdPersona['id'], 'Created Persona must have id specified');
        $this->assertNotNull(Persona::find($createdPersona['id']), 'Persona with given id must be in DB');
        $this->assertModelData($persona, $createdPersona);
    }

    /**
     * @test read
     */
    public function test_read_persona()
    {
        $persona = Persona::factory()->create();

        $dbPersona = $this->personaRepo->find($persona->id);

        $dbPersona = $dbPersona->toArray();
        $this->assertModelData($persona->toArray(), $dbPersona);
    }

    /**
     * @test update
     */
    public function test_update_persona()
    {
        $persona = Persona::factory()->create();
        $fakePersona = Persona::factory()->make()->toArray();

        $updatedPersona = $this->personaRepo->update($fakePersona, $persona->id);

        $this->assertModelData($fakePersona, $updatedPersona->toArray());
        $dbPersona = $this->personaRepo->find($persona->id);
        $this->assertModelData($fakePersona, $dbPersona->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_persona()
    {
        $persona = Persona::factory()->create();

        $resp = $this->personaRepo->delete($persona->id);

        $this->assertTrue($resp);
        $this->assertNull(Persona::find($persona->id), 'Persona should not exist in DB');
    }
}
