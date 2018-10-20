<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table = "processes";
    protected $guarded = ["id"];


    public function numbers()
    {
        return $this->hasMany(Number::class);
    }

    public function processNumbers()
    {
        return $this->hasMany(ProcessNumber::class);
    }

}
