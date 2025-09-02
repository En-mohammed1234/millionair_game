<?php 
session_start();
if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit;
}

// قائمة الجوائز (من الأصغر إلى الأكبر)
$prizes = [100, 200, 300, 500, 1000, 2000, 4000, 8000, 16000, 32000, 64000, 125000, 250000, 500000, 1000000];

if(!isset($_SESSION['question_number'])){
    $_SESSION['question_number'] = 1;
    $_SESSION['score'] = 0;
}

$question_number = $_SESSION['question_number'];

// الاتصال بقاعدة البيانات
$dbFile = __DIR__ . '/questions.db';
if (!file_exists($dbFile)) {
    die("قاعدة البيانات غير موجودة. يرجى تشغيل setup.php أولاً.");
}

$db = new PDO("sqlite:$dbFile");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->execute([$question_number]);
$question = $stmt->fetch(PDO::FETCH_ASSOC);

// إذا لم يوجد سؤال، انتقل إلى صفحة النتائج
if(!$question){
    header("Location: result.php");
    exit;
}

// معالجة الإجابات
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['answer'])){
        $answer = $_POST['answer'];
        if($answer == $question['correct']){
            $_SESSION['score'] = $prizes[$question_number - 1];
            $_SESSION['question_number']++;
            header("Location: game.php");
            exit;
        } else {
            header("Location: result.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>السؤال <?=$_SESSION['question_number']?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="background">
        <img src="images/audience.jpg" class="audience">
        <img src="images/seats.png" class="seats">
        <img src="images/player.png" class="player">
    </div>
    
    <div class="container game-container">
        <div class="question-header">
            <div class="question-info">
                <div class="question-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h2>السؤال <?=$_SESSION['question_number']?></h2>
            </div>
            <div id="timer-container">
                <div id="timer-progress"></div>
                <div id="timer-text">15</div>
            </div>
        </div>
        
        <div class="question-text">
            <i class="fas fa-quote-left quote-icon"></i>
            <?=$question['question']?>
            <i class="fas fa-quote-right quote-icon"></i>
        </div>
        
        <form method="post" class="options" id="options-form">
            <?php 
            $options = ['option1','option2','option3','option4'];
            $optionIcons = ['A', 'B', 'C', 'D'];
            foreach($options as $index => $opt){
                echo "<button type='submit' name='answer' value='".($index+1)."' class='option' data-value='".($index+1)."'>
                        <span class='option-icon'>".$optionIcons[$index]."</span>
                        <span class='option-text'>".$question[$opt]."</span>
                        <span class='option-select'><i class='fas fa-hand-point-left'></i></span>
                       </button>";
            }
            ?>
        </form>
        
        <div class="prizes-container">
            <div class="prizes-title">سلم الجوائز</div>
            <div class="prizes">
                <?php 
                // عرض الجوائز من الأسفل (الأصغر) إلى الأعلى (الأكبر)
                foreach($prizes as $i => $p){
                    $level = $i + 1;
                    $active = ($level == $_SESSION['question_number']) ? 'active' : '';
                    $reached = ($level < $_SESSION['question_number']) ? 'reached' : '';
                    echo "<div class='prize $active $reached'>
                            <span class='prize-number'>$level</span>
                            <span class='prize-icon'><i class='fas fa-coins'></i></span>
                            <span class='prize-amount'>".number_format($p)."</span>
                          </div>";
                }
                ?>
            </div>
        </div>
        
        <audio id="correctSound" src="sounds/correct.mp3"></audio>
        <audio id="wrongSound" src="sounds/wrong.mp3"></audio>
        <audio id="clickSound" src="sounds/click.mp3"></audio>
    </div>
    
    <script src="script.js"></script>
</body>
</html>