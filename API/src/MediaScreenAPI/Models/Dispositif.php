<?php

namespace MediaScreenAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Dispositif extends Model {
    protected $table = 'dispositifs';
    protected $primaryKey = 'id';
    public $timestamps = false;
}