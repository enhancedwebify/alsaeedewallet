<div class="modal-body">
    @foreach($printers as $printer)
        <div class="fw-bold form-control my-2">
            <div class="printerName">
                <div class="text-main ps-3"><span id="{{$printer->name}}-status"></span> اسم الطابعة</div>
                <div class="my-3">{{$printer->description}}</div>
            </div>
            <div class="printerIdentifier">
                <div class="text-main ps-3"><span id="{{$printer->name}}-status"></span> معرف الطابعة في النظام</div>
                <div class="my-3">{{$printer->printer_identifier}}</div>
            </div>
        </div>
    @endforeach
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
</div>
