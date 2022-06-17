<?php

namespace App\Repositories;

use App\Models\Symptom;
use App\Repositories\BaseRepository;

/**
 * Class SymptomRepository
 * @package App\Repositories
*/

class SymptomRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
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
        return Symptom::class;
    }
}
