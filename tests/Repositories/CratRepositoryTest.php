<?php

namespace Tests\Repositories;

use App\Models\Crat;
use App\Repositories\CratRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CratRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected CratRepository $cratRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->cratRepo = app(CratRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_crat()
    {
        $crat = Crat::factory()->make()->toArray();

        $createdCrat = $this->cratRepo->create($crat);

        $createdCrat = $createdCrat->toArray();
        $this->assertArrayHasKey('id', $createdCrat);
        $this->assertNotNull($createdCrat['id'], 'Created Crat must have id specified');
        $this->assertNotNull(Crat::find($createdCrat['id']), 'Crat with given id must be in DB');
        $this->assertModelData($crat, $createdCrat);
    }

    /**
     * @test read
     */
    public function test_read_crat()
    {
        $crat = Crat::factory()->create();

        $dbCrat = $this->cratRepo->find($crat->id);

        $dbCrat = $dbCrat->toArray();
        $this->assertModelData($crat->toArray(), $dbCrat);
    }

    /**
     * @test update
     */
    public function test_update_crat()
    {
        $crat = Crat::factory()->create();
        $fakeCrat = Crat::factory()->make()->toArray();

        $updatedCrat = $this->cratRepo->update($fakeCrat, $crat->id);

        $this->assertModelData($fakeCrat, $updatedCrat->toArray());
        $dbCrat = $this->cratRepo->find($crat->id);
        $this->assertModelData($fakeCrat, $dbCrat->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_crat()
    {
        $crat = Crat::factory()->create();

        $resp = $this->cratRepo->delete($crat->id);

        $this->assertTrue($resp);
        $this->assertNull(Crat::find($crat->id), 'Crat should not exist in DB');
    }
}
