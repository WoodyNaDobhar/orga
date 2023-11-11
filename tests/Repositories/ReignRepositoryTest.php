<?php

namespace Tests\Repositories;

use App\Models\Reign;
use App\Repositories\ReignRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ReignRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected ReignRepository $reignRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->reignRepo = app(ReignRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_reign()
    {
        $reign = Reign::factory()->make()->toArray();

        $createdReign = $this->reignRepo->create($reign);

        $createdReign = $createdReign->toArray();
        $this->assertArrayHasKey('id', $createdReign);
        $this->assertNotNull($createdReign['id'], 'Created Reign must have id specified');
        $this->assertNotNull(Reign::find($createdReign['id']), 'Reign with given id must be in DB');
        $this->assertModelData($reign, $createdReign);
    }

    /**
     * @test read
     */
    public function test_read_reign()
    {
        $reign = Reign::factory()->create();

        $dbReign = $this->reignRepo->find($reign->id);

        $dbReign = $dbReign->toArray();
        $this->assertModelData($reign->toArray(), $dbReign);
    }

    /**
     * @test update
     */
    public function test_update_reign()
    {
        $reign = Reign::factory()->create();
        $fakeReign = Reign::factory()->make()->toArray();

        $updatedReign = $this->reignRepo->update($fakeReign, $reign->id);

        $this->assertModelData($fakeReign, $updatedReign->toArray());
        $dbReign = $this->reignRepo->find($reign->id);
        $this->assertModelData($fakeReign, $dbReign->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_reign()
    {
        $reign = Reign::factory()->create();

        $resp = $this->reignRepo->delete($reign->id);

        $this->assertTrue($resp);
        $this->assertNull(Reign::find($reign->id), 'Reign should not exist in DB');
    }
}
