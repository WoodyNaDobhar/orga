<?php

namespace Tests\Repositories;

use App\Models\Officer;
use App\Repositories\OfficerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class OfficerRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected OfficerRepository $officerRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->officerRepo = app(OfficerRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_officer()
    {
        $officer = Officer::factory()->make()->toArray();

        $createdOfficer = $this->officerRepo->create($officer);

        $createdOfficer = $createdOfficer->toArray();
        $this->assertArrayHasKey('id', $createdOfficer);
        $this->assertNotNull($createdOfficer['id'], 'Created Officer must have id specified');
        $this->assertNotNull(Officer::find($createdOfficer['id']), 'Officer with given id must be in DB');
        $this->assertModelData($officer, $createdOfficer);
    }

    /**
     * @test read
     */
    public function test_read_officer()
    {
        $officer = Officer::factory()->create();

        $dbOfficer = $this->officerRepo->find($officer->id);

        $dbOfficer = $dbOfficer->toArray();
        $this->assertModelData($officer->toArray(), $dbOfficer);
    }

    /**
     * @test update
     */
    public function test_update_officer()
    {
        $officer = Officer::factory()->create();
        $fakeOfficer = Officer::factory()->make()->toArray();

        $updatedOfficer = $this->officerRepo->update($fakeOfficer, $officer->id);

        $this->assertModelData($fakeOfficer, $updatedOfficer->toArray());
        $dbOfficer = $this->officerRepo->find($officer->id);
        $this->assertModelData($fakeOfficer, $dbOfficer->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_officer()
    {
        $officer = Officer::factory()->create();

        $resp = $this->officerRepo->delete($officer->id);

        $this->assertTrue($resp);
        $this->assertNull(Officer::find($officer->id), 'Officer should not exist in DB');
    }
}
