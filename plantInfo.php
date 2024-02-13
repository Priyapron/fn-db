<?php
include 'conn.php';
header("Access-Control-Allow-Origin: *");

$xcase = $_POST['case'];

// Common variables
$plant_id = mysqli_real_escape_string($conn, $_POST['plant_id']);
$plant_name = mysqli_real_escape_string($conn, $_POST['plant_name']);

$response = array();

switch ($xcase) {
    case '1': // insert
        $sql = "INSERT INTO plant_info (plant_id, plant_name)
                VALUES (?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $plant_id, $plant_name);

        if (mysqli_stmt_execute($stmt)) {
            $response['status'] = 200;
            $response['message'] = "Plant data inserted successfully";
        } else {
            $response['status'] = 500;
            $response['message'] = "Failed to insert plant data: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        break;

    case '2': // update
        $sql = "UPDATE plant_info
                SET plant_name=?
                WHERE plant_id=?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $plant_name, $plant_id);

        if (mysqli_stmt_execute($stmt)) {
            $response['status'] = 200;
            $response['message'] = "Plant data updated successfully";
        } else {
            $response['status'] = 500;
            $response['message'] = "Failed to update plant data: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        break;

    case '3': // delete
        $sql = "DELETE FROM plant_info WHERE plant_id=?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $plant_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $response['status'] = 200;
            $response['message'] = "Plant data deleted successfully";
        } else {
            $response['status'] = 500;
            $response['message'] = "Failed to delete plant data: " . mysqli_error($conn);
        }
        
        mysqli_stmt_close($stmt);
        break;

    default:
        $response['status'] = 400;
        $response['message'] = "Invalid case provided";
        break;
}

echo json_encode($response);

mysqli_close($conn);
?>
