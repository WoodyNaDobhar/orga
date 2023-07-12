<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Award;

class AwardApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_award()
    {
        $award = Award::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/awards', $award
        );

        $this->assertApiResponse($award);
    }

    /**
     * @test
     */
    public function test_read_award()
    {
        $award = Award::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/awards/'.$award->id
        );

        $this->assertApiResponse($award->toArray());
    }

    /**
     * @test
     */
    public function test_update_award()
    {
        $award = Award::factory()->create();
        $editedAward = Award::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/awards/'.$award->id,
            $editedAward
        );

        $this->assertApiResponse($editedAward);
    }

    /**
     * @test
     */
    public function test_delete_award()
    {
        $award = Award::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/awards/'.$award->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/awards/'.$award->id
        );

        $this->response->assertStatus(404);
    }
}
