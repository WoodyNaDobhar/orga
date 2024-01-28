<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Social;

class SocialApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_social()
    {
        $social = Social::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/socials', $social
        );

        $this->assertApiResponse($social);
    }

    /**
     * @test
     */
    public function test_read_social()
    {
        $social = Social::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/socials/'.$social->id
        );

        $this->assertApiResponse($social->toArray());
    }

    /**
     * @test
     */
    public function test_update_social()
    {
        $social = Social::factory()->create();
        $editedSocial = Social::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/socials/'.$social->id,
            $editedSocial
        );

        $this->assertApiResponse($editedSocial);
    }

    /**
     * @test
     */
    public function test_delete_social()
    {
        $social = Social::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/socials/'.$social->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/socials/'.$social->id
        );

        $this->response->assertStatus(404);
    }
}
