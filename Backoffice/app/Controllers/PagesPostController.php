<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Ecran;
use App\Models\Sequence;
use App\Controllers\Auth\AuthController;

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
        $temps = htmlspecialchars(trim($request->getParam('newEcranTime')));

        $exist = Ecran::where('id', '=', $id)->count();

        if(!$exist) {
            return "L'écran que vous essayez de modifier n'existe pas !";
        } else {
            Ecran::where('id', '=', $id)->update(['nom' => $name, 'temps' => $temps * 1000]);
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

}