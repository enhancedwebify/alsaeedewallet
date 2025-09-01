    <div class="modal-body">
    {{-- Important for updates --}}
    <div class="mb-3">
        <label for="" class="form-label fw-bold">اسم العميل</label>
        <input type="text" id="customer_name" name="customer_name" class="form-control form-control-lg my-1" >
    </div>

    <div class="mb-3">
        <label for="" class="form-label fw-bold">الرقم الضريبي للعميل</label>
        <input type="text" id="customer_vat_id" name="customer_vat_id" class="form-control form-control-lg my-1" >
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
    <button type="submit" id="saveCustomerInfo" data-bs-dismiss="modal" class="btn btn-primary">حفظ</button>
</div>
