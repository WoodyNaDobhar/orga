<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Crat;

class CratApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_crat()
    {
        $crat = Crat::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/crats', $crat
        );

        $this->assertApiResponse($crat);
    }

    /**
     * @test
     */
    public function test_read_crat()
    {
        $crat = Crat::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/crats/'.$crat->id
        );

        $this->assertApiResponse($crat->toArray());
    }

    /**
     * @test
     */
    public function test_update_crat()
    {
        $crat = Crat::factory()->create();
        $editedCrat = Crat::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/crats/'.$crat->id,
            $editedCrat
        );

        $this->assertApiResponse($editedCrat);
    }

    /**
     * @test
     */
    public function test_delete_crat()
    {
        $crat = Crat::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/crats/'.$crat->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/crats/'.$crat->id
        );

        $this->response->assertStatus(404);
    }
}
