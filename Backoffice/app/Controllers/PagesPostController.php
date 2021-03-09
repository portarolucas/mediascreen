<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Ecran;
use App\Models\Sequence;
use App\Controllers\Auth\AuthController;
use App\Models\Dispositif;
use App\Models\Utilisateur;
use Illuminate\Container\Util;

class PagesPostController extends Controller {

    public function login(Request $request, Response $response) {
        $email = htmlspecialchars(trim($request->getParam('email_address')));
        $password = htmlspecialchars(trim($request->getParam('password')));
        
        if(empty($email) || empty($password)) {
            $this->flash('Un ou plusieurs champs sont vide(s) !', 'error');
        } else {
            if(!AuthController::login($email, $password)) {
                $this->flash('Adresse email ou mot de passe incorrect !', 'error');
            } else {
                return $this->redirect($response, 'home');
            }
        }
        return $this->redirect($response, 'login');
    }

    public function createSequence(Request $request, Response $response) {
        $seq_name = htmlspecialchars(trim($request->getParam('name_seq')));

        if(empty($seq_name)) {
            $this->flash('Nom de séquence invalide !', 'error');
        } else {
            $exist = Sequence::where('nom', '=', $seq_name)->count();
            if($exist) {
                $this->flash('Cette séquence existe déjà !', 'error');
            } else {
                Sequence::insert(['nom' => $seq_name, 'auteur' => $_SESSION['id']]);
                $this->flash('La séquence a été créée avec succès !');
            }
        }
        return $this->redirect($response, 'createSequence');
    }

    public function createScreen(Request $request, Response $response, $args) {
        $screen_name = htmlspecialchars(trim($request->getParam('screen_name')));
        $id_sequence = htmlspecialchars(trim($args['id']));
        $type = htmlspecialchars(trim($request->getParam('screen_type')));
        $markdown = htmlspecialchars(trim($request->getParam('markdown_area')));
        $screen_time = htmlspecialchars(trim($request->getParam('screen_time')));

        if(empty($screen_name)) {
            $this->flash("Nom d'écran invalide !", 'error');
        } else {
            if($type == 'markdown') {
                if(empty($markdown) || empty($screen_time) || $screen_time == '0') {
                    $this->flash("Le contenu de l'écran et/ou le temps d'affichage ne peuvent être vide !", 'error');
                } else {
                    Ecran::insert(['nom' => $screen_name, 'contenu' => $markdown, 'temps' => $screen_time * 1000, 'id_sequence' => $id_sequence, 'id_type' => 1, 'auteur' => $_SESSION['id']]);
                }
            }
        }
        return $this->redirect($response, 'screens', ['id' => $id_sequence]);
    }

    public function screenDelete(Request $request, Response $response) {
        $id = $request->getParam('id');
        $exist = Ecran::where('id', '=', $id)->count();
        
        if(!$exist) {
            return "L'écran que vous essayez de supprimer n'existe pas !";
        } else {
            Ecran::where('id', '=', $id)->delete();
            return "success";
        }
    }

    public function screenUpdate(Request $request, Response $response) {
        $id = $request->getParam('id');
        $name = htmlspecialchars(trim($request->getParam('newNom')));
        $content = htmlspecialchars(trim($request->getParam('newContent')));
        $temps = htmlspecialchars(trim($request->getParam('newEcranTime')));

        $exist = Ecran::where('id', '=', $id)->count();

        if(!$exist) {
            return "L'écran que vous essayez de modifier n'existe pas !";
        } else {
            Ecran::where('id', '=', $id)->update(['nom' => $name, 'contenu' => $content, 'temps' => $temps * 1000]);
            return "success";
        }
    }

    public function sequenceDelete(Request $request, Response $response) {
        $id = $request->getParam('id');
        $exist = Sequence::where('id', '=', $id)->count();
        
        if(!$exist) {
            return "La séquence que vous essayez de supprimer n'existe pas !";
        } else {
            Ecran::where('id_sequence', '=', $id)->delete();
            Sequence::where('id', '=', $id)->delete();
            return "success";
        }
    }

    public function sequenceUpdate(Request $request, Response $response) {
        $id = $request->getParam('id');
        $name = htmlspecialchars(trim($request->getParam('newNom')));

        $exist = Sequence::where('id', '=', $id)->count();

        if(!$exist) {
            return "La séquence que vous essayez de modifier n'existe pas !";
        } else {
            Sequence::where('id', '=', $id)->update(['nom' => $name]);
            return "success";
        }
    }

    public function profile(Request $request, Response $response) {
        $currentPassword = htmlspecialchars(trim($request->getParam('currentPassword')));
        $newPassword = htmlspecialchars(trim($request->getParam('newPassword')));

        if(empty($currentPassword) || empty($newPassword)) {
            $this->flash("Un ou plusieurs champs sont vides !", 'error');
        } else {
            $db_password = Utilisateur::select('mdp')->where('id', $_SESSION['id'])->first();

            if(AuthController::verifyPassword($currentPassword, $db_password->mdp)) {
                $hashedPassword = AuthController::hashPassword($newPassword);
                Utilisateur::where('id', $_SESSION['id'])->update(['mdp' => $hashedPassword]);
                $this->flash("Le mot de passe a bien été sauvegardé !");
            } else {
                $this->flash("Mot de passe actuel incorrect !", 'error');
            }
        }
        return $this->redirect($response, 'profile');
    }

