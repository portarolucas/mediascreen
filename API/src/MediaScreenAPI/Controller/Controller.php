<?php

namespace MediaScreenAPI\Controller;

use MediaScreenAPI\Models\Sequence;
use MediaScreenAPI\Models\Ecran;

class Controller {

    public static function setError() {
        return json_encode(['Error' => 'No data']);
    }
    
    public static function getSequences() {
        return json_encode(Sequence::select()->get());
    }

    public static function getSequence($id) {
        $sequence = Sequence::select()->where('id', '=', $id)->first();
        if(!is_null($sequence)) {
            return json_encode($sequence);
        } else {
           return self::setError();
        }
    }

    public static function getEcrans() {
        return json_encode(Ecran::select()->get());
    }

    public static function getEcran($id) {
        $ecran = Ecran::select()->where('id', '=', $id)->first();
        if(!is_null($ecran)) {
            return json_encode($ecran);
        } else {
            return self::setError();
        }
    }

    public static function getEcransSequence($id) {
        $ecrans = Ecran::select()->where('id_sequence', '=', $id)->get();
        if(!is_null($ecrans)) {
            return json_encode($ecrans);
        } else {
            return self::setError();
        }
    }

}