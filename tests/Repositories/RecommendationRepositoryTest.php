<?php

namespace Tests\Repositories;

use App\Models\Recommendation;
use App\Repositories\RecommendationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RecommendationRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected RecommendationRepository $recommendationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->recommendationRepo = app(RecommendationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_recommendation()
    {
        $recommendation = Recommendation::factory()->make()->toArray();

        $createdRecommendation = $this->recommendationRepo->create($recommendation);

        $createdRecommendation = $createdRecommendation->toArray();
        $this->assertArrayHasKey('id', $createdRecommendation);
        $this->assertNotNull($createdRecommendation['id'], 'Created Recommendation must have id specified');
        $this->assertNotNull(Recommendation::find($createdRecommendation['id']), 'Recommendation with given id must be in DB');
        $this->assertModelData($recommendation, $createdRecommendation);
    }

    /**
     * @test read
     */
    public function test_read_recommendation()
    {
        $recommendation = Recommendation::factory()->create();

        $dbRecommendation = $this->recommendationRepo->find($recommendation->id);

        $dbRecommendation = $dbRecommendation->toArray();
        $this->assertModelData($recommendation->toArray(), $dbRecommendation);
    }

    /**
     * @test update
     */
    public function test_update_recommendation()
    {
        $recommendation = Recommendation::factory()->create();
        $fakeRecommendation = Recommendation::factory()->make()->toArray();

        $updatedRecommendation = $this->recommendationRepo->update($fakeRecommendation, $recommendation->id);

        $this->assertModelData($fakeRecommendation, $updatedRecommendation->toArray());
        $dbRecommendation = $this->recommendationRepo->find($recommendation->id);
        $this->assertModelData($fakeRecommendation, $dbRecommendation->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_recommendation()
    {
        $recommendation = Recommendation::factory()->create();

        $resp = $this->recommendationRepo->delete($recommendation->id);

        $this->assertTrue($resp);
        $this->assertNull(Recommendation::find($recommendation->id), 'Recommendation should not exist in DB');
    }
}
