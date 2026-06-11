<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Company;
use App\Models\Marketplace;
use App\Models\MarketplaceFee;
use App\Models\Product;


class ReportsController extends Controller
{
    public function index(){
        $products = Product::all();
        $companies = Company::all();
        $marketplaces = Marketplace::all();
        return view('reports.desktop.index', compact('products', 'companies', 'marketplaces'));
    }

    public function byProduct(Request $request){
        $validated = $request->validate([
            'query-product' => 'required|integer',
            'query-company' => 'required|integer',
            'query-marketplace' => 'required|integer',
        ]);

        $product = Product::find($validated['query-product']) ?? null;
        $company = Company::find($validated['query-company']) ?? null;
        $marketplace = Marketplace::find($validated['query-marketplace']) ?? null;

        // If there is no specific company or marketplace, prepare the collections with all of them
        $companies = $company ? collect() : Companies::all();
        $marketplaces = $marketplace ? collect() : Marketplace::all();
        
        return view('reports.desktop.by_product', compact('product', 'company', 'marketplace', 'companies', 'marketplaces'));
    }

} // end of controller
