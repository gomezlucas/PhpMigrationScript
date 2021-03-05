<?php

include 'createObjects.php';
include 'connectionOld.php';
include 'connectionNew.php';

//$materialTypeObj
//$query = "SELECT id, material_type_id, tag_id, theme_id  FROM libraries";

$query_material = "SELECT id, name FROM  material_types";
$query_material_update = "UPDATE material_types SET description = ? WHERE `material_types`.`id` = ?";
$query_material_insert = "INSERT INTO material_types ( `name`, `created_at`) VALUES (?, NOW())";

$query_select_to_migrate = "SELECT * from  libraries";
$query_insert_to_migrate = "INSERT INTO libraries (data) VALUES (?)";

if ($stmt = $mysqliOld->prepare($query_material)) {
    $stmt->execute();
    $stmt->bind_result($id, $name);
    $stmt->store_result();
    while ($stmt->fetch()) {
        // Check Material Type
        foreach ($materialTypeObj as $materialType) {
          //  echo  $materialType['name'] . '   ' . $name . strcmp($materialType['name'],  $name) . "</br> ";
            if ($materialType['name'] == $name) {
             //   echo 'they have the same type ' . $id . '  ' . $materialType['id'] . $name .  "</br> ";
                if ($stmt2 = $mysqliOld->prepare($query_material_update)) {
                    $stmt2->bind_param('ss', $materialType['id'], $id);
                    $stmt2->execute();
                    $stmt2->store_result();
                    $stmt2->close();
                }      
            }
        }
    }
    $stmt->close();
} else {
    $response['status'] = 500;
    $response['message'] = 'DB Error';
    $response['data'] = '';
    header('Content-type: application/json');
    http_response_code(500);
    echo json_encode($response);
    die();
}



// Select to migrate 
if ($stmt3 = $mysqliOld->prepare($query_select_to_migrate)) {
    $stmt3->execute();
     $result = $stmt3->get_result();
     $array = $result->fetch_all(MYSQLI_ASSOC);
    
    foreach($array as $item){
        echo $item;
        if($stmt4 = $mysqliNew->prepare($query_insert_to_migrate)){
           $stmt4->bind_param('s', $item);
           $stmt4->execute();
       }
    }
    }
