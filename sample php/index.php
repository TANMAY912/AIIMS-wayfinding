<!DOCTYPE html>
<html>
<head>add two numbers</head>
<body>
<?php

$dbhost = "localhost";

$dbuser = "root";

$dbpass = "root";

$database="mysql";

$conn = new mysqli($dbhost, $dbuser, $dbpass,$database);
//echo "yo";

//if(! $conn and isset($_POST['submit']) ) {
    //die('Could not connect: ' . mysql_error());
//}
//echo 'We have noted your comments !!! ';

//$db = mysql_select_db("mysql", $conn); // Selecting Database from Server
if(isset($_POST['submit'])){ // Fetching variables of the form which travels in URL
$x = $_POST['number1'];
$y= $_POST['number2'];

//echo $name;
//echo $email;

//Insert Query of SQL
    $query = mysqli_query($conn,"insert into mysql.dem0(Number1, Number2) values ('$x', '$y')");
//echo "<br/><br/><span>Will get back to you soon !!!</span>";

}

mysqli_commit($conn);
mysqli_close($conn); // Closing Connection with Server
?>

<?php
$dbhost = "localhost";

$dbuser = "root";

$dbpass = "root";

$database="mysql";

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass,$database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT Number1, Number2 FROM mysql.dem0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "number1: " . $row["Number1"]. " - number2: " . $row["Number2"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>


<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Number1*  : <input class="input" type="integer" name="number1" required><br>
Number2*: <input class="input" type="integer" name="number2" required><br>


<br>
*Indicates Required Fields<br>
<br>
<input class="submit" name="submit" type="submit" value="submit">
</form>
</body>
</html>
