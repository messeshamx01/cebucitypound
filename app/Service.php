<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $table = 'services';
    
    protected $fillable = [
        'name'
    ];

    public function pet()
    {
        return $this->belongsToMany('App\Pet');
    }
}
