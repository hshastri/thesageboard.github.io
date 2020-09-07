<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategory(){
        return $this->hasMany(SubCategory::class, 'category_id');
    }
}
