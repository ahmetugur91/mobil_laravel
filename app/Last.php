<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Last extends Model
{
    protected $table = "last";
    protected $guarded = ["id"];
    public $timestamps = false;
}
