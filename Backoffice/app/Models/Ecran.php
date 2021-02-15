<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ecran extends Model {

    protected $table = 'ecrans';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['nom', 'id_sequence', 'temps'];

    public function sequence() {
        return $this->belongsTo('App\Models\Sequence', 'id_sequence');
    }

    public function author() {
        return $this->belongsTo('App\Models\Utilisateur', 'auteur');
    }

}