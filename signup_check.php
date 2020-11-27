<?php
//geen idee of dit werkt
$gebruikersNaam
$gebruikersWachtwoord
if(!empty($_POST["Password"])){
?>Je moet een wachtwoord invoeren<?php
}elseif(strlen($password) <'12'){
?>Je wachtwoord moet uit minstens 12 tekens bestaan<?php
}elseif(!pregmatch("#[0-9}+#",$password)){
?>Je wachtwoord moet minstens één getal bevatten<?php
}elseif(!preg_match("#[A-Z]+#",$password)){
?>Je wachtwoord moet minstens één hoofdletter bevatten<?php
}elseif(!preg_match("#[a-z]+#",$password)){
?>Je wachtwoord moet minstens één kleine letter bevatten<?php}
?>