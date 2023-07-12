<?php

namespace Tests\Repositories;

use App\Models\Award;
use App\Repositories\AwardRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AwardRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected AwardRepository $awardRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->awardRepo = app(AwardRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_award()
    {
        $award = Award::factory()->make()->toArray();

        $createdAward = $this->awardRepo->create($award);

        $createdAward = $createdAward->toArray();
        $this->assertArrayHasKey('id', $createdAward);
        $this->assertNotNull($createdAward['id'], 'Created Award must have id specified');
        $this->assertNotNull(Award::find($createdAward['id']), 'Award with given id must be in DB');
        $this->assertModelData($award, $createdAward);
    }

    /**
     * @test read
     */
    public function test_read_award()
    {
        $award = Award::factory()->create();

        $dbAward = $this->awardRepo->find($award->id);

        $dbAward = $dbAward->toArray();
        $this->assertModelData($award->toArray(), $dbAward);
    }

    /**
     * @test update
     */
    public function test_update_award()
    {
        $award = Award::factory()->create();
        $fakeAward = Award::factory()->make()->toArray();

        $updatedAward = $this->awardRepo->update($fakeAward, $award->id);

        $this->assertModelData($fakeAward, $updatedAward->toArray());
        $dbAward = $this->awardRepo->find($award->id);
        $this->assertModelData($fakeAward, $dbAward->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_award()
    {
        $award = Award::factory()->create();

        $resp = $this->awardRepo->delete($award->id);

        $this->assertTrue($resp);
        $this->assertNull(Award::find($award->id), 'Award should not exist in DB');
    }
}
