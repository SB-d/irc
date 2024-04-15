/* SELECT DINAMICO */

    /* --variables para llamar a los select por el id */
    let $select_cliente = document.getElementById('CLI_ID')
    let $select_campana = document.getElementById('CAM_ID')

    /* CARGAR CAMPAnA */
    function cargarCampana(sendDatos) {

        $.ajax({
            url: '/select/cli',
            type: 'GET',
            dataType: 'json',
            data: sendDatos,
            success: function (response) {
                const respuestas = response.campana;

                let template = '<option class="form-control" selected disabled>-- Seleccione --</option>'

                respuestas.forEach(respuesta => {
                    template += `<option class="form-control" value="${respuesta.CAM_ID}">${respuesta.CAM_NOMBRE}</option>`;
                })

                $select_campana.innerHTML = template;
            },
            error: function (jqXHR) {
                console.log('error!');
            }
        });

    }

    $select_cliente.addEventListener('change', () => {
        const CLI_ID = $select_cliente.value

        const sendDatos = {
            'CLI_ID': CLI_ID
        }

        cargarCampana(sendDatos)

    })
