<?php

namespace Tests\Repositories;

use App\Models\Social;
use App\Repositories\SocialRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SocialRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected SocialRepository $socialRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->socialRepo = app(SocialRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_social()
    {
        $social = Social::factory()->make()->toArray();

        $createdSocial = $this->socialRepo->create($social);

        $createdSocial = $createdSocial->toArray();
        $this->assertArrayHasKey('id', $createdSocial);
        $this->assertNotNull($createdSocial['id'], 'Created Social must have id specified');
        $this->assertNotNull(Social::find($createdSocial['id']), 'Social with given id must be in DB');
        $this->assertModelData($social, $createdSocial);
    }

    /**
     * @test read
     */
    public function test_read_social()
    {
        $social = Social::factory()->create();

        $dbSocial = $this->socialRepo->find($social->id);

        $dbSocial = $dbSocial->toArray();
        $this->assertModelData($social->toArray(), $dbSocial);
    }

    /**
     * @test update
     */
    public function test_update_social()
    {
        $social = Social::factory()->create();
        $fakeSocial = Social::factory()->make()->toArray();

        $updatedSocial = $this->socialRepo->update($fakeSocial, $social->id);

        $this->assertModelData($fakeSocial, $updatedSocial->toArray());
        $dbSocial = $this->socialRepo->find($social->id);
        $this->assertModelData($fakeSocial, $dbSocial->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_social()
    {
        $social = Social::factory()->create();

        $resp = $this->socialRepo->delete($social->id);

        $this->assertTrue($resp);
        $this->assertNull(Social::find($social->id), 'Social should not exist in DB');
    }
}
