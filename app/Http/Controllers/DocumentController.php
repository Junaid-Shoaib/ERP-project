<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Req;
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

        $groups = \App\Models\Account::all()->map->only('id','name');
        $group_first = \App\Models\Account::all('id','name')->first();

        $types = \App\Models\DocumentType::all()->map->only('id','name');
        $type_first = \App\Models\DocumentType::all('id','name')->first();

        $companies = \App\Models\Company::all()->map->only('id','name');
        $comp_first = \App\Models\Company::all('id','name')->first();
        
        $years = \App\Models\Year::all()->map->only('id','name');
        // $year_first = \App\Models\Year::all('id','name')->first();

        return Inertia::render('Documents/Create',[
                 'accounts' => DocumentType::all()
                        ->map(function ($docs){
                            return [
                            'id' => $docs->id,
                            'name' => $docs->name,
                            'prefix' => $docs->prefix,
                            'ref' => $docs->name." - ".$docs->prefix,
                            // 'date' => $docs->date,
                            // 'description'=> $docs->description,
                    ];
                }),
                'groups' => $groups, 'group_first' => $group_first     ,
                'companies'=> $companies , 'comp_first'=> $comp_first  ,
                'years'=> $years , 
                'types'=> $types , 'type_first'=> $type_first  ,
                
         
                
        ]);
        }
        

        public function store(Req $request)
        {
    // dd($request);
            Request::validate([
                'company_id' => ['required'],
                'ref' => ['required'],
                'date' => ['required' ,'date'],
                'description' => ['required'],<div class=""></div>
                'year_id' => ['required'],
                'balances.*.group_id' => ['required'],
            
                // 'balances.*.year_id' => ['required'],
            ]);
    // 'ref', 'date','description','type_id','paid','posted','approved','enabled', 'company_id', 'year_id'
    
    $doc = Document::create([
        'ref' => Request::input('ref'),
        'date' => Request::input('date'),
        'description' => Request::input('description'),
        'company_id' => Request::input('company_id'),
        'type_id' =>Request::input('type_id'), 
        'year_id' =>Request::input('year_id'),
        
        ]);
        
        
        
        foreach($request->balances as $balance){
            Entry::create([

                'account_id' => $balance['group_id'], 
                'debit' => $balance['debit'] ,
                'credit' => $balance['credit'],
                'company_id' => $doc->company_id,
                'year_id' => $doc->year_id,
                'document_id' => $doc->id,
                // 'year_id' => $balance   ('year_id'),
                
        // 'company_id' => $balance['company_id'],
        // 'paid' => $balance['paid'],
        // 'posted' => $balance['posted'],
        // 'approved' => $balance['approved'],
        ]);
        
            }
    
            return Redirect::route('documents')->with('success', 'Bank Balance created.');
    
    
        }

        // public function store()
        // {
    // //         'ref', 'date','description','type_id','paid','posted','approved','enabled', 'company_id', 'year_id'
                
        // Request::validate([
        //     'doc_type' => ['required'],
        //     'date'  => ['required'],
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
        // ]);

            // Document::create([
            // 'document_id' => Request::input('doc_type'),
            //     'date' => Request::input('date'),
    //             'description' => Request::input('date'),
                
    //             'paid' => Request::input('name'),
    //             'company_id' => Request::input('company'),
    //             'year_id' => Request::input('year'),

    //     ]);

    //     return Redirect::route('documents')->with('success', 'Transaction created.');

    // }


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
