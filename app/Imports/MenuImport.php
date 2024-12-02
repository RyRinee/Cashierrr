<?php

namespace App\Imports;

use App\Models\Menu;
use Maatwebsite\Excel\Concerns\ToModel;

class MenuImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Menu([
            'name' => $row[0],
            'category' => $row[1],
            'price' => $row[2],
            'stock' => $row[3],
            'status' => $row[4]
        ]);
    }
}
