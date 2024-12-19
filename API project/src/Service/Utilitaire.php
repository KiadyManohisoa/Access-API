<?php 

namespace App\Service;

use App\Config\AppConfig;
use DateTime;
use DateInterval;

class Utilitaire 
{

    public function __construct() {

    }

    public function getDatePrevuee($intervalle) {
        $currentDateTime = new DateTime();

        list($hours, $minutes, $seconds) = explode(':', $intervalle);

        $interval = new DateInterval('PT' . $hours . 'H' . $minutes . 'M' . $seconds . 'S');
        
        $prochaineDate = clone $currentDateTime;
        $prochaineDate->add($interval);

        return $prochaineDate;
    }
    
    public function genere_pin(): int {
        $longueurPin = AppConfig::LONGUEUR_PIN;
        $pin = '';
        for ($i = 0; $i < $longueurPin; $i++) {
            $pin .= rand(0, 9);  
        }
        return (int) $pin;
    }

}