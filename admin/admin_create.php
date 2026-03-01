<?php
require_once 'includes/database.php';
$connection = getConnection();

// runs when the button is clicked
if (isset($_POST['create'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $timeframe = $_POST['timeframe'];
    $role = $_POST['role'];
    $tools = $_POST['tools'];
    $challenge = $_POST['challenge'];
    $objective = $_POST['objective'];
    $image_desktop = $_POST['image_desktop'];
    $image_mobile = $_POST['image_mobile'];

    $query = "INSERT INTO projects (title, description, timeframe, role, tools, challenge, objective, image_desktop, image_mobile, is_deleted) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
    
    $stmt = $connection->prepare($query);
    
    if ($stmt->execute([$title, $description, $timeframe, $role, $tools, $challenge, $objective, $image_desktop, $image_mobile])) {
        // takes u back to list page
        header("Location: projects.php"); 
        exit;
    } else {
        echo "Error: Could not save the project.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Add Project</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="dashboard">
        <div class="create-form" style="max-width: 800px; margin: 0 auto; padding: 20px;">
            <h2>Add New Portfolio Project</h2>
            <form action="admin_add.php" method="post">
                <div class="form-field">
                    <label>Project Title</label>
                    <input type="text" name="title" placeholder="e.g., ZIMA" required>
                </div>
                <div class="form-field">
                    <label>Description</label>
                    <textarea name="description" rows="4"></textarea>
                </div>
                <div class="form-field">
                    <label>Timeframe</label>
                    <input type="text" name="timeframe" placeholder="e.g., 3 Weeks">
                </div>
                <div class="form-field">
                    <label>My Role</label>
                    <input type="text" name="role" placeholder="e.g., UI Developer">
                </div>
                <div class="form-field">
                    <label>Tools Used</label>
                    <input type="text" name="tools" placeholder="e.g., Figma, PHP">
                </div>
                <div class="form-field">
                    <label>The Challenge</label>
                    <textarea name="challenge" rows="4"></textarea>
                </div>
                <div class="form-field">
                    <label>Objective</label>
                    <textarea name="objective" rows="4"></textarea>
                </div>
                <div class="form-field">
                    <label>Desktop Image Filename</label>
                    <input type="text" name="image_desktop" placeholder="zima-desktop.png">
                </div>
                <div class="form-field">
                    <label>Mobile Image Filename</label>
                    <input type="text" name="image_mobile" placeholder="zima-mobile.png">
                </div>
                
                <div style="margin-top: 20px;">
                    <input type="submit" name="create" value="Create Project" class="btn">
                    <a href="projects.php">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>