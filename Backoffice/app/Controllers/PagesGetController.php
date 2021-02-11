<?php
namespace App\Controllers;

use App\Models\Ecran;
use App\Models\Sequence;
use Slim\Http\Request;
use Slim\Http\Response;

class PagesGetController extends Controller {

    public function home(Request $request, Response $response) {
        $this->render($response, 'Pages/Home.twig');
    }

    public function login(Request $request, Response $response) {
        $this->render($response, 'Pages/Login.twig');
    }

    public function createSequence(Request $request, Response $response) {
        $this->render($response, 'Pages/CreateSequence.twig');
    }

    public function createScreen(Request $request, Response $response) {
        $sequences = Sequence::get();
        $this->render($response, 'Pages/CreateScreen.twig', ['sequences' => $sequences]);
    }

    public function Sequences(Request $request, Response $response) {
        $sequences = Sequence::select()->with('ecran')->get();
        $this->render($response, 'Pages/Sequences.twig', ['sequences' => $sequences]);
    }

    public function Screens(Request $request, Response $response) {
        $screens = Ecran::select()->with('sequence')->get();
        $this->render($response, 'Pages/Screens.twig', ['screens' => $screens]);
    }

}