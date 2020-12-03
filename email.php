<?php

    $mail = $_GET['email'];
    $beschrijving  = $_GET['beschrijving'];
    $Titel = $_GET['Titel'];
    $msg = $beschrijving;

// use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);
    mail("smartbrievenbus@gmail.com","hoi","hoi");



