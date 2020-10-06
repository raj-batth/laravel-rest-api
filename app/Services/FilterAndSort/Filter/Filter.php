<?php

namespace App\Services\FilterAndSort\Filter;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class Filter
{
    private $tableColumns;
    private $excludeQueryParamsFromFilter;
    private $queryParametersForFiltering;

    public function __construct($tableColumns)
    {
        $this->tableColumns = collect($tableColumns);
        $this->excludeQueryParamsFromFilter =
            explode(
                ',',
                'sort_by,desc,per_page,unique,page'
            );
    }

    /**
     *  ! Unsetting all the Query Parameters which are not being used to Filter the collection
     *      ? Because, $collection = $collection->where($query, $value); used in the 'Filter logic' returns nothing when encountering these Query parameters   
     */
    private function prepareQueryParamsForFilter()
    {
        $this->queryParametersForFiltering = Request::query();
        foreach ($this->excludeQueryParamsFromFilter as $value) {
            unset($this->queryParametersForFiltering[$value]);
        }
        Log::info('queryParametersForFiltering');
        Log::info($this->queryParametersForFiltering);
    }

    /**
     * ! Validating the Query parameters being used inside the filterCollection()
     * ! Throw the HttpException if the following coditions are not met: 
     *      ? 1. If 'const ENABLE_FILTER_AND_SORT_ON_COLUMNS' is defined inside the MODEL
     *          * Then the Query parameter must be one of the FILTER_ENABLED_COLUMNS's values  
     *      ? 2. Else
     *          * The query parameter must be one of the tables's columns    
     */
    private function validate()
    {
        foreach ($this->queryParametersForFiltering as $key => $value) {
            $search = $this->tableColumns->search($key);
            Log::info($search);
            $exist = $search >= 0 && isset($search) ? 1 : 0;
            if ($exist === 0) {
                abort(response([
                    "message" => "unprocessable_entity.",
                    "errors" => [
                        "${key}" => [
                            "The ${key} field is not allowed."
                        ]
                    ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY));
            }
        }
    }

    private function filterCollection(Collection $collection)
    {
        Log::info($this->queryParametersForFiltering);
        foreach ($this->queryParametersForFiltering as $query => $value) {
            /**
             *  ? The Query Parameter must be present and has a value.
             *  *    AND
             *  ? The query parameter must be one of the table field's or is defined inside the 'const ENABLE_FILTER_FOR_COLUMNS' in the corresponding Model.       
             *      * Need Ternary operation to return 'boolean' for Query parameter 'id':
             *          * Since $collection->search() returns 0 for the Query parameter 'id' which is mostly at the 0th index in all the database tables
             *          * And 0 inside the If condition will fail the condition resulting in Non-filtered results  
             */
            if (isset($query, $value) && ($this->tableColumns->search($query) >= 0 ? true : false)) {
                $collection = $collection->where($query, $value);
            }
        }

        return $collection;
    }

    public function apply(Collection $collection)
    {
        $this->prepareQueryParamsForFilter();
        $this->validate();
        return $this->filterCollection($collection);
    }
}
