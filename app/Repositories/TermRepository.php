<?php

namespace App\Repositories;

use App\Models\Term;
use App\Repositories\BaseRepository;

/**
 * Class TermRepository
 * @package App\Repositories
*/

class TermRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'minBorder',
        'maxBorder'
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
        return Term::class;
    }
}
