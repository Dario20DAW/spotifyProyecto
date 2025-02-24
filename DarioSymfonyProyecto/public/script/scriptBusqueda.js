let barraBusqueda = document.getElementById('campoBuscar');


fetch('/cancion/mostrarCanciones')
    .then(response => response.json())
    .then(datosCancion => {
        let canciones = datosCancion;

        

    })

