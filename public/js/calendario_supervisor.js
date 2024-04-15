window.onload = function () {

    /* CALENDARIO */

    var id_empleado = $("#agente_info").find("[name=id_empleado]").val();

    data = {
        'id_empleado': id_empleado
    }

    $.ajax({
        url: '/supervisor/calendario/agente',
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
            data = response.evento;
            var calendarE1 = document.getElementById('calendario_supervisor_agente');
            var calendar = new FullCalendar.Calendar(calendarE1, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                locales: 'es',
                events: data
            });
            calendar.render();

        },
        error: function (jqXHR) {
            console.log('error!');
        }
    });

    /* SELECT DINAMICO */

    /* --variables para llamar a los select por el id */
    let $select_cliente = document.getElementById('CLI_ID')
    let $select_campana = document.getElementById('CAM_ID')

    /* CARGAR CAMPAÑA */
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





}
