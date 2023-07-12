<?php

namespace Tests\Repositories;

use App\Models\Pronoun;
use App\Repositories\PronounRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PronounRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected PronounRepository $pronounRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->pronounRepo = app(PronounRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_pronoun()
    {
        $pronoun = Pronoun::factory()->make()->toArray();

        $createdPronoun = $this->pronounRepo->create($pronoun);

        $createdPronoun = $createdPronoun->toArray();
        $this->assertArrayHasKey('id', $createdPronoun);
        $this->assertNotNull($createdPronoun['id'], 'Created Pronoun must have id specified');
        $this->assertNotNull(Pronoun::find($createdPronoun['id']), 'Pronoun with given id must be in DB');
        $this->assertModelData($pronoun, $createdPronoun);
    }

    /**
     * @test read
     */
    public function test_read_pronoun()
    {
        $pronoun = Pronoun::factory()->create();

        $dbPronoun = $this->pronounRepo->find($pronoun->id);

        $dbPronoun = $dbPronoun->toArray();
        $this->assertModelData($pronoun->toArray(), $dbPronoun);
    }

    /**
     * @test update
     */
    public function test_update_pronoun()
    {
        $pronoun = Pronoun::factory()->create();
        $fakePronoun = Pronoun::factory()->make()->toArray();

        $updatedPronoun = $this->pronounRepo->update($fakePronoun, $pronoun->id);

        $this->assertModelData($fakePronoun, $updatedPronoun->toArray());
        $dbPronoun = $this->pronounRepo->find($pronoun->id);
        $this->assertModelData($fakePronoun, $dbPronoun->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_pronoun()
    {
        $pronoun = Pronoun::factory()->create();

        $resp = $this->pronounRepo->delete($pronoun->id);

        $this->assertTrue($resp);
        $this->assertNull(Pronoun::find($pronoun->id), 'Pronoun should not exist in DB');
    }
}
