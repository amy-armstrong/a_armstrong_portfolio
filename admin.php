<?php
require_once 'includes/database.php';
$connection = getConnection();

// 1. fetch projects that arent soft-deleted
$stmt = $connection->query("SELECT id, title, timeframe FROM projects WHERE is_deleted = 0 ORDER BY id DESC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Portfolio Admin Dashboard</title>
    <link rel="stylesheet" href="css/main.css">
    <style>
    :root {
        --pink: #ff85a2;
        --bg: #121212;   
        --text: #ffffff;
        --border: #333333;
    }

    body { 
        background-color: var(--bg); 
        color: var(--text); 
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.6;
    }
    
    .admin-container { 
        max-width: 900px; 
        margin: 60px auto; 
        padding: 20px; 
    }

    h1 { 
        font-weight: 300; 
        letter-spacing: -1px; 
        margin-bottom: 40px;
    }

    .btn-add { 
        color: var(--pink); 
        text-decoration: none; 
        border: 1px solid var(--pink);
        padding: 8px 16px;
        font-size: 0.9em;
        transition: all 0.2s;
    }

    .btn-add:hover { background: var(--pink); color: #000; }

    .admin-table { 
        width: 100%; 
        border-collapse: collapse; 
        margin-top: 50px; 
    }

    .admin-table th { 
        text-align: left; 
        font-size: 0.75em; 
        text-transform: uppercase; 
        letter-spacing: 2px;
        color: #666;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border);
    }

    .admin-table td { 
        padding: 20px 0; 
        border-bottom: 1px solid var(--border);
        font-size: 0.95em;
    }

    .btn-edit { 
        color: var(--text); 
        text-decoration: none; 
        border-bottom: 1px solid var(--pink); 
        margin-right: 20px;
    }

    .btn-delete { 
        color: #666; 
        text-decoration: none; 
        font-size: 0.8em;
    }

    .btn-delete:hover { color: #ff4d4d; }
</style>
</head>
<body>
    <div style="max-width: 1000px; margin: 50px auto; padding: 20px;">
        <h1>Portfolio CMS Dashboard</h1>
        <p>Hiiiii, Amy! Here you can manage your work.</p>
        
        <a href="admin_create.php" class="btn-add">+ Add New Project</a>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Project Title</th>
                    <th>Timeframe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= $project['id']; ?></td>
                    <td><strong><?= htmlspecialchars($project['title']); ?></strong></td>
                    <td><?= htmlspecialchars($project['timeframe']); ?></td>
                    <td>
                        <a href="admin_edit.php?id=<?= $project['id']; ?>" class="btn-edit">Edit</a>
                        
                        <a href="admin_delete.php?id=<?= $project['id']; ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Are you sure you want to delete this project?')">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div style="margin-top: 30px;">
            <a href="projects.php">← Back to ARMSTRNG.COM</a>
        </div>
    </div>
</body>
</html>