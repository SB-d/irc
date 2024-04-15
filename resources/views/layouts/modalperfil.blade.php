<div class="modal fade" id="EditarPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">

                {{-- formulario --}}


                <form class="row needs-validation" {{-- action="{{ route('GuardarFoto') }}" --}} method="POST" name="form-data" class="row g-3"
                    enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="col-md-6" style="display: none;">
                        <input type="number" class="form-control" id="USU_ID" name="USU_ID"
                            value="{{ Auth::user()->id }}">
                        <div class="invalid-feedback">Completa los datos</div>
                    </div>
                    <div class="col-md-12">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                        <input type="text" class="form-control" id="staticEmail"
                            value="{{Auth::user()->email}}">
                    </div>
                    <div class="col-md-12">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                        <input type="password" class="form-control" id="inputPassword">
                    </div>
                    <div class="col-md-12">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                        <input type="password" class="form-control" id="inputPassword">
                        <br>
                    </div>

                    {{-- botones --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                        <button type="submit" class="btn btn-primary col-3">Guardar</button>
                    </div>
                    {{-- fin botones --}}


                </form>
                {{-- fin formulario --}}


            </div>
        </div>
    </div>
</div>
