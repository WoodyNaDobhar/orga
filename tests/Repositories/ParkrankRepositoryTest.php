<?php

namespace Tests\Repositories;

use App\Models\Parkrank;
use App\Repositories\ParkrankRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ParkrankRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected ParkrankRepository $parkrankRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->parkrankRepo = app(ParkrankRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_parkrank()
    {
        $parkrank = Parkrank::factory()->make()->toArray();

        $createdParkrank = $this->parkrankRepo->create($parkrank);

        $createdParkrank = $createdParkrank->toArray();
        $this->assertArrayHasKey('id', $createdParkrank);
        $this->assertNotNull($createdParkrank['id'], 'Created Parkrank must have id specified');
        $this->assertNotNull(Parkrank::find($createdParkrank['id']), 'Parkrank with given id must be in DB');
        $this->assertModelData($parkrank, $createdParkrank);
    }

    /**
     * @test read
     */
    public function test_read_parkrank()
    {
        $parkrank = Parkrank::factory()->create();

        $dbParkrank = $this->parkrankRepo->find($parkrank->id);

        $dbParkrank = $dbParkrank->toArray();
        $this->assertModelData($parkrank->toArray(), $dbParkrank);
    }

    /**
     * @test update
     */
    public function test_update_parkrank()
    {
        $parkrank = Parkrank::factory()->create();
        $fakeParkrank = Parkrank::factory()->make()->toArray();

        $updatedParkrank = $this->parkrankRepo->update($fakeParkrank, $parkrank->id);

        $this->assertModelData($fakeParkrank, $updatedParkrank->toArray());
        $dbParkrank = $this->parkrankRepo->find($parkrank->id);
        $this->assertModelData($fakeParkrank, $dbParkrank->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_parkrank()
    {
        $parkrank = Parkrank::factory()->create();

        $resp = $this->parkrankRepo->delete($parkrank->id);

        $this->assertTrue($resp);
        $this->assertNull(Parkrank::find($parkrank->id), 'Parkrank should not exist in DB');
    }
}
