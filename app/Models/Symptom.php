<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use phpDocumentor\Reflection\Types\This;

/**
 * Class Symptom
 * @package App\Models
 *
 * @property string $name
 * @property integer $minBorder
 * @property integer $maxBorder
 */
class Symptom extends Model
{
    use HasFactory;

    public $table = 'symptoms';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
		'minBorder',
		'maxBorder'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
		'minBorder' => 'int',
		'maxBorder' => 'int'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:191',
		'minBorder' => 'nullable',
		'maxBorder' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
