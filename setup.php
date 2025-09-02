<?php
// setup.php
try {
    // إنشاء الاتصال بقاعدة البيانات (ملف SQLite)
    $db = new PDO('sqlite:questions.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // إنشاء جدول الأسئلة
    $db->exec("CREATE TABLE IF NOT EXISTS questions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        question TEXT NOT NULL,
        option1 TEXT NOT NULL,
        option2 TEXT NOT NULL,
        option3 TEXT NOT NULL,
        option4 TEXT NOT NULL,
        correct INTEGER NOT NULL
    )");

    // إدخال أسئلة تجريبية
    $insert = $db->prepare("INSERT INTO questions (question, option1, option2, option3, option4, correct) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    
    $insert->execute(["ما هي عاصمة اليمن؟", "عدن", "تعز", "صنعاء", "إب", 3]);
    $insert->execute(["من هو مؤسس لغة PHP؟", "لارس باك", "راسموس ليردورف", "جيمس غوسلينغ", "لينوس تورفالدس", 2]);
    $insert->execute(["كم عدد قارات العالم؟", "5", "6", "7", "8", 3]);
    $insert->execute(["أكبر محيط في العالم هو؟", "الأطلسي", "الهندي", "الهادي", "المتجمد", 3]);

    echo "✅ تم إنشاء الجدول وإضافة الأسئلة بنجاح!";
} catch (PDOException $e) {
    echo "❌ خطأ: " . $e->getMessage();
}
?>