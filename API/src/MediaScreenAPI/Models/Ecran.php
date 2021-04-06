<?php

namespace MediaScreenAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Ecran extends Model {
    protected $table = 'ecrans';
    protected $primaryKey = 'id';
    public $timestamps = false;
}