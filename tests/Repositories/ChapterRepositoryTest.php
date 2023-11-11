<?php

namespace Tests\Repositories;

use App\Models\Chapter;
use App\Repositories\ChapterRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ChapterRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected ChapterRepository $chapterRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->chapterRepo = app(ChapterRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_chapter()
    {
        $chapter = Chapter::factory()->make()->toArray();

        $createdChapter = $this->chapterRepo->create($chapter);

        $createdChapter = $createdChapter->toArray();
        $this->assertArrayHasKey('id', $createdChapter);
        $this->assertNotNull($createdChapter['id'], 'Created Chapter must have id specified');
        $this->assertNotNull(Chapter::find($createdChapter['id']), 'Chapter with given id must be in DB');
        $this->assertModelData($chapter, $createdChapter);
    }

    /**
     * @test read
     */
    public function test_read_chapter()
    {
        $chapter = Chapter::factory()->create();

        $dbChapter = $this->chapterRepo->find($chapter->id);

        $dbChapter = $dbChapter->toArray();
        $this->assertModelData($chapter->toArray(), $dbChapter);
    }

    /**
     * @test update
     */
    public function test_update_chapter()
    {
        $chapter = Chapter::factory()->create();
        $fakeChapter = Chapter::factory()->make()->toArray();

        $updatedChapter = $this->chapterRepo->update($fakeChapter, $chapter->id);

        $this->assertModelData($fakeChapter, $updatedChapter->toArray());
        $dbChapter = $this->chapterRepo->find($chapter->id);
        $this->assertModelData($fakeChapter, $dbChapter->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_chapter()
    {
        $chapter = Chapter::factory()->create();

        $resp = $this->chapterRepo->delete($chapter->id);

        $this->assertTrue($resp);
        $this->assertNull(Chapter::find($chapter->id), 'Chapter should not exist in DB');
    }
}
