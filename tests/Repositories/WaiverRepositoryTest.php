<?php

namespace Tests\Repositories;

use App\Models\Waiver;
use App\Repositories\WaiverRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class WaiverRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected WaiverRepository $waiverRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->waiverRepo = app(WaiverRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_waiver()
    {
        $waiver = Waiver::factory()->make()->toArray();

        $createdWaiver = $this->waiverRepo->create($waiver);

        $createdWaiver = $createdWaiver->toArray();
        $this->assertArrayHasKey('id', $createdWaiver);
        $this->assertNotNull($createdWaiver['id'], 'Created Waiver must have id specified');
        $this->assertNotNull(Waiver::find($createdWaiver['id']), 'Waiver with given id must be in DB');
        $this->assertModelData($waiver, $createdWaiver);
    }

    /**
     * @test read
     */
    public function test_read_waiver()
    {
        $waiver = Waiver::factory()->create();

        $dbWaiver = $this->waiverRepo->find($waiver->id);

        $dbWaiver = $dbWaiver->toArray();
        $this->assertModelData($waiver->toArray(), $dbWaiver);
    }

    /**
     * @test update
     */
    public function test_update_waiver()
    {
        $waiver = Waiver::factory()->create();
        $fakeWaiver = Waiver::factory()->make()->toArray();

        $updatedWaiver = $this->waiverRepo->update($fakeWaiver, $waiver->id);

        $this->assertModelData($fakeWaiver, $updatedWaiver->toArray());
        $dbWaiver = $this->waiverRepo->find($waiver->id);
        $this->assertModelData($fakeWaiver, $dbWaiver->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_waiver()
    {
        $waiver = Waiver::factory()->create();

        $resp = $this->waiverRepo->delete($waiver->id);

        $this->assertTrue($resp);
        $this->assertNull(Waiver::find($waiver->id), 'Waiver should not exist in DB');
    }
}
