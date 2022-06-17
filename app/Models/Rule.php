<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Rule
 * @package App\Models
 * @property string $conditions
 * @property string $disease
 * @property number $weight
 */
class Rule extends Model
{

	use HasFactory;

	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	/**
	 * The attributes that should be casted to native types.
	 * @var array
	 */
	protected $casts = [
		'id' => 'integer',
		'conditions' => 'string',
		'disease' => 'string',
		'weight' => 'float'
	];
	protected $dates = ['deleted_at'];


	public $fillable = [
		'conditions',
		'disease',
		'weight'
	];
	/**
	 * Validation rules
	 * @var array
	 */
	public static $rules = [
		'conditions' => 'required|string',
		'disease' => 'required',
		'weight' => 'required|numeric',
		'created_at' => 'nullable',
		'updated_at' => 'nullable'
	];
	public $table = 'rules';


}
