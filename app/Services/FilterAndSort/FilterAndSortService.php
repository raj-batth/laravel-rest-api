<?php

namespace App\Services\FilterAndSort;

use App\Services\FilterAndSort\Filter\Filter;
use App\Services\FilterAndSort\Sort\Sort;
use ReflectionClass;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

class FilterAndSortService
{
    private $tableColumns;

    public function __construct()
    {
        // 
    }

    private function getColumns(Model $model)
    {
        $tableName =  $model->getTable();
        $this->tableColumns = Schema::getColumnListing($tableName);
    }

    // Receiving the Collection and Model instance
    public function apply(Collection $collection, Model $model)
    {
        $this->getColumns($model);

        // FILTERING
        $filter = new Filter($this->tableColumns);
        $filteredCollection = $filter->apply($collection);

        // SORTING
        $sort = new Sort($this->tableColumns);
        $filteredAndSortedCollection = $sort->apply($filteredCollection);

        return $filteredAndSortedCollection;
    }
}
