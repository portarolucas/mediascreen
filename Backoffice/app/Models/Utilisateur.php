<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model {

    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['nom', 'prenom', 'email', 'mdp'];

}