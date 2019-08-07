<?php 
include 'php/include.php';

    $searchTerm = $_GET['term'];
$query="SELECT * FROM Companies  WHERE company_name LIKE '%$searchTerm%' ";

	$results = $mysqli->query($query);


    // $query = $mysqli->query("SELECT * FROM Companies WHERE company_name LIKE '%".$searchTerm."%' ORDER BY company_name ASC");
    //get matched data from skills table
	while($row = $results->fetch_array(MYSQL_ASSOC)) {
        $data[] = $row['company_name'];
    }
    
    //return json data
    echo json_encode($data);


 ?>