<?php
include 'conn.php';
header("Access-Control-Allow-Origin: *");

$xcase = $_POST['case'];

// Common variables
$green_house_code = mysqli_real_escape_string($conn, $_POST['green_house_code']);
$green_house_name = mysqli_real_escape_string($conn, $_POST['green_house_name']);

$response = array();

switch ($xcase) {
    case '1': // insert
        $sql = "INSERT INTO growing_info (green_house_code, green_house_name)
                VALUES (?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $green_house_code, $green_house_name);

        if (mysqli_stmt_execute($stmt)) {
            $response['status'] = 200;
            $response['message'] = "Growing data inserted successfully";
        } else {
            $response['status'] = 500;
            $response['message'] = "Failed to insert growing data: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        break;

    case '2': // update
        $sql = "UPDATE growing_info
                SET green_house_name=?
                WHERE green_house_code=?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $green_house_name, $green_house_code);

        if (mysqli_stmt_execute($stmt)) {
            $response['status'] = 200;
            $response['message'] = "Growing data updated successfully";
        } else {
            $response['status'] = 500;
            $response['message'] = "Failed to update growing data: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        break;

    case '3': // delete
        $sql = "DELETE FROM growing_info WHERE green_house_code=?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $green_house_code);
        
        if (mysqli_stmt_execute($stmt)) {
            $response['status'] = 200;
            $response['message'] = "Growing data deleted successfully";
        } else {
            $response['status'] = 500;
            $response['message'] = "Failed to delete growing data: " . mysqli_error($conn);
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
