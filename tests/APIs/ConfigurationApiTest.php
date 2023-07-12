<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Configuration;

class ConfigurationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_configuration()
    {
        $configuration = Configuration::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/configurations', $configuration
        );

        $this->assertApiResponse($configuration);
    }

    /**
     * @test
     */
    public function test_read_configuration()
    {
        $configuration = Configuration::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/configurations/'.$configuration->id
        );

        $this->assertApiResponse($configuration->toArray());
    }

    /**
     * @test
     */
    public function test_update_configuration()
    {
        $configuration = Configuration::factory()->create();
        $editedConfiguration = Configuration::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/configurations/'.$configuration->id,
            $editedConfiguration
        );

        $this->assertApiResponse($editedConfiguration);
    }

    /**
     * @test
     */
    public function test_delete_configuration()
    {
        $configuration = Configuration::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/configurations/'.$configuration->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/configurations/'.$configuration->id
        );

        $this->response->assertStatus(404);
    }
}
