

<?php
$servername = "netgate.mysql.ukraine.com.ua";
$username = "netgate_xlsup";
$password = "pj452duj";
$dbname = "netgate_xlsup";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
 mysql_set_charset('utf8',$conn);
 mysqli_set_charset($conn,"utf8");
/*$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Name</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["cat_id"]."</td><td>".$row["cat_name"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
*/
?>