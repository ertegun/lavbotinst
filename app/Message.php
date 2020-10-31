<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Message extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'MesajKutusu';

    // protected $fillable = [
    //     'carcompany', 'model', 'price'
    // ];
}
