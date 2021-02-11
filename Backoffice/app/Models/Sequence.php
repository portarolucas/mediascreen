<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sequence extends Model {

    protected $table = 'sequences';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function ecran() {
        return $this->hasMany('App\Models\Ecran', 'id_sequence');
    }
}