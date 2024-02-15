<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::limit(10)->get();

        $brands = Brand::limit(6)->get();

        $products = Product::forMainPage()->orderBy('sorting')->limit(8)->get();

        return view('welcome', compact(
            'categories', 'brands', 'products'));
    }
}
