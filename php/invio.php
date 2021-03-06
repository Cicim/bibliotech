<?php
 // Importa la librearia PHPMailer per l'SMTP
require_once "libs/class.phpmailer.php";
require_once "libs/class.smtp.php";

// Dichiara l'URL del sito come costante
const URL_SITO = "193.200.193.11"; 
// Dichiara la mail di contatti come costante
const CONTATTO = "err@bib2.no";

/**
 * @author Claudio Cicimurri, 5CI
 * Funzione per inviare una mail
 * @param string $a L'indirizzo del destinatario
 * @param string $oggetto L'oggetto dell'e-mail
 * @param string $html Il corpo dell'e-mail in html
 * 
 * @return bool Riporta vero se tutto è andato a buon fine
 */
function inviaMail($a, $oggetto, $html)
{
    // Configurazione
    $inviatoDa = "bibliotech.rosselli@gmail.com";
    // Vi chiedo di essere gentili e di non copiare questa password
    $pass = "Ey2uqKLv8AxzgV9";
    // Il soprannome da mostrare al destinatario
    $soprannome = "noreply";

    // Implementazione di PHPMailer
    $mail = new PHPMailer();
    // Imposta come SMTP in SSL
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    // Autenticati su google
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = $inviatoDa;
    $mail->Password = $pass;
    // Imposta il mittente
    $mail->SetFrom($inviatoDa, $soprannome);
    // Aggiungi l'oggetto
    $mail->Subject = $oggetto;
    // Impostala come mail html
    $mail->IsHTML(true);
    // Aggiungi il destinatario
    $mail->AddAddress($a);
    // Aggiungi l'html
    $mail->Body = $html;

    // Riporta false e stampa l'errore in caso di errore
    if (!$mail->Send()) {
        echo 'Mail error: ' . $mail->ErrorInfo;
        return false;
    } 
    // Riporta true se tutto è andato a buon fine
    else return true;
}

/**
 * @author Claudio Cicimurri, 5CI
 * Funzione per richiedere la conferma dell'account da parte dell'indirizzo mail
 * @param string $indirizzo Destinatario
 * @param string $validazione Codice per la validazione
 * @param string $nome Il nome del destinatario
 * @param string $cognome Il cognome del destinatario
 * @param string $sesso Il sesso del destinatario
 * 
 * @return bool Se la mail è stata iniviata
 */
function inviaMailDiConferma($indirizzo, $validazione, $nome, $cognome, $sesso)
{
    // Nome del sito
    $sito = URL_SITO;
    // Contatti
    $email = CONTATTO;
    // Ottieni l'anno attuale
    $anno = date('Y');

    $strsesso = $sesso == 'F' ? 'a' : 'o';

    // Invia mail al destinatario
    return inviaMail(
        $indirizzo,
        'Conferma account Bibliotech',
        "<body style='border:0;margin:0;font-family:Helvetica'><div style='background:black;color:white;padding:4em'><h1>Ciao, $nome $cognome!<br>Grazie per esserti registrat$strsesso</h1>Per completare l'attivazione del tuo account clicca su questo pulsante:<br><div style='text-align:center'><a style='margin:1em;text-decoration:none;padding:1em 2em;background:white;display:inline-block;border-radius:1em;color:black;font-family:Segoe UI' href='$sito/php/validazione.php?codice=$validazione'>Attiva il tuo account</a></div></div><div style='background:grey;color:lightgray;padding:1em;text-align:center;font-size:11pt'>Se non hai creato tu quest'account, puoi ignorare questa e-mail.<br>Per qualsiasi informazione, contatta <a href='mailto:$email' style='color:#ddd;'>$email</a>, non rispondere a questa mail<br><a href='$sito/' style='color:#ddd'>Bibliotech</a>, $anno</div></body>"
    );
}


/**
 * @author Claudio Cicimurri, 5CI
 * Funzione per inviare una mail di recupero per la password
 * 
 * @param string $indirizzo Destinatario
 * @param string $codice Codice per reimposta-password.php
 * @param string $nome Il nome del destinatario
 * @param string $cognome Il cognome del destinatario
 * 
 * @return bool Se la mail è stata iniviata
 */
function inviaMailDiRecupero($indirizzo, $codice, $nome, $cognome)
{
    // Nome del sito
    $sito = URL_SITO;
    // Contatti
    $email = CONTATTO;
    // Ottieni l'anno attuale
    $anno = date('Y');

    // Invia mail al destinatario
    return inviaMail(
        $indirizzo,
        'Conferma account Bibliotech',
        "<body style='border:0;margin:0;font-family:Helvetica'><div style='background:black;color:white;padding:4em'><h1>Bentornato, $nome $cognome!<br>Segui le istruzioni per recuperare il tuo account.</h1>Per recuperare il tuo account, premi il pulsante e segui le istruzioni:<br><div style='text-align:center'><a style='margin:1em;text-decoration:none;padding:1em 2em;background:white;display:inline-block;border-radius:1em;color:black;font-family:Segoe UI' href='$sito/pages/reimposta-password.php?codice=$codice'>Reimposta la tua password</a></div></div><div style='background:grey;color:lightgray;padding:1em;text-align:center;font-size:11pt'>Non ti sei iscritto a Bibliotech? Contattaci a <a href='mailto:$email' style='color:#ddd;'>$email</a>.<br> Non rispondere direttamente a questa mail<br><a href='$sito/' style='color:#ddd'>Bibliotech</a>, $anno</div></body>"
    );
}
