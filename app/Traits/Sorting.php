<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait Sorting
{
  use Filtering;
  protected function sortData(Collection $collection)
  {
    $collection = $this->filterData($collection);
    if (request()->has('sort_by')) {
      $attribute = request()->sort_by;
      $collection = $collection->sortBy($attribute);
    }
    return $collection;
  }
 
}
