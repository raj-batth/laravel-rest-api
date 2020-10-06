<?php

namespace App\Services\FilterAndSort\Sort;

use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class Sort
{
    private $tableColumns ;

    public function __construct($tableColumns)
    {
        $this->tableColumns = $tableColumns;

    }

    private function validate()
    {
        // ? Performing the Validation here to eliminate the need of creating the Request Validation for each Controller's Index method where SORTING will be used 
        Request::validate([
            'sort_by' => [
                'bail',         // 'bail' makes sure that the Request Stops on the First Validation Failure
                'sometimes',
                'required',
                Rule::in($this->tableColumns),  // The sort_by Query parameter could only use Columns defined inside the mode OR the table's original columns
            ],
            'desc' => 'bail|sometimes|required|string|in:true,false,1,0',
        ]);
    }

    private function sortCollection(Collection $collection)
    {
        if (Request::has('sort_by')) {
            $sortByQueryParameter = Request::input('sort_by');

            if (Request::has('desc') && Request::input('desc') === "true" || Request::input('desc') === "1") {
                $collection = $collection->sortByDesc->{$sortByQueryParameter}; // sortBy is a higher order Collection message  
            } else {
                $collection = $collection->sortBy->{$sortByQueryParameter};     // sortBy is a higher order Collection message
            }
        }

        return $collection;
    }

    public function apply(Collection $collection)
    {
        $this->validate();
        return $this->sortCollection($collection);
    }
}
