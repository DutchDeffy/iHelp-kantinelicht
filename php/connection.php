<?php // RAY_EE_voting_create.php
/**
 * https://www.experts-exchange.com/articles/5256/Simple-Vote-Counting-in-PHP-and-MySQL.html
 * Demonstrate the voting algorithm -- Create the Tables
 */
error_reporting(E_ALL);
// CONNECTION AND SELECTION VARIABLES FOR THE DATABASE
$db_host = "localhost"; // PROBABLY THIS IS OK
$db_name = "ihelpdmx";        // GET THESE FROM YOUR HOSTING COMPANY
$db_user = "ihelp";
$db_word = "WACHTWOORD";
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
// THESE LINES REMOVE EXISTING VERSIONS OF THE TABLES
$mysqli->query("DROP TABLE EE_vote_colors");
$mysqli->query("DROP TABLE EE_vote_votes");
// CREATE THE COLOR TABLE
$sql
=
"
CREATE TABLE EE_vote_colors
( _key  INT         NOT NULL AUTO_INCREMENT PRIMARY KEY
, color VARCHAR(10) NOT NULL DEFAULT ''
)
"
;
$res = $mysqli->query($sql) or trigger_error( "$sql<br/>" . $mysqli->error, E_USER_WARNING );
// CREATE THE VOTES TABLE
$sql
=
"
CREATE TABLE EE_vote_votes
( _key       INT         NOT NULL AUTO_INCREMENT PRIMARY KEY
, color      VARCHAR(10) NOT NULL DEFAULT ''
, ip_address VARCHAR(16) NOT NULL DEFAULT 'unknown'
, when_voted TIMESTAMP
)
"
;
$res = $mysqli->query($sql) or trigger_error( "$sql<br/>" . $mysqli->error, E_USER_WARNING );
// LOAD THE STANDARD ROY-G-BIV DATA INTO THE COLOR TABLE
$res = $mysqli->query( "INSERT INTO stemkleuren ( kleur ) VALUES ( 'red'    )" );
$res = $mysqli->query( "INSERT INTO stemkleuren ( kleur ) VALUES ( 'orange' )" );
$res = $mysqli->query( "INSERT INTO stemkleuren ( kleur ) VALUES ( 'yellow' )" );
$res = $mysqli->query( "INSERT INTO stemkleuren ( kleur ) VALUES ( 'green'  )" );
$res = $mysqli->query( "INSERT INTO stemkleuren ( kleur ) VALUES ( 'lgreen' )" );
$res = $mysqli->query( "INSERT INTO stemkleuren ( kleur ) VALUES ( 'blue'   )" );
$res = $mysqli->query( "INSERT INTO stemkleuren ( kleur ) VALUES ( 'purple' )" );
$res = $mysqli->query( "INSERT INTO stemkleuren ( kleur ) VALUES ( 'pink'   )" );
$res = $mysqli->query( "INSERT INTO stemkleuren ( kleur ) VALUES ( 'clz'    )" );
