<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Recommendation;

class RecommendationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_recommendation()
    {
        $recommendation = Recommendation::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/recommendations', $recommendation
        );

        $this->assertApiResponse($recommendation);
    }

    /**
     * @test
     */
    public function test_read_recommendation()
    {
        $recommendation = Recommendation::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/recommendations/'.$recommendation->id
        );

        $this->assertApiResponse($recommendation->toArray());
    }

    /**
     * @test
     */
    public function test_update_recommendation()
    {
        $recommendation = Recommendation::factory()->create();
        $editedRecommendation = Recommendation::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/recommendations/'.$recommendation->id,
            $editedRecommendation
        );

        $this->assertApiResponse($editedRecommendation);
    }

    /**
     * @test
     */
    public function test_delete_recommendation()
    {
        $recommendation = Recommendation::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/recommendations/'.$recommendation->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/recommendations/'.$recommendation->id
        );

        $this->response->assertStatus(404);
    }
}
