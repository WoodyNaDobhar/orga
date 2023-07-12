<?php

namespace Tests\Repositories;

use App\Models\Meetup;
use App\Repositories\MeetupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class MeetupRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected MeetupRepository $meetupRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->meetupRepo = app(MeetupRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_meetup()
    {
        $meetup = Meetup::factory()->make()->toArray();

        $createdMeetup = $this->meetupRepo->create($meetup);

        $createdMeetup = $createdMeetup->toArray();
        $this->assertArrayHasKey('id', $createdMeetup);
        $this->assertNotNull($createdMeetup['id'], 'Created Meetup must have id specified');
        $this->assertNotNull(Meetup::find($createdMeetup['id']), 'Meetup with given id must be in DB');
        $this->assertModelData($meetup, $createdMeetup);
    }

    /**
     * @test read
     */
    public function test_read_meetup()
    {
        $meetup = Meetup::factory()->create();

        $dbMeetup = $this->meetupRepo->find($meetup->id);

        $dbMeetup = $dbMeetup->toArray();
        $this->assertModelData($meetup->toArray(), $dbMeetup);
    }

    /**
     * @test update
     */
    public function test_update_meetup()
    {
        $meetup = Meetup::factory()->create();
        $fakeMeetup = Meetup::factory()->make()->toArray();

        $updatedMeetup = $this->meetupRepo->update($fakeMeetup, $meetup->id);

        $this->assertModelData($fakeMeetup, $updatedMeetup->toArray());
        $dbMeetup = $this->meetupRepo->find($meetup->id);
        $this->assertModelData($fakeMeetup, $dbMeetup->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_meetup()
    {
        $meetup = Meetup::factory()->create();

        $resp = $this->meetupRepo->delete($meetup->id);

        $this->assertTrue($resp);
        $this->assertNull(Meetup::find($meetup->id), 'Meetup should not exist in DB');
    }
}
