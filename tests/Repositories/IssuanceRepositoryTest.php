<?php

namespace Tests\Repositories;

use App\Models\Issuance;
use App\Repositories\IssuanceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class IssuanceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected IssuanceRepository $issuanceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->issuanceRepo = app(IssuanceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_issuance()
    {
        $issuance = Issuance::factory()->make()->toArray();

        $createdIssuance = $this->issuanceRepo->create($issuance);

        $createdIssuance = $createdIssuance->toArray();
        $this->assertArrayHasKey('id', $createdIssuance);
        $this->assertNotNull($createdIssuance['id'], 'Created Issuance must have id specified');
        $this->assertNotNull(Issuance::find($createdIssuance['id']), 'Issuance with given id must be in DB');
        $this->assertModelData($issuance, $createdIssuance);
    }

    /**
     * @test read
     */
    public function test_read_issuance()
    {
        $issuance = Issuance::factory()->create();

        $dbIssuance = $this->issuanceRepo->find($issuance->id);

        $dbIssuance = $dbIssuance->toArray();
        $this->assertModelData($issuance->toArray(), $dbIssuance);
    }

    /**
     * @test update
     */
    public function test_update_issuance()
    {
        $issuance = Issuance::factory()->create();
        $fakeIssuance = Issuance::factory()->make()->toArray();

        $updatedIssuance = $this->issuanceRepo->update($fakeIssuance, $issuance->id);

        $this->assertModelData($fakeIssuance, $updatedIssuance->toArray());
        $dbIssuance = $this->issuanceRepo->find($issuance->id);
        $this->assertModelData($fakeIssuance, $dbIssuance->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_issuance()
    {
        $issuance = Issuance::factory()->create();

        $resp = $this->issuanceRepo->delete($issuance->id);

        $this->assertTrue($resp);
        $this->assertNull(Issuance::find($issuance->id), 'Issuance should not exist in DB');
    }
}
