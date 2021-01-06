<?php

namespace MediaScreenAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Sequence extends Model {
    protected $table = 'sequences';
    protected $primaryKey = 'id';
    public $timestamps = false;
}