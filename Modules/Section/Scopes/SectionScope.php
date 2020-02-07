<?php

namespace Modules\Section\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SectionScope implements Scope
{
  public function apply(Builder $builder, Model $model)
  {
    if(session('section')) {
      $builder->whereHas('sections', function($query) {
        $query->where('section_id',  session('section'));
      });
    }
  }
}