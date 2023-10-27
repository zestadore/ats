<?php

namespace App\Models\Scopes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SaasScope implements Scope
{
    
    public function apply(Builder $builder, Model $model): void
    {
        if(Auth::check()){
            $builder->where('company_id', Auth::user()->company_id);
            // if(Auth::user()->role!='super_admin'){
            //     $builder->where('company_id', Auth::user()->company_id);
            // }
        }
    }
}
