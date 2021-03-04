<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Company;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        $data = Company::all();
        return Inertia::render('Companies/Index', ['data' => $data]);
    }

    public function create()
    {
        $types = \App\Models\Company::all()->map->only('id','name');
        $first = \App\Models\Company::all('id','name')->first();

        return Inertia::render('Companies/Create',['types' => $types, 'first' => $first]);
    }

    public function store()
    {
        Request::validate([
          //  'type' => ['required'],
            'name' => ['required'], 
			'address' => ['nullable'],
            'email' => ['nullable|email:rfc,dns'],
            'web' => ['nullable|active_url'],
            'phone' => ['nullable|numeric'],
            'fiscal' => ['required'],
            'incorp' =>  ['nullable|date']
        ]);

             Company::create([
			'name' => Request::input('name'),
			'address' => Request::input('address'),
			'email' => Request::input('email'),
			'web' => Request::input('web'),
			'phone' => Request::input('phone'),
			'fiscal' => Request::input('fiscal'),
			'incorp' => Request::input('incorp')
             ]);

        return Redirect::route('companies')->with('success', 'Company created.');
    }

    public function show(Company $company)
    {
        // <!-- <p'name','address','email','web','phone','fiscal','incorp','enabled' /> -->
    }

    public function edit(Company $company )
    {
        $types = \App\Models\Company::all()->map->only('id','name');
        return Inertia::render('Companies/Edit', [
            'company' => [
                'id' => $company->id,
              //  'type_id' => $company->type_id,
                'name' => $company->name,
                'address' => $company->address,
                'email' => $company->email,
                'web' => $company->web,
                'phone' => $company->phone,
                'fiscal' => $company->fiscal,
                'incorp' => $company->incorp,
            ],
            'types' => $types,
        ]);
    }

    public function update(Company $company)
    {
        Request::validate([
            // 'type' => ['required'],
            'name' => ['required'], 
			'address' => ['nullable'],
            'email' => ['nullable'],
            'web' => ['nullable'],
            'phone' => ['nullable'],
            'fiscal' => ['required'],
            'incorp' =>  ['nullable']
        ]);

        //$company->type_id = Request::input('type');
        $company->name = Request::input('name');
		$company->address = Request::input('address');
		$company->email = Request::input('email');
		$company->web = Request::input('web');
		$company->phone = Request::input('phone');
        $company->fiscal = Request::input('fiscal');
		$company->incorp = Request::input('incorp');
        $company->save();

        return Redirect::route('companies')->with('success', 'Company  updated.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return Redirect::back()->with('success', 'Company Deleted.');
    }
}
