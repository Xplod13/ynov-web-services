<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Filterable;

    private static $whiteListFilter =[
        'name',
    ];

    protected $fillable = [
        "name",
    ];
}
