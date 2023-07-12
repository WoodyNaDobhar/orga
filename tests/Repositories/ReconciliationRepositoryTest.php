<?php

namespace Tests\Repositories;

use App\Models\Reconciliation;
use App\Repositories\ReconciliationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ReconciliationRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected ReconciliationRepository $reconciliationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->reconciliationRepo = app(ReconciliationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_reconciliation()
    {
        $reconciliation = Reconciliation::factory()->make()->toArray();

        $createdReconciliation = $this->reconciliationRepo->create($reconciliation);

        $createdReconciliation = $createdReconciliation->toArray();
        $this->assertArrayHasKey('id', $createdReconciliation);
        $this->assertNotNull($createdReconciliation['id'], 'Created Reconciliation must have id specified');
        $this->assertNotNull(Reconciliation::find($createdReconciliation['id']), 'Reconciliation with given id must be in DB');
        $this->assertModelData($reconciliation, $createdReconciliation);
    }

    /**
     * @test read
     */
    public function test_read_reconciliation()
    {
        $reconciliation = Reconciliation::factory()->create();

        $dbReconciliation = $this->reconciliationRepo->find($reconciliation->id);

        $dbReconciliation = $dbReconciliation->toArray();
        $this->assertModelData($reconciliation->toArray(), $dbReconciliation);
    }

    /**
     * @test update
     */
    public function test_update_reconciliation()
    {
        $reconciliation = Reconciliation::factory()->create();
        $fakeReconciliation = Reconciliation::factory()->make()->toArray();

        $updatedReconciliation = $this->reconciliationRepo->update($fakeReconciliation, $reconciliation->id);

        $this->assertModelData($fakeReconciliation, $updatedReconciliation->toArray());
        $dbReconciliation = $this->reconciliationRepo->find($reconciliation->id);
        $this->assertModelData($fakeReconciliation, $dbReconciliation->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_reconciliation()
    {
        $reconciliation = Reconciliation::factory()->create();

        $resp = $this->reconciliationRepo->delete($reconciliation->id);

        $this->assertTrue($resp);
        $this->assertNull(Reconciliation::find($reconciliation->id), 'Reconciliation should not exist in DB');
    }
}
