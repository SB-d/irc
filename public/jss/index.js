document.querySelectorAll('.tablinks');

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// OPCIONES
// const cards = document.querySelectorAll('.card');
// cards.forEach((button) => { // Cambié 'buttons' a 'button' para mejor claridad
//     button.addEventListener('click', () => {
//         window.location.href = 'detalles.html'
//     });
// });

const prevencion = document.querySelector('#prevencion');
prevencion.addEventListener('click', () => {
    window.location.href = "detalles"
})

 // Función para abrir y cerrar el contenedor de cambio de contraseña
document.querySelector('.icon-logout').addEventListener('click', function() {
    var container = document.querySelector('.changePass-logout');
    var icon = document.querySelector('.icon-logout');
    if (!container.classList.contains('open')) {
        container.classList.add('open');
        icon.classList.add('rotate');
    } else {
        container.classList.remove('open');
        icon.classList.remove('rotate');
    }
});



