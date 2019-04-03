<?php
    /**
     * @author Lorenzo Clazzer, 5CI
     * Riporta il codice dell'utente se ha eseguito il login
     * 
     * @return string|false Codice o false in caso di errore
     */
    function logged()
    {
        //session_start();
        if(isset($_SESSION['user_id']))
        {
            if($_SESSION['user_id'] != "")
                return $_SESSION['user_id'];
            else
                return false;
        }



    }
?>