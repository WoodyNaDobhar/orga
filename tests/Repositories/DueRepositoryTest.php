<?php

namespace Tests\Repositories;

use App\Models\Due;
use App\Repositories\DueRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class DueRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected DueRepository $dueRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->dueRepo = app(DueRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_due()
    {
        $due = Due::factory()->make()->toArray();

        $createdDue = $this->dueRepo->create($due);

        $createdDue = $createdDue->toArray();
        $this->assertArrayHasKey('id', $createdDue);
        $this->assertNotNull($createdDue['id'], 'Created Due must have id specified');
        $this->assertNotNull(Due::find($createdDue['id']), 'Due with given id must be in DB');
        $this->assertModelData($due, $createdDue);
    }

    /**
     * @test read
     */
    public function test_read_due()
    {
        $due = Due::factory()->create();

        $dbDue = $this->dueRepo->find($due->id);

        $dbDue = $dbDue->toArray();
        $this->assertModelData($due->toArray(), $dbDue);
    }

    /**
     * @test update
     */
    public function test_update_due()
    {
        $due = Due::factory()->create();
        $fakeDue = Due::factory()->make()->toArray();

        $updatedDue = $this->dueRepo->update($fakeDue, $due->id);

        $this->assertModelData($fakeDue, $updatedDue->toArray());
        $dbDue = $this->dueRepo->find($due->id);
        $this->assertModelData($fakeDue, $dbDue->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_due()
    {
        $due = Due::factory()->create();

        $resp = $this->dueRepo->delete($due->id);

        $this->assertTrue($resp);
        $this->assertNull(Due::find($due->id), 'Due should not exist in DB');
    }
}
