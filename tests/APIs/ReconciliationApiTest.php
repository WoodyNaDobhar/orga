<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Reconciliation;

class ReconciliationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_reconciliation()
    {
        $reconciliation = Reconciliation::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/reconciliations', $reconciliation
        );

        $this->assertApiResponse($reconciliation);
    }

    /**
     * @test
     */
    public function test_read_reconciliation()
    {
        $reconciliation = Reconciliation::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/reconciliations/'.$reconciliation->id
        );

        $this->assertApiResponse($reconciliation->toArray());
    }

    /**
     * @test
     */
    public function test_update_reconciliation()
    {
        $reconciliation = Reconciliation::factory()->create();
        $editedReconciliation = Reconciliation::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/reconciliations/'.$reconciliation->id,
            $editedReconciliation
        );

        $this->assertApiResponse($editedReconciliation);
    }

    /**
     * @test
     */
    public function test_delete_reconciliation()
    {
        $reconciliation = Reconciliation::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/reconciliations/'.$reconciliation->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/reconciliations/'.$reconciliation->id
        );

        $this->response->assertStatus(404);
    }
}
