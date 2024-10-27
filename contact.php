<!DOCTYPE HTML>
<html>
<style>
header {
    right: 0;
    left: 0;
    text-align: center;
    color: white; 
    background: #405dde;
    border-style: ridge;
    margin: 0;
    padding-top: 20px;
    padding-bottom: 20px;
    margin-bottom: 20px;
}

body {
    background-image: url('https://st4.depositphotos.com/1022135/25748/i/450/depositphotos_257486682-stock-photo-group-young-people-sportswear-talking.jpg');
    background-size: cover;
    margin: 0;
}

.contact-section {
    width: 80%;
    max-width: 600px; 
    background: #c4d7f5;
    color: black;
    text-align: center; 
    padding: 30px;
    margin: 20px auto; 
    font-size: 120%;
    border-style: ridge;
    border-radius: 8px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
}

input, textarea {
    height: 40px;
    width: calc(100% - 20px); 
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #0056b3; 
    border-radius: 5px; 
}

textarea {
    height: 100px;
}

footer {
    right: 0;
    left: 0;
    text-align: center;
    color: white; 
    background: #405dde;
    border-style: ridge;
    margin: 0 auto;
    padding-top: 20px;
    padding-bottom: 20px;
    position: fixed;
    bottom: 0;
}

.center-button {
    margin-top: 20px; 
}
</style>
<?php
session_start();
$success_message = "";
$errors = [];

// Retrieve success message and errors from session if available
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Clear the message after displaying
}

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']); // Clear errors after displaying
}
?>
<body>
<header>
    <h1 style="font-size: 40px">Huan Fitness Pal</h1>
    <h4 style="font-size: 20px"><i>For all your fitness needs...</i></h4>
</header>
<div class="contact-section">
    <h3>Contact Us</h3>
    
    <?php if (!empty($success_message)): ?>
        <div style="color: green;"><?= $success_message ?></div>
    <?php endif; ?>
    
    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form action="contact_process.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" formnovalidate>
        <input type="email" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" disabled>
        <textarea name="message" placeholder="Your Message" formnovalidate></textarea>
        <input type="submit" value="Send Message">
    </form>

    <div class="center-button">
        <form action="user.php">
            <input type="submit" value="Back">
        </form>
    </div>
</div>

<footer>
    <h4>
        <i>Huan Sdn. Bhd</i><br>
        <i>All Rights Reserved&copy;</i>
    </h4>
</footer>

</body>
</html>
