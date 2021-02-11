<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ecran extends Model {

    protected $table = 'ecrans';
    protected $primaryKey = 'id';
    public $timestamp = false;

    public function sequence() {
        return $this->belongsTo('App\Models\Sequence', 'id_sequence');
    }

}