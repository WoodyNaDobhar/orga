<?php

namespace Tests\Repositories;

use App\Models\Split;
use App\Repositories\SplitRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SplitRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected SplitRepository $splitRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->splitRepo = app(SplitRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_split()
    {
        $split = Split::factory()->make()->toArray();

        $createdSplit = $this->splitRepo->create($split);

        $createdSplit = $createdSplit->toArray();
        $this->assertArrayHasKey('id', $createdSplit);
        $this->assertNotNull($createdSplit['id'], 'Created Split must have id specified');
        $this->assertNotNull(Split::find($createdSplit['id']), 'Split with given id must be in DB');
        $this->assertModelData($split, $createdSplit);
    }

    /**
     * @test read
     */
    public function test_read_split()
    {
        $split = Split::factory()->create();

        $dbSplit = $this->splitRepo->find($split->id);

        $dbSplit = $dbSplit->toArray();
        $this->assertModelData($split->toArray(), $dbSplit);
    }

    /**
     * @test update
     */
    public function test_update_split()
    {
        $split = Split::factory()->create();
        $fakeSplit = Split::factory()->make()->toArray();

        $updatedSplit = $this->splitRepo->update($fakeSplit, $split->id);

        $this->assertModelData($fakeSplit, $updatedSplit->toArray());
        $dbSplit = $this->splitRepo->find($split->id);
        $this->assertModelData($fakeSplit, $dbSplit->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_split()
    {
        $split = Split::factory()->create();

        $resp = $this->splitRepo->delete($split->id);

        $this->assertTrue($resp);
        $this->assertNull(Split::find($split->id), 'Split should not exist in DB');
    }
}
