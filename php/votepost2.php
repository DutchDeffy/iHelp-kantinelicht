<?php // RAY_EE_voting_vote.php
/**
 * https://www.experts-exchange.com/articles/5256/Simple-Vote-Counting-in-PHP-and-MySQL.html
 * Demonstrate the voting algorithm -- Collect the Votes
 */
error_reporting(E_ALL);

// CONNECTION AND SELECTION VARIABLES FOR THE DATABASE
$db_host = "localhost"; // PROBABLY THIS IS OK
$db_name = "MYSQL";        // GET THESE FROM YOUR HOSTING COMPANY
$db_user = "root";
$db_word = "iHelp123";

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
// IF WE GOT THIS FAR WE CAN DO QUERIES


// GET THE ARRAY OF COLORS FROM THE DATA BASE
$colors = array();
$sql = "SELECT color FROM EE_vote_colors";
$res = $mysqli->query($sql) or trigger_error( "$sql<br/>" . $mysqli->error, E_USER_WARNING );
while ($row = $res->fetch_object())
{
    $colors[] = $row->color;
}
// ACTIVATE THIS TO SEE THE COLORS
// var_dump($colors);


// IF ANYTHING WAS POSTED RECORD THE VOTE
if (!empty($_POST["color_selections"]))
{
    $ipa = (!empty($_SERVER["REMOTE_ADDR"])) ? $_SERVER["REMOTE_ADDR"] : 'unknown';
    foreach($_POST["color_selections"] as $color => $nothing)
    {
        // NORMALIZE THE POST DATA
        $rgb = $mysqli->real_escape_string(ucfirst(strtolower(trim($color))));

        // SKIP FIELDS THAT ARE NOT PART OF OUR COLOR SET (POSSIBLE ATTACK?)
        if (!in_array($rgb, $colors)) continue;

        // RECORD A VOTE FOR THIS COLOR
        $sql = "INSERT INTO EE_vote_votes ( color, ip_address ) VALUES ( '$rgb', '$ipa' )";
        $res = $mysqli->query($sql) or trigger_error( "$sql<br/>" . $mysqli->error, E_USER_WARNING );
    }
}


// SHOW THE STATISTICS FOR THE COLORS
foreach ($colors as $color)
{
    $ipa = 'none';
    $whn = 'no votes yet';
    $sql = "SELECT ip_address, when_voted FROM EE_vote_votes WHERE color = '$color' ORDER BY when_voted DESC";
    $res = $mysqli->query($sql) or trigger_error( "$sql<br/>" . $mysqli->error, E_USER_WARNING );
    $num = $res->num_rows;
    if ($num) {
        $row = $res->fetch_object();
        $ipa = $row->ip_address;
        $whn = $row->when_voted;
    }

    echo "<br/>";
    echo number_format($num);
    echo " VOTES FOR ";
    echo $color;
    if ($num)
    {
        echo " MOST RECENTLY ";
        echo $whn;
        echo " FROM IP ";
        echo $ipa;
        echo PHP_EOL;
    }
}


// CREATE THE FORM TO RECEIVE THE VOTES
echo '<form method="post">';
echo "<br/>VOTE FOR YOUR FAVORITE COLORS" . PHP_EOL;
foreach ($colors as $color)
{
    echo "<br/>";
    echo '<input type="checkbox" name="color_selections[';
    echo "$color";
    echo ']" />';
    echo $color;
    echo PHP_EOL;
}
echo '<br/><input type="submit" value="VOTE NOW" />' . PHP_EOL;
echo '</form>';
