<?php

namespace App\Excel\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;

class CustomImport implements ToArray
{
    /**
     * Convert the Excel file into an array of objects.
     *
     * @param array $array
     */
    public function array(array $array)
    {
        return $array;
    }
}
