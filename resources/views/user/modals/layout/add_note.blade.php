<div class="mb-3">
    <input type="text" name="" id="noteField" class="form-control form-control-lg rounded-0 border-0" style="font-size: 3rem">
</div>
<div class="modal-body p-0" >
    <div class="keyboard-container">
        <div class="keyboard keyboard-alpha active">
            <div class="keyboard-row">
                <button class="key" data-char="1" >1</button>
                <button class="key" data-char="2" >2</button>
                <button class="key" data-char="3" >3</button>
                <button class="key" data-char="4" >4</button>
                <button class="key" data-char="5" >5</button>
                <button class="key" data-char="6" >6</button>
                <button class="key" data-char="7" >7</button>
                <button class="key" data-char="8" >8</button>
                <button class="key" data-char="9" >9</button>
                <button class="key" data-char="0" >0</button>
            </div>
            <div class="keyboard-row">
                <button class="key" data-char="ض" >ض</button>
                <button class="key" data-char="ص" >ص</button>
                <button class="key" data-char="ث" >ث</button>
                <button class="key" data-char="ق" >ق</button>
                <button class="key" data-char="ف" >ف</button>
                <button class="key" data-char="غ" >غ</button>
                <button class="key" data-char="ع" >ع</button>
                <button class="key" data-char="ه" >ه</button>
                <button class="key" data-char="خ" >خ</button>
                <button class="key" data-char="ح" >ح</button>
                <button class="key" data-char="ج" >ج</button>

            </div>
            <div class="keyboard-row">
                <button class="key" data-char="ش" >ش</button>
                <button class="key" data-char="س" >س</button>
                <button class="key" data-char="ي" >ي</button>
                <button class="key" data-char="ب" >ب</button>
                <button class="key" data-char="ل" >ل</button>
                <button class="key" data-char="ا" >ا</button>
                <button class="key" data-char="ت" >ت</button>
                <button class="key" data-char="ن" >ن</button>
                <button class="key" data-char="م" >م</button>
                <button class="key" data-char="ك" >ك</button>
                <button class="key" data-char="ط" >ط</button>
            </div>
            <div class="keyboard-row">

                <button class="key" data-char="ذ" >ذ</button>
                <button class="key" data-char="ء" >ء</button>
                <button class="key" data-char="ئ" >ئ</button>
                <button class="key" data-char="ؤ" >ؤ</button>
                <button class="key" data-char="ر" >ر</button>
                <button class="key" data-char="ى" >ى</button>
                <button class="key" data-char="ة" >ة</button>
                <button class="key" data-char="و" >و</button>
                <button class="key" data-char="ز" >ز</button>
                <button class="key" data-char="ظ" >ظ</button>
                <button class="key" data-char="د" >د</button>
                <button class="key backspace" data-action="backspace"><i class="bi bi-backspace-reverse"></i></button> </div>
            <div class="keyboard-row">
                <button class="key num-sym-toggle" hidden disabled>123</button>
                <button class="key shift" data-action="clear">مسح الكل</button>
                <button class="key space" data-action="space">مسافة</button>
                <button class="key enter" data-action="enter" data-bs-dismiss="modal" id="saveNote" onclick="var note = document.getElementById('noteField').value;app.order_note(note);app.customer_info(0,note);document.getElementById('billNote').innerText=note;">حفظ</button>
            </div>
        </div>

        <div class="keyboard keyboard-num">
            <div class="keyboard-row">
                <button class="key">1</button>
                <button class="key">2</button>
                <button class="key">3</button>
            </div>
            <div class="keyboard-row">
                <button class="key">4</button>
                <button class="key">5</button>
                <button class="key">6</button>
            </div>
            <div class="keyboard-row">
                <button class="key">7</button>
                <button class="key">8</button>
                <button class="key">9</button>
            </div>
            <div class="keyboard-row">
                <button class="key alpha-toggle">أ ب ت</button> <button class="key">.</button>
                <button class="key">0</button>
                <button class="key backspace px-2">مسح</button> </div>
        </div>
    </div>
</div>
{{-- <div class="modal-footer"> --}}
{{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button> --}}
{{-- <button type="submit" id="save_note" data-bs-dismiss="modal" class="btn btn-primary" >حفظ</button> --}}
{{-- </div> --}}
