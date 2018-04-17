<div class="modal fade" id="modalconfirmar" tabindex="-1" role="dialog" aria-labelledby="ModalConfDeleteArea" aria-hidden="true">
    <div class="modal-dialog modal-sm" id="document" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitle"></h5>
            </div>
            <div class="modal-body">
                <!-- formulario -->
                <form id="formconfirmar" method="POST" action="{{route('areas.destroy')}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <div class="form-group edit-content">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;OK</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Cancelar</button>
                    </div>
                </form>
                <!-- fin formulario -->
            </div>
        </div>
    </div>
</div>

