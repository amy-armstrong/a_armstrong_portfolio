<?php
require_once 'includes/database.php';
$connection = getConnection();

$projectId = $_GET['id'] ?? null;
$stmt = $connection->prepare("SELECT * FROM projects WHERE id = ? AND is_deleted = 0");
$stmt->execute([$projectId]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Name | Amy Armstrong</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <header>
        <h1 class="logo hidden">AA</h1>
        <img src="images/AA-logo.svg" alt="Logo">
        <nav class="desktop-nav">
            <ul>
                <li><a href="index.html">DESIGNER & DEVELOPER</a></li>
                <li><a href="about.html">About Me</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <button id="hamburger">&#9776;</button>
    </header>
    
    <div id="menu" class="overlay">
        <button id="close">&times;</button>
        <nav>
            <ul>
                <li><a href="index.html">DESIGNER & DEVELOPER</a></li>
                <li><a href="about.html">About Me</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </div>

    <main>
        <section class="project-detail">
            <h2 class="project-title split"><?= $project['title']; ?></h2>

            <picture>
                <source media="(min-width: 768px)" srcset="images/<?= $project['image_desktop']; ?>">
                <img src="images/<?= $project['image_mobile']; ?>" alt="<?= $project['title']; ?> Image" class="project-main-image">
            </picture>

            <section class="project-overview">
                <h3>PROJECT OVERVIEW</h3>
                <p><?= $project['description']; ?></p>
            </section>

            <section class="project-info">
                <div class="info-grid">
                    <div class="info-item">
                        <strong>TIMEFRAME</strong>
                        <span><?= $project['timeframe']; ?></span>
                    </div>
                    <div class="info-item">
                        <strong>MY ROLE</strong>
                        <span><?= $project['role']; ?></span>
                    </div>
                    <div class="info-item">
                        <strong>TOOLS</strong>
                        <span><?= $project['tools']; ?></span>
                    </div>
                </div>
            </section>

            <section class="project-challenge">
                <h3>THE CHALLENGE</h3>
                <p><?= $project['challenge']; ?></p>
            </section>

            <section class="project-outcome">
                <h3>OBJECTIVE / GOAL</h3>
                <p><?= $project['objective']; ?></p>
            </section>
            
            <a href="projects.php" class="view-more">Back to All Projects</a>
        </section>
    </main>

    <footer>
        <div class="footer-logo">
            <img src="images/AA-logo.svg" alt="Logo">
            <h2 class="hidden">Footer logo</h2>
        </div>

        <div class="footer-nav">
            <h3 class="hidden">nav</h3>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>

        <div class="footer-social">
            <h3 class="hidden">socials</h3>
            <ul>
                <li><a href="https://www.instagram.com/yourusername">Instagram</a></li>
                <li><a href="https://www.linkedin.com/in/yourusername">LinkedIn</a></li>
                <li><a href="https://github.com/yourusername">GitHub</a></li>
            </ul>
        </div>

        <div class="footer-bottom">
            <p>© 2025 AMY ARMSTRONG</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/SplitText.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/TextPlugin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/ScrambleTextPlugin.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
