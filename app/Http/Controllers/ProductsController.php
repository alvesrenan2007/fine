<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class ProductsController extends Controller
{

    /**
     * Returns products index view
     * */
    public function index(){

        $products = Product::all();
        return view('products.desktop.index', compact('products'));
    }

    public function create(){
        $categories = Category::all() ?? collect();
        return view('products.desktop.create', compact('categories'));
    }

    public function edit(int $product_id){
        $product = Product::find($product_id);
        abort_if(!$product, 400);
        $categories = Category::all() ?? collect();

        return view('products.desktop.edit', compact('product', 'categories'));
    }

    public function store(Request $request){
        // Data Validation
        $validated = $request->validate([
            'product-name' => 'required|string|max:255',
            'product-cost' => 'required|numeric',
            'product-category' => 'required|integer'
        ]);

        abort_if(!Category::whereKey($validated['product-category'])->exists(), 400);

        // Database Transaction
        $product = new Product();
        $product->name = $validated['product-name'];
        $product->cost = $validated['product-cost'];
        $product->category_id = $validated['product-category'];
        $product->save();

        session()->flash('success', 'Produto cadastrado com sucesso!');
        return redirect()->route('products.index');

    }

    public function update(Request $request, int $product_id){
        // Data Validation
        $validated = $request->validate([
            'product-name' => 'required|string|max:255',
            'product-cost' => 'required|numeric',
            'product-category' => 'required|integer'
        ]);

        abort_if(!Category::whereKey($validated['product-category'])->exists(), 400);

        $product = Product::find($product_id);
        abort_if(!$product, 400);

        // Database Transaction
        $product->name = $validated['product-name'];
        $product->cost = $validated['product-cost'];
        $product->category_id = $validated['product-category'];
        $product->save();

        session()->flash('success', 'Produto editado com sucesso!');
        return redirect()->route('products.index');
    }

    public function delete($product_id){
        $product = Product::find($product_id);
        abort_if(!$product, 400);

        $product->delete();

        session()->flash('success', 'Produto deletado com sucesso');
        return redirect()->route('products.index');
    }

} // end of controller
