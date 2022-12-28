<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
Use Exception;


class Rating extends Model
{

    public $timestamps  = false;
    protected $table = 'rating';

    public function getUser($id){
        $user=Rating::where('id',$id)->get()->toArray();
        return $user;
    }

}
