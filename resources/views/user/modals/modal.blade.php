 <!-- Modal 1 -->
<div class="modal fade1" dir="rtl" id="{{$modal_id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="{{$modal_id}}Label" aria-hidden="false">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" dir="rtl">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <h1 class="modal-title fs-5" id="{{$modal_id}}Label">{{$modal_title}}</h1>
        </div>
        @includeIf('user.modals.layout.'.$modal_body, isset($modal_parameters) ? $modal_parameters : '')

    </div>
    </div>
</div>
<!-- End Modal 1 -->
