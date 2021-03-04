<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\DocumentType;
use Inertia\Inertia;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $data = DocumentType::all();
        return Inertia::render('DocumentTypes/Index', ['data' => $data]);
        
    }

    public function create()
    {
       

        $companies = \App\Models\Company::all()->map->only('id','name');
        $comp_first = \App\Models\Company::all('id','name')->first();

        return Inertia::render('DocumentTypes/Create'
        ,[
         'companies'=> $companies , 'comp_first'=> $comp_first 
         ]
        );

        
    }

    public function store()
    {

             Request::validate([
            'name' => ['required'],
            'prefix' => ['required'],
            'company' => ['required'],
        ]);
        

            DocumentType::create([
                'name' => Request::input('name'),
                'prefix' => Request::input('prefix'),
                'company_id' => Request::input('company'),  
        ]);

        return Redirect::route('doctypes')->with('success', 'Voucher created.');

    }


    public function show(DocumentType $doctype)
    {
        
    }

    public function edit(DocumentType $doctype)
    {
        // $groups = \App\Models\AccountGroup::all()->map->only('id','name');
        $companies = \App\Models\Company::all()->map->only('id','name');
        return Inertia::render('DocumentTypes/Edit', [
            'doctype' => [
                'id' => $doctype->id,
                'name' => $doctype->name,
                'prefix' => $doctype->prefix,
                'company_id' => $doctype->company_id,

            ],
            // 'groups' => $groups,
            'companies' => $companies,
            
            
        ]);
    }

    public function update(DocumentType $doctype)
    {
        Request::validate([
            'name' => ['required'],
            'prefix' => ['required'],
            'company' => ['required'],
        ]);

              
                $doctype->name = Request::input('name');
                $doctype->prefix = Request::input('prefix');
                $doctype->company_id = Request::input('company');


        $doctype->save();

        return Redirect::route('doctypes')->with('success', 'Voucher updated.');
    }
    

    public function destroy(DocumentType $doctype)
    {
        $doctype->delete();
        return Redirect::back()->with('success', 'Voucher Type Deleted.');
    }
}
