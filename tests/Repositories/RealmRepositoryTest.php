<?php

namespace Tests\Repositories;

use App\Models\Realm;
use App\Repositories\RealmRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RealmRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected RealmRepository $realmRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->realmRepo = app(RealmRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_realm()
    {
        $realm = Realm::factory()->make()->toArray();

        $createdRealm = $this->realmRepo->create($realm);

        $createdRealm = $createdRealm->toArray();
        $this->assertArrayHasKey('id', $createdRealm);
        $this->assertNotNull($createdRealm['id'], 'Created Realm must have id specified');
        $this->assertNotNull(Realm::find($createdRealm['id']), 'Realm with given id must be in DB');
        $this->assertModelData($realm, $createdRealm);
    }

    /**
     * @test read
     */
    public function test_read_realm()
    {
        $realm = Realm::factory()->create();

        $dbRealm = $this->realmRepo->find($realm->id);

        $dbRealm = $dbRealm->toArray();
        $this->assertModelData($realm->toArray(), $dbRealm);
    }

    /**
     * @test update
     */
    public function test_update_realm()
    {
        $realm = Realm::factory()->create();
        $fakeRealm = Realm::factory()->make()->toArray();

        $updatedRealm = $this->realmRepo->update($fakeRealm, $realm->id);

        $this->assertModelData($fakeRealm, $updatedRealm->toArray());
        $dbRealm = $this->realmRepo->find($realm->id);
        $this->assertModelData($fakeRealm, $dbRealm->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_realm()
    {
        $realm = Realm::factory()->create();

        $resp = $this->realmRepo->delete($realm->id);

        $this->assertTrue($resp);
        $this->assertNull(Realm::find($realm->id), 'Realm should not exist in DB');
    }
}
