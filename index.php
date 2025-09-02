<?php 
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    if($username != ""){
        $_SESSION['username'] = htmlspecialchars($username);
        $_SESSION['question_number'] = 1;
        $_SESSION['score'] = 0;
        header("Location: game.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>من سيربح المليون</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
        <div class="background">
        <img src="images/index.png" class="audience">
        <img src="images/index.png" class="seats">
        <img src="images/player.png" class="player">
    </div>
    <div class="container intro-container">
        <div class="intro-content">
            <h1>🎉 من سيربح المليون 🎉</h1>
            <form method="post" class="intro-form">
                <input type="text" name="username" placeholder="أدخل اسمك" required>
                <button type="submit" class="btn start-btn">ابدأ اللعبة</button>
            </form>
        </div>
    </div>
</body>
</html>