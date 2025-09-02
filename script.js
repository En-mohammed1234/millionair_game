document.addEventListener('DOMContentLoaded', function(){
    let timer = 15;
    const timerEl = document.getElementById("timer-text");
    const timerProgress = document.getElementById("timer-progress");
    const options = document.querySelectorAll(".option");
    const correctSound = document.getElementById("correctSound");
    const wrongSound = document.getElementById("wrongSound");
    const clickSound = document.getElementById("clickSound");
    const form = document.getElementById("options-form");
    let answered = false;
    
    // بدء المؤقت
    const countdown = setInterval(() => {
        timer--;
        timerEl.textContent = timer;
        
        // تحديث شريط التقدم
        const progressPercent = (timer / 15) * 100;
        timerProgress.style.width = `${progressPercent}%`;
        
        // تغيير اللون عندما يقل الوقت
        if(timer <= 5) {
            timerEl.style.color = '#ff4444';
            timerProgress.style.background = '#ff4444';
        }
        
        // انتهاء الوقت
        if(timer <= 0){
            clearInterval(countdown);
            if (!answered) {
                wrongSound.play();
                setTimeout(() => {
                    window.location.href = "result.php";
                }, 1000);
            }
        }
    }, 1000);
    
    // إضافة التفاعل للأزرار
    options.forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (answered) return;
            answered = true;
            
            e.preventDefault();
            clearInterval(countdown); // إيقاف المؤقت عند النقر
            
            // تشغيل صوت النقر
            clickSound.play();
            
            // إضافة تأثير النقر
            btn.classList.add('selected');
            
            // تعطيل جميع الأزرار بعد الاختيار
            options.forEach(option => {
                option.disabled = true;
            });
            
            // الحصول على قيمة الإجابة
            const answerValue = btn.getAttribute('data-value');
            
            // إضافة حقل مخفي للنموذج يحتوي على الإجابة
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'answer';
            hiddenInput.value = answerValue;
            form.appendChild(hiddenInput);
            
            // الانتقال إلى السؤال التالي بعد تأخير قصير
            setTimeout(() => {
                form.submit();
            }, 1500);
        });
    });
});