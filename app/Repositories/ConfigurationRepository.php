<?php

namespace App\Repositories;

use App\Models\Configuration;
use App\Repositories\BaseRepository;

class ConfigurationRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'configurable_type',
        'configurable_id',
        'key',
        'value',
        'is_user_setting',
        'allowed_values',
        'modified',
        'var_type'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Configuration::class;
    }
}
