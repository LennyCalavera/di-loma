<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Disease
 * @package App\Models
 * @property string $name
 * @property string $description
 */
class Disease extends Model
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
		'name' => 'string',
		'description' => 'string'
	];
	protected $dates = ['deleted_at'];


	public $fillable = [
		'name',
		'description'
	];
	/**
	 * Validation rules
	 * @var array
	 */
	public static $rules = [
		'name' => 'required|string|max:191',
		'description' => 'required|string',
		'created_at' => 'nullable',
		'updated_at' => 'nullable'
	];
	public $table = 'diseases';


}
