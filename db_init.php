<?php
try {
    $db = new PDO("sqlite:questions.db");
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

    // إدخال أسئلة تجريبية (يمكنك إضافة المزيد لاحقًا)
    $questions = [
        ["ما هي عاصمة اليمن؟", "عدن", "تعز", "صنعاء", "إب", 3],
        ["من هو مؤسس لغة PHP؟", "لارس باك", "راسموس ليردورف", "جيمس غوسلينغ", "لينوس تورفالدس", 2],
        ["أكبر قارة في العالم؟", "أفريقيا", "آسيا", "أوروبا", "أمريكا الجنوبية", 2],
        ["أكبر محيط في العالم؟", "الأطلسي", "الهندي", "الهادي", "المتجمد", 3],
        ["أول رئيس للولايات المتحدة؟", "توماس جيفرسون", "جون كينيدي", "جورج واشنطن", "أبراهام لنكولن", 3],
        ["لغة تستخدم لتصميم صفحات الويب؟", "PHP", "HTML", "Python", "Java", 2]
    ];

    $insert = $db->prepare("INSERT INTO questions (question, option1, option2, option3, option4, correct) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($questions as $q) {
        $insert->execute($q);
    }

    echo "✅ تم إنشاء قاعدة البيانات وإضافة الأسئلة بنجاح!";
} catch (PDOException $e) {
    echo "❌ خطأ: " . $e->getMessage();
}