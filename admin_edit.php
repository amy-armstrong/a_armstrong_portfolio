<?php
require_once 'includes/database.php';
$connection = getConnection();

// grabs the project data to fill form
$projectId = $_GET['id'] ?? null;
$stmt = $connection->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$projectId]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) { die("Project not found!"); }

//this is what does the udpate!
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $role = $_POST['role'];
    $image_desktop = $_POST['image_desktop'];
    $timeframe = $_POST['timeframe'];
    $tools = $_POST['tools'];
    $challenge = $_POST['challenge'];
    $objective = $_POST['objective'];
    $image_mobile = $_POST['image_mobile'];

    $query = "UPDATE projects SET 
    title = ?, 
    description = ?, 
    timeframe = ?, 
    role = ?, 
    tools = ?, 
    challenge = ?, 
    objective = ?, 
    image_desktop = ?, 
    image_mobile = ? 
    WHERE id = ?";

    $stmt = $connection->prepare($query);
    
    if ($stmt->execute([$title, $description, $timeframe, $role, $tools, $challenge, $objective, $image_desktop, $image_mobile, $projectId])) {
        header("Location: projects.php?success=updated");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Project | <?= $project['title']; ?></title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="dashboard">
        <h2>Editing: <?= $project['title']; ?></h2>
        <form action="admin_edit.php?id=<?= $project['id']; ?>" method="post">
        
        <div class="form-field">
            <label>Project Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($project['title']); ?>" required>
        </div>

        <div class="form-field">
            <label>Project Overview (Description)</label>
            <textarea name="description" rows="4"><?= htmlspecialchars($project['description']); ?></textarea>
        </div>

        <div class="form-field">
            <label>Timeframe</label>
            <input type="text" name="timeframe" value="<?= htmlspecialchars($project['timeframe']); ?>">
        </div>

        <div class="form-field">
            <label>Your Role</label>
            <input type="text" name="role" value="<?= htmlspecialchars($project['role']); ?>">
        </div>

        <div class="form-field">
            <label>Tools Used</label>
            <input type="text" name="tools" value="<?= htmlspecialchars($project['tools']); ?>">
        </div>

        <div class="form-field">
            <label>The Challenge</label>
            <textarea name="challenge" rows="4"><?= htmlspecialchars($project['challenge']); ?></textarea>
        </div>

        <div class="form-field">
            <label>Objective / Goal</label>
            <textarea name="objective" rows="4"><?= htmlspecialchars($project['objective']); ?></textarea>
        </div>

        <div class="form-field">
            <label>Desktop Image Filename</label>
            <input type="text" name="image_desktop" value="<?= htmlspecialchars($project['image_desktop']); ?>">
        </div>

        <div class="form-field">
            <label>Mobile Image Filename</label>
            <input type="text" name="image_mobile" value="<?= htmlspecialchars($project['image_mobile']); ?>">
        </div>

        <div class="form-actions">
            <input type="submit" name="update" value="Save Changes" class="btn-save">
            <a href="admin.php" class="btn-cancel">Cancel and Go Back</a>
        </div>
      </form>
    </div>
</body>
</html>