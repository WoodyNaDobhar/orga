<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Meetup;

class MeetupApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_meetup()
    {
        $meetup = Meetup::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/meetups', $meetup
        );

        $this->assertApiResponse($meetup);
    }

    /**
     * @test
     */
    public function test_read_meetup()
    {
        $meetup = Meetup::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/meetups/'.$meetup->id
        );

        $this->assertApiResponse($meetup->toArray());
    }

    /**
     * @test
     */
    public function test_update_meetup()
    {
        $meetup = Meetup::factory()->create();
        $editedMeetup = Meetup::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/meetups/'.$meetup->id,
            $editedMeetup
        );

        $this->assertApiResponse($editedMeetup);
    }

    /**
     * @test
     */
    public function test_delete_meetup()
    {
        $meetup = Meetup::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/meetups/'.$meetup->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/meetups/'.$meetup->id
        );

        $this->response->assertStatus(404);
    }
}
