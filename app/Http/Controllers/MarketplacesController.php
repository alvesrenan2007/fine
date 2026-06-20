<?php

namespace App\Http\Controllers;

use App\Models\Marketplace;
use Illuminate\Http\Request;

class MarketplacesController extends Controller
{

    /**
     * Returns a view to show all marketplacs
     * */
    public function index()
    {
        $marketplaces = Marketplace::all();
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
