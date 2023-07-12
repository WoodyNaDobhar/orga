<?php

namespace Tests\Repositories;

use App\Models\Park;
use App\Repositories\ParkRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ParkRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected ParkRepository $parkRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->parkRepo = app(ParkRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_park()
    {
        $park = Park::factory()->make()->toArray();

        $createdPark = $this->parkRepo->create($park);

        $createdPark = $createdPark->toArray();
        $this->assertArrayHasKey('id', $createdPark);
        $this->assertNotNull($createdPark['id'], 'Created Park must have id specified');
        $this->assertNotNull(Park::find($createdPark['id']), 'Park with given id must be in DB');
        $this->assertModelData($park, $createdPark);
    }

    /**
     * @test read
     */
    public function test_read_park()
    {
        $park = Park::factory()->create();

        $dbPark = $this->parkRepo->find($park->id);

        $dbPark = $dbPark->toArray();
        $this->assertModelData($park->toArray(), $dbPark);
    }

    /**
     * @test update
     */
    public function test_update_park()
    {
        $park = Park::factory()->create();
        $fakePark = Park::factory()->make()->toArray();

        $updatedPark = $this->parkRepo->update($fakePark, $park->id);

        $this->assertModelData($fakePark, $updatedPark->toArray());
        $dbPark = $this->parkRepo->find($park->id);
        $this->assertModelData($fakePark, $dbPark->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_park()
    {
        $park = Park::factory()->create();

        $resp = $this->parkRepo->delete($park->id);

        $this->assertTrue($resp);
        $this->assertNull(Park::find($park->id), 'Park should not exist in DB');
    }
}
