
/* EVENTO DEL SEARCH */
search.oninput = function() {

    var listado = $("[name=registros]");
    listado.empty();
    listado.append(
        '<tr><td colspan="7" >Buscando...</td></tr>'
    );

    data = {
        'busqueda': search.value
    }

    $.ajax({
        url: '/proceso/tabla',
        type: 'GET',
        dataType: 'json',
        data: data,
        beforeSend: function () {
            console.log('enviada');
        },
        complete: function () {
            console.log('completada');
        },
        success: function (response) {
            console.log(response);
            var resp = response;
            var data = resp.data;
            listado.empty();
            if (data.length < 1 || resp.success == false) {
                listado.append(
                    '<tr><td colspan="7">No se encontraron registros</td></tr>'
                );
            } else {

                for (var i = 0; i < data.length; i++) {

                    var item = data[i];

                    if(item['car_activo'] == 'SI'){
                        var input_check = '<input type="checkbox" class="custom-control-input" id="estado_'+ item['car_id'] +'" onchange="cambio('+ item['car_id'] +')" checked>';
                    }else{
                        var input_check = '<input type="checkbox" class="custom-control-input" id="estado_'+ item['car_id'] +'" onchange="cambio('+ item['car_id'] +')">';
                    }

                    switch (item['tpp_id']) {
                        case 1:
                            var boton_excel = '<a class="btn btn-primary" href="/proceso/e/ina/'+ item['car_id'] +'"><i class="far fa-eye"></i></a>';
                            break;
                        case 2:
                            var boton_excel = '<a class="btn btn-primary" href="/proceso/e/seg/'+ item['car_id'] +'"><i class="far fa-eye"></i></a>';
                            break;
                        case 3:
                            var boton_excel = '<a class="btn btn-primary" href="/proceso/e/rec/'+ item['car_id'] +'"><i class="far fa-eye"></i></a>';
                            break;
                        case 4:
                            var boton_excel = '<a class="btn btn-primary" href="/proceso/e/hos/'+ item['car_id'] +'"><i class="far fa-eye"></i></a>';
                            break;
                        case 5:
                            var boton_excel = '<a class="btn btn-primary" href="/proceso/e/bri/'+ item['car_id'] +'"><i class="far fa-eye"></i></a>';
                            break;
                        case 6:
                            var boton_excel = '<a class="btn btn-primary" href="/proceso/e/rep/'+ item['car_id'] +'"><i class="far fa-eye"></i></a>';
                            break;
                        case 7:
                            var boton_excel = '<a class="btn btn-primary" href="/proceso/e/cap/'+ item['car_id'] +'"><i class="far fa-eye"></i></a>';
                            break;

                        default:
                            
                            break;
                    }
                    
                    console.log(item['tpp_id'])
                    
                    listado.append(
                        '<tr>' +
                        '<td>' + item['car_fecha_cargue'] + '</td>' +
                        '<td>' + item['car_mes'] + '</td>' +
                        '<td>' + item['car_fecha_reporte'] + '</td>' +
                        '<td>' + item['tpp_nombre'] + '</td>' +
                        '<td style="padding-top: 20px;">' +
                            '<div class="custom-control custom-switch">' +
                                 input_check +
                                '<label class="custom-control-label" for="estado_'+ item['car_id'] +'" style=""></label>' +
                                '<input type="text" style="display: none" name="" id="" value="'+ item['car_id'] +'">' +
                            '</div>' +
                        '</td>' +
                        '<td>' +
                             boton_excel +
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



};
