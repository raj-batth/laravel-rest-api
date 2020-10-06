<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

trait Paginate
{

  protected function paginate(Collection $collection)
  {
    $page = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 15;
    $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

    $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
      'path' => LengthAwarePaginator::resolveCurrentPath(),   // resolveCurrentPath() will generate the path for another page in the META shown in the GET request
    ]);
    $paginated->appends(request()->all());
    return $paginated;
  }
}
