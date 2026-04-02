<?php
// 1. DATABASE CONNECTION
require_once 'includes/database.php';
$connection = getConnection(); 

// 2. PHP LOGIC (Handling the Vue Fetch Request)
// Since Vue sends data as JSON, we need to decode the input stream
$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $input) {
    header('Content-Type: application/json');

    $firstName  = trim(strip_tags($input['firstName'] ?? ''));
    $lastName   = trim(strip_tags($input['lastName'] ?? ''));
    $email      = filter_var($input['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $message    = trim(strip_tags($input['message'] ?? ''));
    $testAnswer = isset($input['testAnswer']) ? (int)$input['testAnswer'] : 0;
    $honeypot   = trim($input['honeypot'] ?? '');

    $errors = [];

    // Spam Check
    if (!empty($honeypot)) { $errors['honeypot'] = 'Spam detected.'; }
    if ($testAnswer !== 8) { $errors['testAnswer'] = 'Incorrect answer.'; }

    // Validation
    if (!$firstName) { $errors['firstName'] = 'First Name is required.'; }
    if (!$lastName)  { $errors['lastName'] = 'Last Name is required.'; }
    if (!$email)     { $errors['email'] = 'Valid email is required.'; }
    if (!$message)   { $errors['message'] = 'Message is required.'; }

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    // 3. SAVE TO DATABASE (PDO)
    $stmt = $connection->prepare('INSERT INTO contacts (first_name, last_name, email, message) VALUES (:f, :l, :e, :m)');
    $stmt->execute([':f' => $firstName, ':l' => $lastName, ':e' => $email, ':m' => $message]);

    // 4. SEND EMAIL
    $to      = 'amyangsa@icloud.com'; // Your email
    $subject = 'New Inquiries';
    $body    = "Name: $firstName $lastName\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: noreply@armstrng.com\r\nReply-To: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Form submitted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send email.']);
    }
    exit; // Stop execution after JSON response
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | Amy Armstrong</title>
    <link rel="stylesheet" href="css/main.css">
    <script defer src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script type="module" src="js/main.js"></script>
    <script type="module" src="js/contact.js"></script>
</head>
<body class="contact-body">

<header>
    <a href="index.html" class="logo"><img src="images/AA-logo.svg" alt="Logo"></a>
    <nav class="desktop-nav">
        <ul>
            <li><a href="index.html">ARMSTRNG</a></li>
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
            <li><a href="index.html">ARMSTRNG</a></li>
            <li><a href="about.html">About Me</a></li>
            <li><a href="projects.php">Projects</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</div>
</header>

<main class="contact-page">
  <div class="grid-con">
    <div id="app" class="col-span-full m-col-start-3 m-col-end-11">
      
      <section class="contact-header">
        <p class="pre-title">MADE IT THIS FAR?</p>
        <h1>GET IN<br>TOUCH</h1>
        <p class="form-intro">Tell me about your needs and I'll bring your creative vision to life.</p>
      </section>

      <form id="contactForm" class="modern-form" @submit.prevent="submitForm">
        
        <input type="text" id="honeypot" v-model="formData.honeypot" style="display:none !important">

        <div class="form-row">
          <div class="input-group">
            <label for="firstName">First Name <span class="required">*</span></label>
            <input type="text" id="firstName" v-model="formData.firstName">
            <p class="field-error" v-if="errors.firstName">{{errors.firstName}}</p>
          </div>

          <div class="input-group">
            <label for="lastName">Last Name <span class="required">*</span></label>
            <input type="text" id="lastName" v-model="formData.lastName">
            <p class="field-error" v-if="errors.lastName">{{errors.lastName}}</p>
          </div>
        </div>

        <div class="input-group">
          <label for="email">Email Address <span class="required">*</span></label>
          <input type="email" id="email" v-model="formData.email">
          <p class="field-error" v-if="errors.email">{{errors.email}}</p>
        </div>

        <div class="input-group math-test">
          <label for="testAnswer">What is 4 + 4? <span class="required">*</span></label>
          <input type="number" id="testAnswer" v-model="formData.testAnswer">
          <p class="field-error" v-if="errors.testAnswer">{{errors.testAnswer}}</p>
        </div>

        <div class="input-group">
          <label for="message">Your Message <span class="required">*</span></label>
          <textarea id="message" v-model="formData.message" rows="5"></textarea>
          <p class="field-error" v-if="errors.message">{{errors.message}}</p>
        </div>

        <button :class="{'buttonCircle': submitted, 'button': true}" type="submit" class="submit-btn">
          <div class="container">
            <span class="tick">
              <svg v-if="submitted" width="30" height="25" viewBox="0 0 58 45" xmlns="http://www.w3.org/2000/svg">
                <path fill="#b8c1ec" d="M19.11 44.64L.27 25.81l5.66-5.66 13.18 13.18L52.07.38l5.65 5.65" />
              </svg>
              <span v-else class="btn-text">{{buttonText}}</span>
            </span>
          </div>
          <div v-if="!submitted" class="btn-line"></div>
        </button>

        <p class="field-error general" v-if="errors.general">{{errors.general}}</p>
        
        <div v-if="responseMessage" class="response-msg">
          {{responseMessage}}
        </div>
      </form>
    </div>
  </div>
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
                <li><a href="contact.html">Contact</a></li>
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

</body>
</html>


