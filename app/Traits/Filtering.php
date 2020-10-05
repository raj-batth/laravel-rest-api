<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait Filtering
{

  protected function filterData(Collection $collection)
  {
    foreach (request()->query() as $query => $value) {
      $attribute = $query;
      if (isset($attribute, $value) && $attribute != 'sort_by') {
        $collection = $collection->where($attribute, $value);
      }
    }
    return $collection;
  }
}
