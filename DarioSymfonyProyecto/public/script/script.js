let playAudio = document.getElementById('audioPlayer');
let footer = document.querySelector('footer');
let navCanciones = document.getElementById('navCanciones');
let navPlaylist = document.getElementById('navPlaylist');


navCanciones.addEventListener('click', function(e){
    e.preventDefault(); //cuando pulsemos la pagina no hace la interaccion de recargar
    document.getElementById('contenidoPrincipal').innerHTML = "";


    let parrafo = document.createElement('h1');
    parrafo.textContent = "Tus Canciones";
    parrafo.classList.add('tituloContenidoPrincipal');
    document.getElementById('contenidoPrincipal').appendChild(parrafo);


    fetch('/cancion/mostrarCanciones')
    .then(response => response.json())
    .then(datosCancion => {
        let canciones = datosCancion;
        let footer = document.getElementById('footer'); 
        let tituloFooter = document.getElementById('tituloFooter');
        let autorFooter = document.getElementById('autorFooter');
        let audioPlayer = document.getElementById('audioPlayer');
        let grupoCanciones = document.createElement('div');
        grupoCanciones.classList.add('canciones');
    
    
        if (!tituloFooter) {
            tituloFooter = document.createElement('p');
            tituloFooter.id = 'tituloFooter';
            tituloFooter.classList.add('textoCancion');
            footer.appendChild(tituloFooter);
        }

        if (!autorFooter) {
            autorFooter = document.createElement('p');
            autorFooter.id = 'autorFooter';
            autorFooter.classList.add('textoCancion');
            footer.appendChild(autorFooter);
        }
    

        for (let cancion of canciones) {
            let img = document.createElement('img');
            img.src = './imagenes/cover.png';
            img.classList.add('imgMusica');

            let divCancion = document.createElement('div');

            let titulo = document.createElement('p');
            titulo.classList.add('textoCancion');
            titulo.textContent = cancion.titulo;

            divCancion.appendChild(img);
            divCancion.appendChild(titulo);
            grupoCanciones.appendChild(divCancion);
            document.getElementById('contenidoPrincipal').appendChild(grupoCanciones);

            divCancion.addEventListener('click', () => {
                tituloFooter.textContent = cancion.titulo;
                autorFooter.textContent = cancion.autor;

                let nombreCancion = cancion.titulo + ".mp3"; 
                let audioSrc = `/cancion/${nombreCancion}/play`; //enlazamos con el controller y nos devuelve el binario de la cancion

                audioPlayer.src = audioSrc; //ponemos el binario en el src del reproductor
                audioPlayer.style.visibility = 'visible';
                audioPlayer.play(); //esto hace que cuando pinches inicie la reproduccion automaticamente
            });
        }
    })
})



navPlaylist.addEventListener('click', function(e){
    e.preventDefault(); //cuando pulsemos la pagina no hace la interaccion de recargar
    document.getElementById('contenidoPrincipal').innerHTML = "";


    let parrafo = document.createElement('h1');
    parrafo.textContent = "Tus Playlist";
    parrafo.classList.add('tituloContenidoPrincipal');
    document.getElementById('contenidoPrincipal').appendChild(parrafo);


    fetch('/playlist/mostrarPlaylist')
    .then(response => response.json())
    .then(datosPlaylist => {
        let playlists = datosPlaylist;
        let grupoPlaylists = document.createElement('div');
        grupoPlaylists.classList.add('playlists');

        for (let p of playlists) {
            let img = document.createElement('img');
            img.src = './imagenes/coverPlaylist.png';
            img.classList.add('imgMusica');

            let divPlaylist = document.createElement('div');

            let nombrePlaylist = document.createElement('p');
            nombrePlaylist.classList.add('textoCancion');
            nombrePlaylist.textContent = p.nombre;

            divPlaylist.appendChild(img);
            divPlaylist.appendChild(nombrePlaylist);
            grupoPlaylists.appendChild(divPlaylist);
            document.getElementById('contenidoPrincipal').appendChild(grupoPlaylists);

        }
    })
})
