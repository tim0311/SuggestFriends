<?php
 
/*
 * Following code will get single product details
 * A product is identified by product id (pid)
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// check for post data
if (isset($_GET["email"])) {
    $email = $_GET['email'];
 
    // get a product from products table
    $result = mysql_query("SELECT *FROM friend WHERE (user1=$email OR user2=$email)");
 
    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {
 
            $response["success"] = 1;
			$response["message"] = "Friends found";
			$response["friend"] = array();
			while ($row = mysql_fetch_array($result)) {
				$friend = array();
				$friend['id'] = $row["id"];				
				$friend['user1'] = $row["user1"];
				$friend['user2'] = $row["user2"];	
				$friend['isaccept'] = $row["isaccept"];	
				$friend['isreaded'] = $row["isreaded"];	
				array_push($response["friend"],$friend);
			}
			// echo no users JSON
			echo json_encode($response);
        } else {
            // no product found
            $response["success"] = 0;
            $response["message"] = "No puser found";
 
            // echo no users JSON
            echo json_encode($response);
        }
    } else {
        // no user found
        $response["success"] = 0;
        $response["message"] = "No user found for this email";
 
        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // echoing JSON response
    echo json_encode($response);
}
?>