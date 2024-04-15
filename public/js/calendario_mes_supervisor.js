window.onload = function () {

    /* CALENDARIO */
    var calendarE1 = document.getElementById('calendario_mes_supervisor');
    var calendar = new FullCalendar.Calendar(calendarE1, {
        initialView: 'dayGridMonth',
        locales: 'es',
        
    });
    calendar.render();

}
