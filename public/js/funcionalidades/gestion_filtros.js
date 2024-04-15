$(document).ready(function () {

    /* SEARCH DOCUMENT */
    $(".select-pro-ges").on("input", function () {

        const documento = $('#serch_paciente_procesos').val();
        const dep_id = $('#departamento_select').val();
        const pro_id = $('#proceso_select').val();
        const id_user = document.getElementById('sidebar_id_user').value;
        var listado = $("[name=procesos_gestion]");

        listado.empty();
        listado.append(
            '<tr><td colspan="8" >Buscando...</td></tr>'
        );

        data = {
            "documento": documento,
            "dep_id": dep_id,
            "pro_id": pro_id
        }

        $.ajax({
            url: '/get/gestiones/doc/',
            type: 'GET',
            dataType: 'json',
            data: data,
            /* beforeSend: function () {
                console.log('enviada');
            },
            complete: function () {
                console.log('completada');
            }, */
            success: function (response) {
                var data = response;
                listado.empty();
                if (data.length < 1) {
                    listado.append(
                        '<tr><td colspan="8">No se encontraron registros</td></tr>'
                    );
                } else {

                    for (var i = 0; i < data.length; i++) {
                        var item = data[i];

                        if (item['pro_prioridad'] == 1) {
                            c_style = "fa-solid fa-circle circle-red";
                        } else if (item['pro_prioridad'] == 2) {
                            c_style = "fa-solid fa-circle circle-yellow";
                        } else if (item['pro_prioridad'] == 3) {
                            c_style = "fa-solid fa-circle circle-green";
                        }

                        if (item['pro_gestionado'] == 1) {
                            check = "checked";
                        } else {
                            check = "";
                        }

                        listado.append(
                            '<tr>' +
                            '<td style="padding-top: 20px;">' +
                            '<div class="custom-control custom-switch">' +
                            '<input type="checkbox" class="custom-control-input" id="marcador_' + item['pro_id'] + '" onchange="marca_gestion(' + item['pro_id'] + ', ' + id_user + ')" ' + check + '>' +
                            '<label class="custom-control-label" for="marcador_' + item['pro_id'] + '" style=""></label>' +
                            '<input type="text" style="display: none" name="" id="" value="' + item['pro_gestionado'] + '">' +
                            '</div>' +
                            '</td>' +
                            '<td>' +
                            '<span style="display: none;">' + item['pro_prioridad'] + '</span>' +
                            '<i class="' + c_style + '"></i>' +
                            '</td>' +
                            '<td>' + item['pac_identificacion'] + '</td>' +
                            '<td>' + item['pac_primer_nombre'] + ' ' + item['pac_segundo_nombre'] + ' ' + item['pac_primer_apellido'] + ' ' + item['pac_segundo_apellido'] + '</td>' +
                            '<td>' + item['pac_telefono'] + '</td>' +
                            '<td>' + item['tpp_nombre'] + '</td>' +
                            '<td>' + item['dep_nombre'] + '</td>' +
                            '<td>' +
                            '<div class="d-flex align-items-center">' +
                            '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_proceso" onclick="modal_proceso(' + item['pac_id'] + ');">Proceso</button>' +
                            '<button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#modal_perfil" onclick="modal_perfil(' + item['pac_id'] + ');">Perfil</button>' +
                            '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_gestion" onclick="modal_gestion(' + item['pro_id'] + ', ' + item['tpp_id'] + ', ' + item['pac_id'] + ');">Gestion</button>' +
                            '</div>' +
                            '</td>' +
                            '</tr>'
                        );

                    }
                }

            },
            error: function (jqXHR) {
                console.log('error!');
            }
        });



    });


    /* ENVIO DE LA GESTION */
    $("#enviar_gestion").on("click", function () {

        // Obtener todos los campos requeridos
        var requiredFields = document.querySelectorAll('[required]');
        var hasInvalidFields = false;

        requiredFields.forEach(function (field) {
            // Obtener el h6 más cercano a nuestro campo
            var h6 = field.closest('div').previousElementSibling;

            // Limpiamos la clase de error previamente para no acumularla
            if (h6) h6.classList.remove('label-error');

            if (field.tagName === "SELECT" && (field.value === "" || field.value === null)) {
                if (h6) h6.classList.add('label-error');
                hasInvalidFields = true;
            } else if ((field.tagName === "INPUT" || field.tagName === "TEXTAREA") && field.value.trim() === "") {
                field.classList.add('is-invalid');
                hasInvalidFields = true;
            }
        });


        if (!hasInvalidFields) {

            var data = {
                "tpp_id": document.querySelector("[name='tpp_id']").value,
                "pro_id": document.querySelector("[name='pro_id']").value,
                "pac_id": document.querySelector("[name='pac_id']").value,
                "usu_id": document.querySelector("[name='usu_id']").value,
                "tge_id": document.querySelector("[name='tge_id']").value,
                "tpa_id": document.querySelector("[name='tpa_id']").value,
                "tpr_id": document.querySelector("[name='tpr_id']").value,
                /* "fecha_cita": document.querySelector("[name='fecha_cita']").value, */
                "motivo_inasistencia": document.querySelector("[name='motivo_inasistencia']").value,
                "tin_id": document.querySelector("[name='tin_id']").value,
                "ges_comentario": document.querySelector("[name='ges_comentario']").value
            };

            $.ajax({
                url: '/gestionar/modal/gestion/post',
                type: 'get',
                dataType: 'json',
                data: data,
                /* beforeSend: function () {
                    console.log('enviada');
                },
                complete: function () {
                    console.log('completada');
                }, */
                success: function (response) {

                    $('#modal_gestion').modal('hide');

                    document.querySelector("[name='tpp_id']").value = '';
                    document.querySelector("[name='pro_id']").value = '';
                    document.querySelector("[name='pac_id']").value = '';
                    document.querySelector("[name='tge_id']").selectedIndex = 0;
                    document.querySelector("[name='tpa_id']").selectedIndex = 0;
                    document.querySelector("[name='tpr_id']").selectedIndex = 0;
                    document.querySelector("[name='motivo_inasistencia']").selectedIndex = 0;
                    document.querySelector("[name='tin_id']").selectedIndex = 0;
                    document.querySelector("[name='ges_comentario']").value = '';
                    $("[name='ges_comentario']").removeClass('is-invalid');

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Gestion guardada'
                    })
                },
                error: function (jqXHR) {
                    console.log('error!');
                }
            });

        } else {
            Swal.fire(
                'Atencion',
                'Campos sin llenar!',
                'warning'
            )
        }




    });



});
