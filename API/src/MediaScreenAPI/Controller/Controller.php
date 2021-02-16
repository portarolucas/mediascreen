<?php

namespace MediaScreenAPI\Controller;

use MediaScreenAPI\Models\Sequence;
use MediaScreenAPI\Models\Ecran;
use MediaScreenAPI\Models\Dispositif;

class Controller {


    // Méthode statique permettant de générer une erreur
    public static function setError($message = 'No data') {
        return json_encode(['Error' => $message]);
    }
    
    // Méthode statique permettant de récuperer toutes les séquences
    public static function getSequences() {
        return json_encode(Sequence::select()->get());
    }

    // Méthode statique permettant de récuperer une séquence à partir de son ID
    public static function getSequence($id) {
        $sequence = Sequence::select()->where('id', '=', $id)->first();
        if(!is_null($sequence)) {
            return json_encode($sequence);
        } else {
           return self::setError();
        }
    }

    // Méthode statique permettant de récuperer tous les écrans
    public static function getEcrans() {
        return json_encode(Ecran::select()->get());
    }

    // Méthode statique permettant de récuperer un écran à partir de son ID
    public static function getEcran($id) {
        $ecran = Ecran::select()->where('id', '=', $id)->first();
        if(!is_null($ecran)) {
            return json_encode($ecran);
        } else {
            return self::setError();
        }
    }

    // Méthode statique permettant de récuperer tous les écrans appartenant à une même séquence à partir de l'ID de celle-ci
    public static function getEcransSequence($id) {
        $ecrans = Ecran::select()->where('id_sequence', '=', $id)->get();
        if(!is_null($ecrans)) {
            return json_encode($ecrans);
        } else {
            return self::setError();
        }
    }

    public static function getEcransToken($token) {
        $dispositif = Dispositif::where('token', $token)->first();
        if(!is_null($dispositif)) {
            $id_sequence = $dispositif->id_sequence;
            $ecrans = Ecran::select()->where('id_sequence', $id_sequence)->get();
            if(!is_null($ecrans)) {
                return json_encode($ecrans);
            } else {
                return self::setError();
            }
        } else {
            return self::setError('invalid token');
        }
    }

}