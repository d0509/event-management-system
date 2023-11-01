<?php
 
namespace App\Services;

use App\Models\Category;
class CategoryService{
    public function collection(){
      return Category::all();        
    }
}


?>