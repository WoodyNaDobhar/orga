<?php

namespace App\Repositories;

use App\Models\Recommendation;
use App\Repositories\BaseRepository;

class RecommendationRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'user_id',
        'award_id',
        'rank',
        'is_anonymous',
        'reason'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Recommendation::class;
    }
}
