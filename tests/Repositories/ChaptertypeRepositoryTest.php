<?php

namespace Tests\Repositories;

use App\Models\Chaptertype;
use App\Repositories\ChaptertypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ChaptertypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected ChaptertypeRepository $chaptertypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->chaptertypeRepo = app(ChaptertypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_chaptertype()
    {
        $chaptertype = Chaptertype::factory()->make()->toArray();

        $createdChaptertype = $this->chaptertypeRepo->create($chaptertype);

        $createdChaptertype = $createdChaptertype->toArray();
        $this->assertArrayHasKey('id', $createdChaptertype);
        $this->assertNotNull($createdChaptertype['id'], 'Created Chaptertype must have id specified');
        $this->assertNotNull(Chaptertype::find($createdChaptertype['id']), 'Chaptertype with given id must be in DB');
        $this->assertModelData($chaptertype, $createdChaptertype);
    }

    /**
     * @test read
     */
    public function test_read_chaptertype()
    {
        $chaptertype = Chaptertype::factory()->create();

        $dbChaptertype = $this->chaptertypeRepo->find($chaptertype->id);

        $dbChaptertype = $dbChaptertype->toArray();
        $this->assertModelData($chaptertype->toArray(), $dbChaptertype);
    }

    /**
     * @test update
     */
    public function test_update_chaptertype()
    {
        $chaptertype = Chaptertype::factory()->create();
        $fakeChaptertype = Chaptertype::factory()->make()->toArray();

        $updatedChaptertype = $this->chaptertypeRepo->update($fakeChaptertype, $chaptertype->id);

        $this->assertModelData($fakeChaptertype, $updatedChaptertype->toArray());
        $dbChaptertype = $this->chaptertypeRepo->find($chaptertype->id);
        $this->assertModelData($fakeChaptertype, $dbChaptertype->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_chaptertype()
    {
        $chaptertype = Chaptertype::factory()->create();

        $resp = $this->chaptertypeRepo->delete($chaptertype->id);

        $this->assertTrue($resp);
        $this->assertNull(Chaptertype::find($chaptertype->id), 'Chaptertype should not exist in DB');
    }
}
