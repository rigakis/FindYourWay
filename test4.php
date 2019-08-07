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

$client = $_GET['client'];
$endServer = $_GET['endserver'];





$get_client_addr = mysqli_query($conn, "SELECT ip_addr FROM client_info WHERE alias = $client");

?> 
<!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <!--Script Reference[1]-->
      <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
		<script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
		ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
    </head>
    <body>
      <!--Chart Placement[2]-->
      <div id="myChart"></div>
      <script>
	  
	  
		//get client address
		
		var client_addr= [<?php
			while($get_client_addr_f=mysqli_fetch_array($get_client_addr))
				echo $get_client_addr_f['ip_addr'].',';
			?>];
		//alert(client_addr);
		// get minimum date for graph
		// <?php
			// $min_dates=mysqli_query($conn,"SELECT (UNIX_TIMESTAMP(MIN(date))*1000) AS date1
			// FROM connectio_info 
			// inner join ping on connectio_info.id=ping.id
			// where connectio_info.ip_end_server = '$endServer' and connectio_info.ip_addr_client = '$client_addr'")
		// ?>
		
		// var min_date_graph= [<?php
			// while($min_date=mysqli_fetch_array($min_dates))
				// echo $min_date['date1'].',';
			// ?>];
			
		// get data set [date][ping_time] for each relay and direct connect between client and end server
		
		// rodi
		// <?php
		// $result_set=mysqli_query($conn,"SELECT ping_time, (UNIX_TIMESTAMP((date))*1000) AS date1
			// FROM connectio_info
			// inner join ping on connectio_info.id=ping.id
			// WHERE connectio_info.ip_end_server = '$endServer' and connectio_info.ip_addr_client = '$client_addr' and connectio_info.ip_addr_relay = '147.52.19.43'")
			// ?>

		// var data_series_rodi= [<?php
			// while($series=mysqli_fetch_array($result_set))
				// echo '['.$series['date1'].','.$series['ping_time'].']'.',';
			// ?>];
		
		//syko
		// <?php
		// $result_set=mysqli_query($conn,"SELECT ping_time, (UNIX_TIMESTAMP((date))*1000) AS date1
			// FROM connectio_info
			// inner join ping on connectio_info.id=ping.id
			// WHERE connectio_info.ip_end_server = '$endServer' and connectio_info.ip_addr_client = '$client_addr' and connectio_info.ip_addr_relay = '147.52.19.22'")
			// ?>

		// var data_series_syko= [<?php
			// while($series=mysqli_fetch_array($result_set))
				// echo '['.$series['date1'].','.$series['ping_time'].']'.',';
			// ?>];
		
		
		//ananas
		// <?php
		// $result_set=mysqli_query($conn,"SELECT ping_time, (UNIX_TIMESTAMP((date))*1000) AS date1
			// FROM connectio_info
			// inner join ping on connectio_info.id=ping.id
			// WHERE connectio_info.ip_end_server = '$endServer' and connectio_info.ip_addr_client = '$client_addr' and connectio_info.ip_addr_relay = '147.52.19.61'")
			// ?>

		// var data_series_ananas= [<?php
			// while($series=mysqli_fetch_array($result_set))
				// echo '['.$series['date1'].','.$series['ping_time'].']'.',';
			// ?>];
		
		
		//direct
		// <?php
		// $result_set=mysqli_query($conn,"SELECT ping_time, (UNIX_TIMESTAMP((date))*1000) AS date1
			// FROM connectio_info
			// inner join ping on connectio_info.id=ping.id
			// WHERE connectio_info.ip_end_server = '$endServer' and connectio_info.ip_addr_client = '$client_addr' and connectio_info.ip_addr_relay = 'None-Direct'")
			// ?>

		// var data_series_direct= [<?php
			// while($series=mysqli_fetch_array($result_set))
				// echo '['.$series['date1'].','.$series['ping_time'].']'.',';
			// ?>];
		
		var myConfig = 
        {
            "type": "line",
            "utc": true,
            "title": {
                "text": "Webpage Analytics",
                "font-size": "24px",
                "adjust-layout":true
            },
            "plotarea": {
                "margin": "dynamic 45 60 dynamic",
            },
            "legend": {
                "layout": "float",
                "background-color": "none",
                "border-width": 0,
                "shadow": 0,
                "align":"center",
                "adjust-layout":true,
                "item":{
                  "padding": 7,
                  "marginRight": 17,
                  "cursor":"hand"
                }
            },
            "scale-x": {
				"min-value":36000000,
				"shadow": 0,
                "transform": {
                    "type": "date",
                    "all": "%D, %d %M %Y<br />%h:%i %A",
                    "guide": {
                        "visible": false
                    },
                    "item": {
                        "visible": false
                    }
                },
                "label": {
                    "visible": false
                },
                "minor-ticks": 0
			},
            "scale-y": {
                "values": "0:100:0.01",
                "line-color": "#f6f7f8",
                "shadow": 0,
                "guide": {
                    "line-style": "dashed"
                },
                "label": {
                    "text": "Page Views",
                },
                "minor-ticks": 0,
                "thousands-separator": ","
            },
            "crosshair-x": {
                "line-color": "#efefef",
                "plot-label": {
                    "border-radius": "5px",
                    "border-width": "1px",
                    "border-color": "#f6f7f8",
                    "padding": "10px",
                    "font-weight": "bold"
                },
                "scale-label": {
                    "font-color": "#000",
                    "background-color": "#f6f7f8",
                    "border-radius": "5px"
                }
            },
            "tooltip": {
                "visible": false
            },
            "plot": {
                "highlight":true,
                "tooltip-text": "%t views: %v<br>%k",
                "shadow": 0,
                "line-width": "2px",
                "marker": {
                    "type": "circle",
                    "size": 3
                },
                "highlight-state": {
                    "line-width":3
                },
                "animation":{
                  "effect":1,
                  "sequence":2,
                  "speed":100,
                }
            },
            "series": [
                {
                    "values":  [
                        [0,714.6],[3600000,714.6]
                    ],
                    "text": "rodi",  // anti gia Pricing exoume tous end server
                    "line-color": "#007790",
                    "legend-item":{
                      "background-color": "#007790",
                      "borderRadius":5,
                       "font-color":"white"
                    },
                    "legend-marker": {
                        "visible":false
                    },
                    "marker": {
                        "background-color": "#007790",
                        "border-width": 1,
                        "shadow": 0,
                        "border-color": "#69dbf1"
                    },
                    "highlight-marker":{
                      "size":6,
                      "background-color": "#007790",
                    }
                },
                {
                    "values": [
                        [0,714.6],[3600000,714.6]
                    ],
                    "text": "Documentation",
                    "line-color": "#009872",
                    "legend-item":{
                      "background-color": "#009872",
                      "borderRadius":5,
                       "font-color":"white"
                    },
                    "legend-marker": {
                        "visible":false
                    },
                    "marker": {
                        "background-color": "#009872",
                        "border-width": 1,
                        "shadow": 0,
                        "border-color": "#69f2d0"
                    },
                    "highlight-marker":{
                      "size":6,
                      "background-color": "#009872",
                    }
                },
                {
                    "values": [
                        [3600000,536.9],[7200000,536.9]
                    ],
                    "text": "Support",
                    "line-color": "#da534d",
                    "legend-item":{
                      "background-color": "#da534d",
                      "borderRadius":5,
                      "font-color":"white"
                    },
                    "legend-marker": {
                        "visible":false
                    },
                    "marker": {
                        "background-color": "#da534d",
                        "border-width": 1,
                        "shadow": 0,
                        "border-color": "#faa39f"
                    },
                    "highlight-marker":{
                      "size":6,
                      "background-color": "#da534d",
                    }
                }
            ]
        };
	<?php
/* Close the connection */
$conn->close(); 
?>
 window.onload=function(){
zingchart.render({ 
	id : "myChart", 
	data : myConfig, 
	width: '100%' 
 });};
	 
	 </script>

    </body>
    </html>
