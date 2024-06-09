<div class="modal fade" id="exampleLargeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 1rem 2rem;">
                <h5 class="modal-title" style="font-size: 1.5rem;">{{__('menu.modal')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">{{__('menu.modalload')}}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('menu.modalclose')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 1rem 2rem;">
                <h5 class="modal-title">Удаление</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Вы действительно хотите удалить?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btndel" v="0" data-bs-dismiss="modal">{{__('menu.modalclose')}}</button>
                <button type="button" class="btn btn-primary btndel" v="1">Удалить</button>
            </div>
        </div>
    </div>
</div>



