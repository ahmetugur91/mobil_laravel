<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessNumber extends Model
{
    protected $table = "process_numbers";
    protected $guarded = ["id"];
    public $timestamps = false;


    public function number()
    {
        return $this->belongsTo(Number::class);
    }

    public function process()
    {
        return $this->belongsTo(Process::class);
    }


}
