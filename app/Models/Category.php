<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //  protected $table = 'my_categories'; // 👈 Custom table name
    protected $fillable=['order','name'];
}
