<?php

/**
 * @author Claudio Cicimurri, 5CI
 * Funzione per generare una stringa a caso
 * @param int $length Lunghezza della stringa
 * @return string String a caso;
 */
function generaStringaCasuale($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * @author Claudio Cicimurri, 5CI
 * Funzione per generare un codice casuale
 * @return string Codice generato
 */
function generaCodice()
{
    // Ottieni il timestamp odierno e hashalo
    $timestampOdierno = md5(time());
    // Ottieni una stringa a caso e uniscila al timestamp calcolato
    return generaStringaCasuale(13) . $timestampOdierno;
}
