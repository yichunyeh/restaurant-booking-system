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

// Check connection
echo $conn->connect_error;
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error());
}
//echo "Connected successfully";
$query = "SELECT * FROM booking WHERE bid =(SELECT MAX(bid) FROM booking)";

//$d = $_POST["all_data"];
//print_r($_POST);
$rid = $_POST["r_data"];
//print_r($_POST);
$result = $conn->query($query);
if($result->num_rows>0){
    //echo "query succeed";
    $row = $result->fetch_assoc();
    $bid = $row["bid"] +1;
}
$cid = $_POST["cid"];
$btime = substr($_POST["time"], 0, 10) . " " . substr($_POST["time"], 11) . ":00";
$q = $_POST["num"];

//echo "d" . print_r(array_values($d["num"]));
//echo "rid" . $rid;
//echo "bid" . $bid;
//echo "cid" . $cid;
//echo "btime" . $btime;
//$key = $_POST["keyword"];
$sql_insert = "INSERT INTO booking (bid, cid, rid, btime, quantity) VALUES ('$bid', '$cid', '$rid', '$btime', '$q')";
//echo $sql_insert;

$sql_show = "SELECT bid, rname, btime, quantity FROM booking NATURAL JOIN restaurant WHERE cid=$cid";

$add = $conn->query($sql_insert);
echo $conn->error;
$result = $conn->query($sql_show);

//add user name here!

echo "<h1>BOOKING HISTORY</h1>";


if ($result->num_rows>0){
    //echo "into query";
    echo "<table><tr><th>ID</th><th>Name</th><th>Time</th><th>Number of people</th></tr>";

    while($row = $result->fetch_assoc()){
        echo "<tr><td>" . $row["bid"] . "</td><td>" . $row["rname"] . "</td><td>" . $row["btime"] . "</td><td>" . $row["quantity"] . "</td></tr>";
    }
    echo "</table>";
    echo "<font size='4'><a href='index.html'>Back</a></font>";
}


?>

</body>
</html>
