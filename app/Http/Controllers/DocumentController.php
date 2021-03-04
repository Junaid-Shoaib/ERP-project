<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Account;
use App\Models\Entry;
use App\Models\Year;
// use App\Models\Document;
// use App\Models\Year;
use Inertia\Inertia;

class DocumentController extends Controller
{
  

    public function index(){
        
        $data = Document::all();
        return Inertia::render('Documents/Index', ['data' => $data]);
        
    }
    
    public function create()
    {
    //     // $groups = \App\Models\AccountGroup::all()->map->only('id','name');
    //     // $group_first = \App\Models\AccountGroup::all('id','name')->first();

         $documents = \App\Models\DocumentType::all()->map->only('id','name');
        $doc_first = \App\Models\DocumentType::all('id','name')->first();

    //     $years = \App\Models\Year::all()->map->only('id','begin' ,'end');
    //     $year_first = \App\Models\Year::all('id','begin' ,'end')->first();

    //     $companies = \App\Models\Company::all()->map->only('id','name');
    //     $comp_first = \App\Models\Company::all('id','name')->first();
        
  
        return Inertia::render('Documents/Create',[
            'documents' => $documents, 'doc_first' => $doc_first

            
    //         , 'years' => $years, 'year_first' => $year_first
    //         , 'companies'=> $companies , 'comp_first'=> $comp_first
    ]);
            
            
        }
        
        public function store()
        {
    //         'ref', 'date','description','type_id','paid','posted','approved','enabled', 'company_id', 'year_id'
             
        Request::validate([
            'doc_type' => ['required'],
            'date'  => ['required'],
    //         'description'  => ['required'],
    //         'type_id'  => ['required'],
    //         'paid' => ['required'],
    //         'posted'  => ['required'],
    //         'approved'  => ['required'],
    //          'company' => ['required'],
    //          , 'year' => ['required'],
            // 'paid' => ['nullable']
            // 'posted' => ['required']
            // 'approved' => ['required']
        ]);

            Document::create([
            'document_id' => Request::input('doc_type'),
                'date' => Request::input('date'),
    //             'description' => Request::input('date'),
                
    //             'paid' => Request::input('name'),
    //             'company_id' => Request::input('company'),
    //             'year_id' => Request::input('year'),

        ]);

        return Redirect::route('documents')->with('success', 'Transaction created.');

    }


    // public function show(Account $account)
    // {
        
    // }

    // public function edit(Account $account)
    // {
    //     $groups = \App\Models\AccountGroup::all()->map->only('id','name');
    //     $companies = \App\Models\Company::all()->map->only('id','name');
    //     return Inertia::render('Accounts/Edit', [
    //         'account' => [
    //             'id' => $account->id,
    //             'group_id' => $account->group_id,
    //             'name' => $account->name,
    //             'company_id' => $account->company_id,

    //         ],
    //         'groups' => $groups,
    //         'companies' => $companies,
            
            
    //     ]);
    // }

    // public function update(Account $account)
    // {
    //     Request::validate([
    //         'name' => ['required'],
    //         'group' => ['required'],
    //         'company' => ['required'],
    //     ]);

              
    //             $account->name = Request::input('name');
    //             $account->group_id = Request::input('group');
    //             $account->company_id = Request::input('company');


    //     $account->save();

    //     return Redirect::route('accounts')->with('success', 'Account updated.');
    // }
    

    // public function destroy(Account $account)
    // {
    //     $account->delete();
    //     return Redirect::back()->with('success', 'Account Deleted.');
    // }
}
