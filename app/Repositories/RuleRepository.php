<?php

namespace App\Repositories;

use App\Models\Rule;
use App\Repositories\BaseRepository;

/**
 * Class RuleRepository
 * @package App\Repositories
*/

class RuleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'conditions',
        'disease',
        'weight'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Rule::class;
    }
}
