<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class BotUser extends Model
{
    protected $fillable = ['username'];

    static function test(Request $request = null){
        return BotUser::all();
    }
}