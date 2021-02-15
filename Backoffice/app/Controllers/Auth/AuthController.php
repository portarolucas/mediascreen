<?php
namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\Utilisateur;

class AuthController extends Controller {

    public static function login($email, $password) {
        $status = false;
        $user = Utilisateur::where('email', $email)->first();
        if(!is_null($user)) {
            if(self::verifyPassword($password, $user->mdp)) {
                $_SESSION['id'] = $user->id;
                $_SESSION['nom'] = $user->nom;
                $_SESSION['prenom'] = $user->prenom;
                $_SESSION['email'] = $user->email;
                $status = true;
            }
        }
        return $status;
    }

    public static function logout() {
        unset($_SESSION['id']);
        unset($_SESSION['nom']);
        unset($_SESSION['prenom']);
        unset($_SESSION['email']);
    }

    public static function isLogged() {
        if(isset($_SESSION['id'])) {
            return true;
        } else {
            return false;
        }
    }

    private static function verifyPassword($password, $db_password) {
        return password_verify($password, $db_password);
    }

}