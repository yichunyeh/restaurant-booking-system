<html>
<title>booking page</title>
<body bgcolor="#ffe4db">
<?php
$servername = "localhost";
$username = "root";
$password = "A123456j*";
$dbname = "Restaurant";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//$conn1 = new mysqli($servername, $username, $password, $dbname);


// Check connection
echo $conn->connect_error;
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error());
}
//echo "Connected successfully";

//print_r($_POST);
$u_name = $_POST["name"];
$number = $_POST["num"];
$key = $_POST["keyword"];
$time = $_POST["time"];
echo "<h1>AVAILABLE RESTAURANT</h1>";

//echo "number" . $number;

//query for the user
//echo $u_name;
$u = 'SELECT * FROM customer WHERE cname="' . $u_name . '"';
//$u = "SELECT * FROM customer";
//echo $u;
$cid = $conn->query($u);
$id=0;
while($row1 = $cid->fetch_assoc()){
    echo "USER_ID:" . $row1["cid"];
    echo "<br>";
    $id = $row1["cid"];
}
//$row->free();
//$conn->close();
//$forward_data = array("number"=>$number, "time"=>$time, "id"=>$id);
//echo $forward_data["number"];
//echo "key:" . $key;
//query for the restaurant
if(!$key){
    //echo "isnull";
    $r = "SELECT * FROM restaurant WHERE rid NOT IN (SELECT rid FROM booking NATURAL JOIN restaurant WHERE btime='".$time."' GROUP BY rid HAVING capacity-SUM(quantity)<$number) AND capacity>$number";
    //echo $r;
    
    //$r = "SELECT * FROM restaurant NATURAL JOIN (SEL) WHERE capacity>$number";
}
else{
    //echo "not null";
    $r = "SELECT * FROM restaurant WHERE rid NOT IN (SELECT rid FROM booking NATURAL JOIN restaurant WHERE btime='".$time."' GROUP BY rid HAVING capacity-SUM(quantity)<$number) AND capacity>$number AND (rname like '%$key%' OR description like '%$key%')"; 
}

$result = $conn->query($r);
//echo $result;

if ($result->num_rows>0){
    //echo "into query";
    echo "<form name='booking' action='setBooking.php' method='post'>";
    echo "<table><tr><th>ID</th><th>Name</th><th>Address</th><th>description</th><th>capacity</th><th></th>";
    //$index = 0; //give each restaurant an index
    //echo "<input type='hidden' name='num' value="' . $number .'">";
    while($row = $result->fetch_assoc()){
        echo "<tr><td>" . $row["rid"] . "</td><td>" . $row["rname"] . "</td><td>" . $row["raddress"] . "</td><td>" . $row["description"] . "</td><td>" . $row["capacity"] . "</td><td><input type='hidden' name='time' value=$time><input type='hidden' name='num' value=$number><input type='hidden' name='cid' value=$id><button type='submit' name='r_data' value='" . $row['rid'] . "'>select</button>";
        echo "</td></tr>";
    }   
    echo "</table></form>";
    echo "<font size='4'><a href='index.html'>Back</a></font>";
} 
else{
    echo "0 result";
}

$conn->close();
?>

</body>
</html>

