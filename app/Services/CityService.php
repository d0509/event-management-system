<?php
namespace App\Services;

use App\Models\City;

class CityService{

    public function collection(){
       return City::all();
    }  

}
