<?php

namespace Tests\Repositories;

use App\Models\Kingdom;
use App\Repositories\KingdomRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class KingdomRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected KingdomRepository $kingdomRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->kingdomRepo = app(KingdomRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_kingdom()
    {
        $kingdom = Kingdom::factory()->make()->toArray();

        $createdKingdom = $this->kingdomRepo->create($kingdom);

        $createdKingdom = $createdKingdom->toArray();
        $this->assertArrayHasKey('id', $createdKingdom);
        $this->assertNotNull($createdKingdom['id'], 'Created Kingdom must have id specified');
        $this->assertNotNull(Kingdom::find($createdKingdom['id']), 'Kingdom with given id must be in DB');
        $this->assertModelData($kingdom, $createdKingdom);
    }

    /**
     * @test read
     */
    public function test_read_kingdom()
    {
        $kingdom = Kingdom::factory()->create();

        $dbKingdom = $this->kingdomRepo->find($kingdom->id);

        $dbKingdom = $dbKingdom->toArray();
        $this->assertModelData($kingdom->toArray(), $dbKingdom);
    }

    /**
     * @test update
     */
    public function test_update_kingdom()
    {
        $kingdom = Kingdom::factory()->create();
        $fakeKingdom = Kingdom::factory()->make()->toArray();

        $updatedKingdom = $this->kingdomRepo->update($fakeKingdom, $kingdom->id);

        $this->assertModelData($fakeKingdom, $updatedKingdom->toArray());
        $dbKingdom = $this->kingdomRepo->find($kingdom->id);
        $this->assertModelData($fakeKingdom, $dbKingdom->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_kingdom()
    {
        $kingdom = Kingdom::factory()->create();

        $resp = $this->kingdomRepo->delete($kingdom->id);

        $this->assertTrue($resp);
        $this->assertNull(Kingdom::find($kingdom->id), 'Kingdom should not exist in DB');
    }
}
