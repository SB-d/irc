<div class="modal fade" id="Edit_{{ $age->age_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="">
                <h6 class="modal-title">
                    Actualizar Información
                </h6>
            </div>

            <div class="modal-body">
                <form method="POST" {{-- action="{{ route('EditarTipoI', $ti->id) }}" --}}>
                    @csrf
                    @method('PUT')

                    <div class="modal-body" id="cont_modal">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="" name="" value=""
                                    required>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary col-3"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary col-3">Guardar</button>
                            </div>
                        </div>
                </form>
            </div>

        </div>
    </div>
</div>
