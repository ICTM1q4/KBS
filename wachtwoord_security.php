<?php
// checkt of het wachtwoord klopt
if($_POST["Password"] != //waar we het wachtwoord vandaan halen
){
 ?>Je invoer komt niet overeen met het wachtwoord <?php
}
if(empty($_POST["Password"])){
    ?>Je moet een wachtwoord invoeren<?php
}
