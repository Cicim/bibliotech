<?php
 // Importa la librearia PHPMailer per l'SMTP
require_once "libs/class.phpmailer.php";
require_once "libs/class.smtp.php";

/**
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