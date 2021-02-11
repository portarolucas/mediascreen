<?php
namespace App\Controllers;

use App\Models\Ecran;
use App\Models\Sequence;
use Slim\Http\Request;
use Slim\Http\Response;

class PagesPostController extends Controller {

    public function createSequence(Request $request, Response $response) {
        $seq_name = htmlspecialchars(trim($request->getParam('name_seq')));

        if(empty($seq_name)) {
            $this->flash('Nom de séquence invalide !', 'error');
        } else {
            $exist = Sequence::where('nom', '=', $seq_name)->count();
            if($exist) {
                $this->flash('Cette séquence existe déjà !', 'error');
            } else {
                Sequence::insert(['nom' => $seq_name]);
                $this->flash('La séquence a été créée avec succès !');
            }
        }
        return $this->redirect($response, 'createSequence');
    }

    public function createScreen(Request $request, Response $response) {
        $screen_name = htmlspecialchars(trim($request->getParam('screen_name')));
        $id_sequence = htmlspecialchars(trim($request->getParam('sequence_associee')));
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
                    Ecran::insert(['nom' => $screen_name, 'contenu' => $markdown, 'temps' => $screen_time * 1000, 'id_sequence' => $id_sequence, 'id_type' => 1]);
                    $this->flash("L'écran a été créé avec succès !");
                }
            }
        }
        return $this->redirect($response, 'createScreen');
    }

}