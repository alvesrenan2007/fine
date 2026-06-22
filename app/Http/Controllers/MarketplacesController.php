<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Marketplace;
use App\Models\MarketplaceFee;
use Illuminate\Http\Request;

class MarketplacesController extends Controller
{

    /**
     * Returns a view to show all marketplacs
     * */
    public function index()
    {
        $marketplaces = Marketplace::all();
        $categories = Category::all();
        $marketplaces->map(function($marketplace) use($categories){
            $marketplace->fees = MarketplaceFee::where('marketplace_id', $marketplace->id)
                ->get()
                ->map(function($fee) use ($categories){
                    $fee->category_name = $categories->get($fee->category_id)?->name ?? 'Categoria Desconhecida';
                    return $fee;
                });
                return $marketplace;
        });
        return view('marketplaces.desktop.index', compact('marketplaces'));
    }

    /**
     * Returns a view to register new marketplaces
     */
    public function create()
    {
        return view('marketplaces.desktop.create');
    }

    /**
     * Returns a view to edit a marketplace
     */
    public function edit($marketplace_id)
    {
        $marketplace = Marketplace::find($marketplace_id);
        abort_if(!$marketplace, 404);
        return view('marketplaces.desktop.edit', compact($marketplace));
    }

    /*
     * Stores the marketplace data on the database
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /*
     * Updates the marketplace data
     */
    public function update(Request $request, $marketplace_id)
    {
        dd($request, $marketplace_id);
    }

    /**
     * Deletes a marketplace instance from the database
     */
    public function delete($marketplace_id)
    {
        dd($marketplace_id);
    }
} //end of controller
