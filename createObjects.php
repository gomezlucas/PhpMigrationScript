<?php 

include 'connectionNew.php';
 
// Create Material Type Object 
 $query = "SELECT id, name FROM material_types";

if ($stmt = $mysqliNew->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($id,$name);
    $materialTypeObj = [];
 while($stmt->fetch()){
        $materialTypeObj[] = array('id'=>$id,'name'=>$name);
    }
	$stmt->close();
 }else{
     $response['status'] = 500;
    $response['message'] = 'DB Error';
    $response['data'] = '';
    header('Content-type: application/json');
    http_response_code(500);
    echo json_encode($response);
    die();
}



/*


if ($stmt = $mysqli->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($id, $material_type_id, $tag_id, $theme_id);
    $stmt->store_result();
    while ($stmt->fetch()) {
        // Check Material Type
        echo $id. " " . $material_type_id. " ";
        if ($stmt2 = $mysqli->prepare($query_material)) {
            $stmt2->bind_param("s", $material_type_id);
            $stmt2->execute();
            $stmt2->bind_result($id2, $name);
            $stmt2->fetch();
            echo ($name)."</br>";
            $stmt2->close();
        } else {
            $response['status'] = 500;
            $response['message'] = 'DB Error';
            header('Content-type: application/json');
            http_response_code(500);
            echo mysqli_error($mysqli);
            die();
        }

        

        
    }
} else {
    $response['status'] = 500;
    $response['message'] = 'DB Error';
    $response['data'] = '';
    header('Content-type: application/json');
    http_response_code(500);
    echo json_encode($response);
    die();
}
*/