<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;

class CompaniesController extends Controller
{

    /**
     * Returns products index view
     * */
    public function index(){
        $companies = Company::all();

        return view('companies.desktop.index', compact('companies'));
    }

} // end of controller
