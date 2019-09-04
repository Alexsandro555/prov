<?php
namespace Modules\Callback\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Callback extends Model
{
	use SoftDeletes;

	protected $guarded=[];

	protected $dates = ['deleted_at','updated_at'];

  public $form = [
    'id' => [
      'enabled' => true
    ],
    'fio' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'max' => 255
      ]
    ],
    'telephone' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'max' => 50
      ]
    ]
  ];
}
