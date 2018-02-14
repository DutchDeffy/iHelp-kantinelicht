?php
 
 
function Connect()
{
 $dbhost = "10.100.137.78";
 $dbuser = "ihelp";
 $dbpass = "WACHTWOORDHIER";
 $dbname = "ihelpdmx";
 
 // Create connection
 $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($conn->connect_error);
 
if (!$conn) {
    die("Connectie met MySQL gefaald: " . mysqli_connect_error());
}

$sql = "CREATE TABLE stemkleuren (
 _key       INT         NOT NULL AUTO_INCREMENT PRIMARY KEY
, kleur      VARCHAR(10) NOT NULL DEFAULT ''
, ip_address VARCHAR(16) NOT NULL DEFAULT 'unknown'
, when_voted TIMESTAMP
)";
 
?>
