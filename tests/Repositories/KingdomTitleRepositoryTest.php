<?php

namespace Tests\Repositories;

use App\Models\KingdomTitle;
use App\Repositories\KingdomTitleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class KingdomTitleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected KingdomTitleRepository $kingdomTitleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->kingdomTitleRepo = app(KingdomTitleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_kingdom_title()
    {
        $kingdomTitle = KingdomTitle::factory()->make()->toArray();

        $createdKingdomTitle = $this->kingdomTitleRepo->create($kingdomTitle);

        $createdKingdomTitle = $createdKingdomTitle->toArray();
        $this->assertArrayHasKey('id', $createdKingdomTitle);
        $this->assertNotNull($createdKingdomTitle['id'], 'Created KingdomTitle must have id specified');
        $this->assertNotNull(KingdomTitle::find($createdKingdomTitle['id']), 'KingdomTitle with given id must be in DB');
        $this->assertModelData($kingdomTitle, $createdKingdomTitle);
    }

    /**
     * @test read
     */
    public function test_read_kingdom_title()
    {
        $kingdomTitle = KingdomTitle::factory()->create();

        $dbKingdomTitle = $this->kingdomTitleRepo->find($kingdomTitle->id);

        $dbKingdomTitle = $dbKingdomTitle->toArray();
        $this->assertModelData($kingdomTitle->toArray(), $dbKingdomTitle);
    }

    /**
     * @test update
     */
    public function test_update_kingdom_title()
    {
        $kingdomTitle = KingdomTitle::factory()->create();
        $fakeKingdomTitle = KingdomTitle::factory()->make()->toArray();

        $updatedKingdomTitle = $this->kingdomTitleRepo->update($fakeKingdomTitle, $kingdomTitle->id);

        $this->assertModelData($fakeKingdomTitle, $updatedKingdomTitle->toArray());
        $dbKingdomTitle = $this->kingdomTitleRepo->find($kingdomTitle->id);
        $this->assertModelData($fakeKingdomTitle, $dbKingdomTitle->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_kingdom_title()
    {
        $kingdomTitle = KingdomTitle::factory()->create();

        $resp = $this->kingdomTitleRepo->delete($kingdomTitle->id);

        $this->assertTrue($resp);
        $this->assertNull(KingdomTitle::find($kingdomTitle->id), 'KingdomTitle should not exist in DB');
    }
}
