<?php

require 'connection.php';
$conn    = Connect();
$vote   = $conn->real_escape_string($_POST['vote']);
$query   = "INSERT into tb_cform (vote) VALUES('" . $name . "')";
$success = $conn->query($query);

if (!$success) {
    die("Couldn't enter data: ".$conn->error);

}
rror_reporting(E_ALL);

// CONNECTION AND SELECTION VARIABLES FOR THE DATABASE
$db_host = "localhost"; // PROBABLY THIS IS OK
$db_name = "ihelpdmx";        
$db_user = "ihelp";
$db_word = "WACHTWOORDHIER"; //WACHTWOORD MOET HIER

// OPEN A CONNECTION TO THE DATA BASE SERVER AND SELECT THE DB
$mysqli = new mysqli($db_host, $db_user, $db_word, $db_name);

// DID THE CONNECT/SELECT WORK OR FAIL?
if ($mysqli->connect_errno)
{
    $err
    = "CONNECT FAIL: "
    . $mysqli->connect_errno
    . ' '
    . $mysqli->connect_error
    ;
    trigger_error($err, E_USER_ERROR);
}


// GET THE ARRAY OF COLORS FROM THE DATA BASE
$kleuren = array();
$sql = "SELECT kleur FROM stemkleuren";
$res = $mysqli->query($sql) or trigger_error( "$sql<br/>" . $mysqli->error, E_USER_WARNING );
while ($row = $res->fetch_object())
{
    $kleuren[] = $row->kleur;
}



// SHOW THE STATISTICS FOR THE COLORS
foreach ($colors as $kleur)
{
    $ipa = 'none';
    $whn = 'no votes yet';
    $sql = "SELECT ip_address, when_voted FROM stemkleuren WHERE kleuren = '$color' ORDER BY when_voted DESC";
    $res = $mysqli->query($sql) or trigger_error( "$sql<br/>" . $mysqli->error, E_USER_WARNING );
    $num = $res->num_rows;
    if ($num) {
        $row = $res->fetch_object();
        $ipa = $row->ip_address;
        $whn = $row->when_voted;
    }

    echo "<br/>";
    echo number_format($num);
    echo " stemmen voor ";
    echo $kleur;
    if ($num)
    {
        echo " MOST RECENTLY ";
        echo $whn;
        echo " FROM IP ";
        echo $ipa;
        echo PHP_EOL;
    }
}

// https://www.experts-exchange.com/articles/5256/Simple-Vote-Counting-in-PHP-and-MySQL.html

echo "Je vote is doorgegeven <br>";

?>
