<?php
require_once 'includes/database.php';
$connection = getConnection();

//grabs id
$projectId = $_GET['id'] ?? null;

if ($projectId) {
    // instead of DELETE FROM, it is the is_deleted flag to 1, which removes it from site but stay in db
    $query = "UPDATE projects SET is_deleted = 1 WHERE id = ?";
    $stmt = $connection->prepare($query);
    
    if ($stmt->execute([$projectId])) {
        //takes back to dashboard
        header("Location: admin.php?deleted=success");
        exit;
    } else {
        echo "Error: Could not delete the project.";
    }
} else {
    echo "No ID provided.";
}
?>