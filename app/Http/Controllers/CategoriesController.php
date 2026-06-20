<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        dd('to be implemented');
    }

    public function create()
    {
        dd('to be implemented');
    }

    public function edit(int $category_id)
    {
        dd('to be implemented', $category_id);
    }

    public function store(Request $request)
    {
        dd('to be implemented', $request);
    }

    public function update(Request $request, $category_id)
    {
        dd('to be implemented', $request, $category_id);
    }
}
