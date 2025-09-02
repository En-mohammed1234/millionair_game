<?php 
session_start();
$username = $_SESSION['username'] ?? 'اللاعب';
$score = $_SESSION['score'] ?? 0;
session_destroy();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>النتيجة النهائية</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container result-container">
        <div class="result-content">
            <h1>🎉 انتهت اللعبة 🎉</h1>
            <div class="final-score">
                <p>مبروك يا <strong><?=$username?></strong>!</p>
                <p>رصيدك النهائي:</p>
                <div class="score-amount"><?=$score?> $</div>
            </div>
            <a href="index.php" class="btn play-again-btn">🔁 إعادة اللعب</a>
        </div>
    </div>
</body>
</html>