    public function createUser(Request $request, Response $response) {
        $firstname_user = htmlspecialchars(trim($request->getParam('name_user')));
        $lastname_user = htmlspecialchars(trim($request->getParam('forname_user')));
        $mail_user = htmlspecialchars(trim($request->getParam('mail_user')));
        $password_user = htmlspecialchars(trim($request->getParam('mdp_user')));
        $rank_user = htmlspecialchars(trim($request->getParam('rank_user')));

        if(!filter_var($mail_user, FILTER_VALIDATE_EMAIL)) {
            $this->flash('Cette adresse email est invalide !', 'error');
        } else {
            if(empty($firstname_user || $lastname_user || $mail_user || $password_user || $rank_user)) {
                $this->flash('Veuillez renseigner tous les champs !', 'error');
            } else {
                $exist = Utilisateur::where('email', '=', $mail_user)->count();
                if($exist) {
                    $this->flash('Cette adresse e-mail est déjà utilisée !', 'error');
                } else {
                    $password_hash = AuthController::hashPassword($password_user);
                    Utilisateur::insert(['nom' => $firstname_user, 'prenom' => $lastname_user, 'email' => $mail_user, 'mdp' => $password_hash, 'is_superadmin' => $rank_user]);
                    $this->flash("L'utilisateur a été créé avec succès !");
                }
            }
        }        
        return $this->redirect($response, 'createUser');
    }

    public function createDevice(Request $request, Response $response) {
        $name = htmlspecialchars(trim($request->getParam('nom')));
        $description = htmlspecialchars(trim($request->getParam('description')));
        $lieu = htmlspecialchars(trim($request->getParam('lieu')));
        $id_sequence = htmlspecialchars(trim($request->getParam('id_sequence')));
        $token = bin2hex(random_bytes(12));

        if(empty($name) || empty($description) || empty($lieu) || empty($id_sequence)) {
            $this->flash('Un ou plusieurs champs sont vide(s) !', 'error');
        } else {
            Dispositif::insert(['nom' => $name, 'description' => $description, 'lieu' => $lieu, 'id_sequence' => $id_sequence, 'token' => $token]);
            $this->flash("Le dispositif a été créé avec succès !");
        }
        return $this->redirect($response, 'createDevice');
    }

    public function deviceUpdate(Request $request, Response $response) {
        $id = $request->getParam('id');
        $name = htmlspecialchars(trim($request->getParam('newNom')));
        $description = htmlspecialchars(trim($request->getParam('newDescription')));
        $lieu = htmlspecialchars(trim($request->getParam('newLieu')));
        $id_sequence = htmlspecialchars(trim($request->getParam('newIdSequence')));

        $exist = Dispositif::where('id', '=', $id)->count();

        if(!$exist) {
            return "Le dispositif que vous essayez de modifier n'existe pas !";
        } else {
            Dispositif::where('id', '=', $id)->update(['nom' => $name, 'description' => $description, 'lieu' => $lieu, 'id_sequence' => $id_sequence]);
            return "success";
        }
    }

    public function deviceDelete(Request $request, Response $response) {
        $id = $request->getParam('id');

        $exist = Dispositif::where('id', '=', $id)->count();

        if(!$exist) {
            return "Le dispositif que vous essayez de modifier n'existe pas !";
        } else {
            Dispositif::where('id', '=', $id)->delete();
            return "success";
        }
    }

    public function userDelete(Request $request, Response $response) {
        $id = $request->getParam('id');
        $exist = Utilisateur::where('id', '=', $id)->count();
        
        if(!$exist) {
            return "L'utilisateur que vous essayez de supprimer n'existe pas !";
        } else {
            Utilisateur::where('id', '=', $id)->delete();
            return "success";
        }
    }

    public function userUpdate(Request $request, Response $response) {
        $id = $request->getParam('id');
        $firstname = htmlspecialchars(trim($request->getParam('newNom')));
        $lastname = htmlspecialchars(trim($request->getParam('newPrenom')));
        $email = htmlspecialchars(trim($request->getParam('newEmail')));
        $rank = htmlspecialchars(trim($request->getParam('newRank')));
    
        $exist = Utilisateur::where('id', '=', $id)->count();
    


        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->flash('Cette adresse email est invalide !', 'error');
        } else {
            if(!$exist) {
                return "L'utilisateur que vous essayez de modifier n'existe pas !";
            } else {
                Utilisateur::where('id', '=', $id)->update(['nom' => $firstname, 'prenom' => $lastname, 'email' => $email, 'is_superadmin' => $rank]);
                return "success";
            }
        } 

    }

}