<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Term
 * @package App\Models
 * @property string $name
 * @property integer $minBorder
 * @property integer $maxBorder
 */
class Term extends Model
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
		'minBorder' => 'integer',
		'maxBorder' => 'integer'
	];
	protected $dates = ['deleted_at'];


	public $fillable = [
		'name',
		'minBorder',
		'maxBorder'
	];
	/**
	 * Validation rules
	 * @var array
	 */
	public static $rules = [
		'name' => 'required|string|max:191',
		'minBorder' => 'required|integer',
		'maxBorder' => 'required|integer',
		'created_at' => 'nullable',
		'updated_at' => 'nullable'
	];
	public $table = 'terms';


}
