<?php
require_once 'includes/database.php';
$connection = getConnection(); 
// Error reporting (turn off on production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $recipient = 'youremail@theiremailhere.com';
    $subject = 'Inquiries from mydomain.com';

    $first = trim(strip_tags($_POST['first_name'] ?? ''));
    $last = trim(strip_tags($_POST['last_name'] ?? ''));
    $visitor_email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $message = trim(strip_tags($_POST['message'] ?? ''));

    $fail = [];

    if ($first === '') { $fail[] = 'First Name'; }
    if ($last === '') { $fail[] = 'Last Name'; }
    if (!$visitor_email) { $fail[] = 'Valid Email'; }
    if ($message === '') { $fail[] = 'Message'; }

    if (!empty($fail)) {
        $error_msg = "Please fill out the following fields correctly: " . implode(', ', $fail);
    } else {
        $visitor_name = $first . ' ' . $last;
        $emailBody = "You received a new inquiry:\r\n\r\n";
        $emailBody .= "Name: {$visitor_name}\r\n";
        $emailBody .= "Email: {$visitor_email}\r\n\r\n";
        $emailBody .= "Message:\r\n{$message}\r\n";

        $fromAddress = "no-reply@yourdomain.com";
        $headers = "From: Your Domain <{$fromAddress}>\r\n";
        $headers .= "Reply-To: {$visitor_email}\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

            // Save contact submission to database using PDO
        $stmt = $connection->prepare(
        'INSERT INTO contacts 
        (first_name, last_name, email, message) 
        VALUES (:first_name, :last_name, :email, :message)'
      );
  
    $stmt->bindParam(':first_name', $first);
    $stmt->bindParam(':last_name', $last);
    $stmt->bindParam(':email', $visitor_email);
    $stmt->bindParam(':message', $message);
    $stmt->execute();

        // Send email
        if (mail($recipient, $subject, $emailBody, $headers)) {
            // this takes it to thanks.html
            header("Location: thanks.html");
            exit();
        } else {
            $error_msg = "Sorry, your message could not be sent. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact | Amy Armstrong</title>
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
            <li><a href="projects.html">Projects</a></li>
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
            <li><a href="projects.html">Projects</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</div>

<main class="contact-page">
  <section class="contact-intro">
    <div class="intro-card">
      <h2>LOOKING TO CONNECT?</h2>
      <p>
        Whether you have a cool project, need help with a design, or just 
        want to chat about creative work — I’d love to hear from you.
      </p>
      <img src="images/cloud-3.svg" alt="Decorative cloud">
    </div>
  </section>

  <section class="contact-form-area">
    <h3>SOMETHING MORE SPECIFIC? LEAVE A MESSAGE AND I’LL GET BACK TO YOU SOON.</h3>

    <?php if (!empty($error_msg)): ?>
        <p class="form-error"><?php echo htmlspecialchars($error_msg); ?></p>
    <?php endif; ?>

    <form class="contact-form" action="contact.php" method="POST">

      <div class="row">
        <div class="form-group">
          <label>First Name</label>
          <input type="text" name="first_name" placeholder="" value="<?php echo htmlspecialchars($first ?? ''); ?>">
        </div>

        <div class="form-group">
          <label>Last Name</label>
          <input type="text" name="last_name" placeholder="" value="<?php echo htmlspecialchars($last ?? ''); ?>">
        </div>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="" value="<?php echo htmlspecialchars($visitor_email ?? ''); ?>">
      </div>

      <div class="form-group">
        <label>Message</label>
        <textarea name="message"><?php echo htmlspecialchars($message ?? ''); ?></textarea>
      </div>

      <button type="submit" class="submit-btn">Submit</button>
    </form>
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
          <li><a href="projects.html">Projects</a></li>
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
<script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/ScrambleTextPlugin.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/SplitText.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/TextPlugin.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>


