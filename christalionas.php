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

$sql = "SELECT *
		FROM connectio_info 
		inner join ping on connectio_info.id=ping.id
		where connectio_info.ip_end_server = 'www.mit.edu'";
$result = mysqli_query($conn, $sql);




?> 
   <!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <!--Script Reference[1]-->
      <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    </head>
    <body>
      <!--Chart Placement[2]-->
      <div id="myChart"></div>
      <script>
        var ping_num=[<?php
			while($pings=mysqli_fetch_array($result))
				echo $pings['ping_time'].','; /* We use the concatenation operator '.' to add comma delimiters after each data value. */
			?>];
			<?php
			
		$data=mysqli_query($conn,"SELECT *
			FROM connectio_info 
			inner join ping on connectio_info.id=ping.id
			where connectio_info.ip_end_server = 'www.mit.edu'")
			?>
			
		var myLabels=[<?php 
			while($dates=mysqli_fetch_array($data))
				echo '"'.$dates['date'].'",'; /* The concatenation operator '.' is used here to create string values from our database names. */
			?>];

			<?php
/* Close the connection */
$conn->close(); 
?>
			
		window.onload=function(){	
			zingchart.render({
				id:"myChart",
				width:"100%",
				height:400,
				data:{
				"type":"bar",
				"title":{
					"text":"Data Pulled from MySQL Database"
				},
				"scale-x":{
					"labels":myLabels
				},
				"series":[
					{
						"values":ping_num
					}
			]
			}
			});
		};
	 
	 </script>

    </body>
    </html>
