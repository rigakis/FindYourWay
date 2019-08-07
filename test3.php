 <?php
$servername = "db24.grserver.gr";
$username = "mkras_123";
$password = "Jotm0^19";
$dbname = "mkrasaki694897_findyourplace";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM connectio_info";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "id:" . $row["id"]. 
			 "conn_type: "     . $row["conn_type"]. 
			 "date:" 	   . $row["date"]. 
			 "ip_addr_relay: " . $row["ip_addr_relay"].
			 "ip_end_server: " . $row["ip_end_server"].
			 "ip_addr_client:" . $row["ip_addr_client"]."<br>";
    }

} else {
    echo "0 results";
}


?> 
<script>
alert ("asf");
$data=mysqli_query($conn,"SELECT * FROM connectio_info");


var myData=[<?php 
while($info=mysqli_fetch_array($data))
    echo "id :".$info["id"]; ?>];
<?php

$data=mysqli_query($conn,"SELECT * FROM connectio_info");
?>
var myLabels=[<?php 
while($info=mysqli_fetch_array($data))
    echo $info["id"].'",'; /* The concatenation operator '.' is used here to create string values from our database names. */
?>];
</script>
<?php

/* Close the connection */
$mysqli->close(); 
?>
