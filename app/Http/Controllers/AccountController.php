<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class AccountController extends Controller
{

    public function index()
    {
        return Inertia::render('Accounts/Index', [
            'data' => Account::all()
                ->map(function ($account){
                    return [
                        
                        'id' => $account->id,
                        'name' => $account->name,
                        'group_id' => $account->group_id,
                        'company_id' => $account->company_id,
                        'groupname' =>$account->accountGroup->name,
                    ];
                }), 
        ]);
    }

    public function create()
    {
        $groups = \App\Models\AccountGroup::all()->map->only('id','name');
        $group_first = \App\Models\AccountGroup::all('id','name')->first();

        $companies = \App\Models\Company::all()->map->only('id','name');
        $comp_first = \App\Models\Company::all('id','name')->first();

        return Inertia::render('Accounts/Create',[
          'groups' => $groups, 'group_first' => $group_first
        , 'companies'=> $companies , 'comp_first'=> $comp_first]);

        
    }

    public function store()
    {

             Request::validate([
            'name' => ['required'],
            'group' => ['required'],
            'company' => ['required'],
        ]);

            Account::create([
                'name' => Request::input('name'),
                'group_id' => Request::input('group'),
                'company_id' => Request::input('company'),
        ]);

        return Redirect::route('accounts')->with('success', 'Account created.');

    }


    public function show(Account $account)
    {
        
    }

    public function edit(Account $account)
    {
        $groups = \App\Models\AccountGroup::all()->map->only('id','name');
        $companies = \App\Models\Company::all()->map->only('id','name');
        return Inertia::render('Accounts/Edit', [
            'account' => [
                'id' => $account->id,
                'group_id' => $account->group_id,
                'name' => $account->name,
                'company_id' => $account->company_id,

            ],
            'groups' => $groups,
            'companies' => $companies,
            
            
        ]);
    }

    public function update(Account $account)
    {
        Request::validate([
            'name' => ['required'],
            'group' => ['required'],
            'company' => ['required'],
        ]);

              
                $account->name = Request::input('name');
                $account->group_id = Request::input('group');
                $account->company_id = Request::input('company');


        $account->save();

        return Redirect::route('accounts')->with('success', 'Account updated.');
    }
    

    public function destroy(Account $account)
    {
        $account->delete();
        return Redirect::back()->with('success', 'Account Deleted.');
    }
}
