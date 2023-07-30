<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
USE Illuminate\Support\Facades\Auth;

class EndClient extends Model
{
    use HasFactory;
    protected $table = 'end_clients';
    protected $guarded=[];

}
