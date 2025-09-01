<div class="modal-body" >
    <div class="w-100">
        <div class="">

            <div class="text-center w-100">
                <div class="w-100 text-center fw-bold">المطلوب</div>
                <div class="text-center">
                    <span id="currency" class="" style="font-family: 'saudi_riyal'">&#xE900;</span>
                    <span class="grandtotal text-main" style="font-weight: 700;font-size:5.5rem">0.00</span>
                </div>
            </div>
            <div class="w-100 px-1" >
                <div class="d-flex p-0 " dir="" >
                    <label class="btn btn-lg p-4 w-50 btn-primary rounded-start-0 border-end payment_method pcard" for="pcard" >
                        شبكة
                        <input type="radio" style="display: none" onclick="payment_method(this);toggleCash(0)" value="CARD" class="pay_type" name="payment_method" id="pcard">
                    </label>
                    <label class="btn btn-lg p-4 w-50 active rounded-end-0 border-start payment_method pcash" for="pcash" >
                        كاش
                        <input type="radio" style="display: none" onclick="payment_method(this);toggleCash(1)" value="CASH" class="pay_type" name="payment_method" id="pcash">
                    </label>
                </div>
                <div class="d-flex p-0 my-2 " dir="" >
                    <label class="btn btn-lg p-4 w-50 active rounded-start-0 border-end dinein" for="dinein" >
                        محلي
                        <input type="radio" style="display: none" onclick="handleRadioClick(this)" value="DINE_IN" class="order_type" name="order_type" id="dinein">
                    </label>
                    <label class="btn btn-lg p-4 w-50 btn-primary rounded-end-0 border-start dineout" for="dineout" >
                        سفري
                        <input type="radio" style="display: none" onclick="handleRadioClick(this)" value="DINE_OUT" class="order_type" name="order_type" id="dineout">
                    </label>
                </div>

                {{--<div class="d-flex p-0 " dir="" >
                    <input type="radio" style="display: none" onclick="handleRadioClick(this)" value="DINE_IN" class="order_type" name="order_type" id="dinein">
                    <input type="radio" style="display: none" onclick="handleRadioClick(this)" value="DINE_OUT" class="order_type" name="order_type" id="dineout">
                    <div class="d-flex p-0 justify-content-end" >
                        <label class="btn active rounded-end-0 border-start dinein" for="dinein" >محلي</label>
                        <label class="btn btn-primary rounded-start-0 border-end dineout" for="dineout" >سفري</label>
                    </div>
                </div>--}}

            </div>
        </div>
        <section class="cash_section d-none">

            <div class="w-100 text-center fw-bold mt-3">المستلم كاش</div>
            <div class="cash_calculator d-flex w-100 justify-content-center my-2">
                <div  data-amount="50" class="cash_given btn btn-outline-dark text-center m-1">
                    <span id="currency" class="" style="font-family: 'saudi_riyal'">&#xE900;</span>
                    <span class="" style="font-weight: 700;">50.00</span>
                </div>
                <div  data-amount="100" class="cash_given btn btn-outline-dark text-center m-1">
                    <span id="currency" class="" style="font-family: 'saudi_riyal'">&#xE900;</span>
                    <span class="" style="font-weight: 700;">100.00</span>
                </div>
                <div  data-amount="200" class="cash_given btn btn-outline-dark text-center m-1">
                    <span id="currency" class="" style="font-family: 'saudi_riyal'">&#xE900;</span>
                    <span class="" style="font-weight: 700;">200.00</span>
                </div>
                <div  data-amount="500" class="cash_given btn btn-outline-dark text-center m-1">
                    <span id="currency" class="" style="font-family: 'saudi_riyal'">&#xE900;</span>
                    <span class="" style="font-weight: 700;">500.00</span>
                </div>
            </div>
            <div class="w-100 text-center fw-bold">الباقي كاش</div>
            <div class="text-center w-100">
                {{-- <div class="w-100 text-center fw-bold">المطلوب</div> --}}
                <div class="text-center">
                    <span id="currency" class="" style="font-family: 'saudi_riyal'">&#xE900;</span>
                    <span class="cash_change text-main" style="font-weight: 700;font-size:5.5rem">0.00</span>
                </div>
            </div>
        </section>
    </div>

</div>
<div class="modal-footer p-0" style="overflow: hidden">
    {{-- ON CLICK DISABLE THIS BUTTON FROM JS TO PREVENT DUBLICATE ORDER PLACEMNET!! --}}

    <button  id="place-order-btn"  class="btn w-100 py-4 btn-lg m-0 rounded-0 btn-primary" ><span>حفظ وطباعة</span>  <div class="place_order_spinner d-none spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
    </div></button>

</div>
