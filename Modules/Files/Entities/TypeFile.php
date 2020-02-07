<?php
/**
 * Created by PhpStorm.
 * User: alexsandro
 * Date: 24.10.17
 * Time: 11:20
 */

namespace Modules\Files\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeFile extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $guarded = [];

  protected $casts = [
    'config' => 'collection',
  ];

  public function files() {
    return $this->hasMany(File::class);
  }

  /**
   * Get maxsize file
   *
   * @return integer
   */
  public function getMaxsizeAttribute()
  {
    return $this->config->get('maxsize')?:45*1024;
  }

  /**
   * Get allowed extensions for file
   * @return string
   */
  public function getExtensionsAttribute()
  {
    return $this->config->get('ext');
  }

  /**
   * Get resize values
   *
   * @return null
   */
  public function getResizeAttribute()
  {
    return $this->config->get('resize');
  }
}