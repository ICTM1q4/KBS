<?php

include "connect.php";

$date = '2020-12-16 ';
$sensor = 1;
$uur = 0;
$minuut = 0;
while ($sensor < 5){
    while($uur<24){
        if ($uur < 10){
            $uurnew = '0'.$uur;
        }
        else{
            $uurnew = $uur;
        }
        if ($minuut < 10){
            $minuutnew = 0 . $minuut;
        }
        else{
            $minuutnew = $minuut;
        }
        $newdate = $date . $uurnew . ":" . $minuutnew . ":00";
        $Query = "
        INSERT INTO coldroomtemperatures (RecordedWhen, ColdRoomSensorNumber, Temperature)
        VALUES (?, ?, ?)";
        $random = rand(300,500) / 100;
        $Statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($Statement, "sss", $newdate, $sensor, $random);
        mysqli_stmt_execute($Statement);
        $minuut += 10;
        if ($minuut >= 60){
            $minuut = 0;
            $uur++;
        }
    }
    $minuut = 0;
    $uur = 0;
    $sensor++;
}