<?php

namespace Tests\Repositories;

use App\Models\Configuration;
use App\Repositories\ConfigurationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ConfigurationRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected ConfigurationRepository $configurationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->configurationRepo = app(ConfigurationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_configuration()
    {
        $configuration = Configuration::factory()->make()->toArray();

        $createdConfiguration = $this->configurationRepo->create($configuration);

        $createdConfiguration = $createdConfiguration->toArray();
        $this->assertArrayHasKey('id', $createdConfiguration);
        $this->assertNotNull($createdConfiguration['id'], 'Created Configuration must have id specified');
        $this->assertNotNull(Configuration::find($createdConfiguration['id']), 'Configuration with given id must be in DB');
        $this->assertModelData($configuration, $createdConfiguration);
    }

    /**
     * @test read
     */
    public function test_read_configuration()
    {
        $configuration = Configuration::factory()->create();

        $dbConfiguration = $this->configurationRepo->find($configuration->id);

        $dbConfiguration = $dbConfiguration->toArray();
        $this->assertModelData($configuration->toArray(), $dbConfiguration);
    }

    /**
     * @test update
     */
    public function test_update_configuration()
    {
        $configuration = Configuration::factory()->create();
        $fakeConfiguration = Configuration::factory()->make()->toArray();

        $updatedConfiguration = $this->configurationRepo->update($fakeConfiguration, $configuration->id);

        $this->assertModelData($fakeConfiguration, $updatedConfiguration->toArray());
        $dbConfiguration = $this->configurationRepo->find($configuration->id);
        $this->assertModelData($fakeConfiguration, $dbConfiguration->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_configuration()
    {
        $configuration = Configuration::factory()->create();

        $resp = $this->configurationRepo->delete($configuration->id);

        $this->assertTrue($resp);
        $this->assertNull(Configuration::find($configuration->id), 'Configuration should not exist in DB');
    }
}
