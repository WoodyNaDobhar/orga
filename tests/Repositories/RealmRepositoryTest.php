<?php

namespace Tests\Repositories;

use App\Models\Realm;
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
        $realm = Realm::factory()->make()->toArray();

        $createdKingdom = $this->kingdomRepo->create($realm);

        $createdKingdom = $createdKingdom->toArray();
        $this->assertArrayHasKey('id', $createdKingdom);
        $this->assertNotNull($createdKingdom['id'], 'Created Realm must have id specified');
        $this->assertNotNull(Realm::find($createdKingdom['id']), 'Realm with given id must be in DB');
        $this->assertModelData($realm, $createdKingdom);
    }

    /**
     * @test read
     */
    public function test_read_kingdom()
    {
        $realm = Realm::factory()->create();

        $dbKingdom = $this->kingdomRepo->find($realm->id);

        $dbKingdom = $dbKingdom->toArray();
        $this->assertModelData($realm->toArray(), $dbKingdom);
    }

    /**
     * @test update
     */
    public function test_update_kingdom()
    {
        $realm = Realm::factory()->create();
        $fakeKingdom = Realm::factory()->make()->toArray();

        $updatedKingdom = $this->kingdomRepo->update($fakeKingdom, $realm->id);

        $this->assertModelData($fakeKingdom, $updatedKingdom->toArray());
        $dbKingdom = $this->kingdomRepo->find($realm->id);
        $this->assertModelData($fakeKingdom, $dbKingdom->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_kingdom()
    {
        $realm = Realm::factory()->create();

        $resp = $this->kingdomRepo->delete($realm->id);

        $this->assertTrue($resp);
        $this->assertNull(Realm::find($realm->id), 'Realm should not exist in DB');
    }
}
