<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
    public function index(){
        return CategoryResource::collection(Category::all());
    }
}
