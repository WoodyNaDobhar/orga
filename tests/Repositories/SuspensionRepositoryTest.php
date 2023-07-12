<?php

namespace Tests\Repositories;

use App\Models\Suspension;
use App\Repositories\SuspensionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SuspensionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected SuspensionRepository $suspensionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->suspensionRepo = app(SuspensionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_suspension()
    {
        $suspension = Suspension::factory()->make()->toArray();

        $createdSuspension = $this->suspensionRepo->create($suspension);

        $createdSuspension = $createdSuspension->toArray();
        $this->assertArrayHasKey('id', $createdSuspension);
        $this->assertNotNull($createdSuspension['id'], 'Created Suspension must have id specified');
        $this->assertNotNull(Suspension::find($createdSuspension['id']), 'Suspension with given id must be in DB');
        $this->assertModelData($suspension, $createdSuspension);
    }

    /**
     * @test read
     */
    public function test_read_suspension()
    {
        $suspension = Suspension::factory()->create();

        $dbSuspension = $this->suspensionRepo->find($suspension->id);

        $dbSuspension = $dbSuspension->toArray();
        $this->assertModelData($suspension->toArray(), $dbSuspension);
    }

    /**
     * @test update
     */
    public function test_update_suspension()
    {
        $suspension = Suspension::factory()->create();
        $fakeSuspension = Suspension::factory()->make()->toArray();

        $updatedSuspension = $this->suspensionRepo->update($fakeSuspension, $suspension->id);

        $this->assertModelData($fakeSuspension, $updatedSuspension->toArray());
        $dbSuspension = $this->suspensionRepo->find($suspension->id);
        $this->assertModelData($fakeSuspension, $dbSuspension->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_suspension()
    {
        $suspension = Suspension::factory()->create();

        $resp = $this->suspensionRepo->delete($suspension->id);

        $this->assertTrue($resp);
        $this->assertNull(Suspension::find($suspension->id), 'Suspension should not exist in DB');
    }
}
