<?php

namespace Tests\Repositories;

use App\Models\KingdomOffice;
use App\Repositories\KingdomOfficeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class KingdomOfficeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected KingdomOfficeRepository $kingdomOfficeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->kingdomOfficeRepo = app(KingdomOfficeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_kingdom_office()
    {
        $kingdomOffice = KingdomOffice::factory()->make()->toArray();

        $createdKingdomOffice = $this->kingdomOfficeRepo->create($kingdomOffice);

        $createdKingdomOffice = $createdKingdomOffice->toArray();
        $this->assertArrayHasKey('id', $createdKingdomOffice);
        $this->assertNotNull($createdKingdomOffice['id'], 'Created KingdomOffice must have id specified');
        $this->assertNotNull(KingdomOffice::find($createdKingdomOffice['id']), 'KingdomOffice with given id must be in DB');
        $this->assertModelData($kingdomOffice, $createdKingdomOffice);
    }

    /**
     * @test read
     */
    public function test_read_kingdom_office()
    {
        $kingdomOffice = KingdomOffice::factory()->create();

        $dbKingdomOffice = $this->kingdomOfficeRepo->find($kingdomOffice->id);

        $dbKingdomOffice = $dbKingdomOffice->toArray();
        $this->assertModelData($kingdomOffice->toArray(), $dbKingdomOffice);
    }

    /**
     * @test update
     */
    public function test_update_kingdom_office()
    {
        $kingdomOffice = KingdomOffice::factory()->create();
        $fakeKingdomOffice = KingdomOffice::factory()->make()->toArray();

        $updatedKingdomOffice = $this->kingdomOfficeRepo->update($fakeKingdomOffice, $kingdomOffice->id);

        $this->assertModelData($fakeKingdomOffice, $updatedKingdomOffice->toArray());
        $dbKingdomOffice = $this->kingdomOfficeRepo->find($kingdomOffice->id);
        $this->assertModelData($fakeKingdomOffice, $dbKingdomOffice->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_kingdom_office()
    {
        $kingdomOffice = KingdomOffice::factory()->create();

        $resp = $this->kingdomOfficeRepo->delete($kingdomOffice->id);

        $this->assertTrue($resp);
        $this->assertNull(KingdomOffice::find($kingdomOffice->id), 'KingdomOffice should not exist in DB');
    }
}
