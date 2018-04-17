<div class="modal fade" id="modalcambiar" tabindex="-1" role="dialog" aria-labelledby="ModelApplyAction" aria-hidden="true">
    <div class="modal-dialog modal-sm" id="document" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModelApplyAction"></h5>
            </div>
            <div class="modal-body">
                <!-- formulario -->
                <form id="formcambiar" method="POST" action="{{route('approbation.update')}}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group modal-body edit-content">
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