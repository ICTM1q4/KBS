    <?php
    include "connect.php";

//PREPARE ALL VARIABLES
    if (isset($_GET["change"]) && isset($_GET["OrderLine"])){
        $OrderLine = $_GET["OrderLine"];
        $change = $_GET["change"];
        if ($change == "plus"){
            $amount = 1;
        }
        else if ($change == "minus"){
            $amount = 2;
        }
    }

//GET AMOUNT FROM DATABASE OF ORDERLINE
    $Query = "
        SELECT WL.OrderAmount AM
        FROM weborderline WL
        WHERE WL.OrderLineID = ?
        LIMIT 1;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $OrderLine);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

//SET AMOUNT FOR UPDATE
    foreach ($ReturnableResult as $ReturnableResult){
        if ($amount == 1){
            $amount = $ReturnableResult["AM"] + 1;
        }
        else if ($amount == 2){
            $amount = $ReturnableResult["AM"] - 1;
            if ($amount == 0){
                
                $Query = "
                DELETE FROM weborderline
                WHERE weborderline.OrderLineID = ?;";
            
                $Statement = mysqli_prepare($Connection, $Query);
                mysqli_stmt_bind_param($Statement, "s", $OrderLine);
                mysqli_stmt_execute($Statement);
                break;
            }
        }

//UPDATE IN DATABASE
        $Query = "
            UPDATE weborderline WL
            SET WL.OrderAmount = ?
            WHERE WL.OrderLineID = ?;";

        $Statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($Statement, "ss", $amount, $OrderLine);
        mysqli_stmt_execute($Statement);
        break;
    }

//GET URL AND GO TO winkelmand.php
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $position = strrpos($actual_link, "/");
    $count = strlen($actual_link);
    $positionChar = substr($actual_link, $position);
    while ($positionChar != ""){
        $actual_link = substr_replace($actual_link, "", $position);
        $positionChar = substr($actual_link, $position);
    }
    header('Location: ' . $actual_link . '/winkelmand.php');


