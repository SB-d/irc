<!-- Modal -->
<div class="modal fade" id="importar_paciente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#E22A3D;">
                <h4 style="color: #fff; font-wight: bold;">Importar pacientes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('importar.pac') }}" method="POST" name="form-data"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-12">
                            <input type="file" class="form-control" id="file" name="file" required>
                            <div class="invalid-feedback">Completa los datos</div>
                            <br>
                        </div>
                        
                        <div class="col-12">
                            <input type="number" min="0" max="5000" name="rango" class="form-control" 
                            placeholder="Ingresa el numero de datos del archivo (Maximo: 5000)" required>
                            <br>
                        </div>

                        <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary col-3">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
