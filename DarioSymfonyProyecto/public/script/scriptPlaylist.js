document.addEventListener("DOMContentLoaded", () => {

    let playAudio = document.getElementById('audioPlayer');
    let footer = document.querySelector('footer');
    let navCanciones = document.getElementById('navCanciones');
    let navPlaylist = document.getElementById('navPlaylist');


    function verPlaylist() {
        let parrafo = document.createElement('h1');
        parrafo.textContent = "Tus Playlist";
        parrafo.classList.add('tituloContenido');
        document.getElementById('contenidoPlaylist').appendChild(parrafo);


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
                    document.getElementById('contenidoPlaylist').appendChild(grupoPlaylists);

                    divPlaylist.addEventListener('click', () => {


                        document.getElementById('contenidoPlaylist').innerHTML = "";
                        document.getElementById('contenidoCanciones')?.remove(); //si es undefined, borra tambien el contenido


                        fetch(`playlist/${p.nombre}/find`)
                        .then(response => response.json())
                        .then(cancionesPlaylist => {

                                let parrafo2 = document.createElement('h1');
                                parrafo2.textContent = (`Canciones de la playlist: ${p.nombre}`);
                                parrafo2.classList.add('tituloContenido');
                                document.getElementById('contenidoPlaylist').appendChild(parrafo2);

                                for (let cancion of cancionesPlaylist) {

                                    let grupoCanciones = document.createElement('div');
                                    grupoCanciones.classList.add('canciones');

                                    let img = document.createElement('img');
                                    img.src = cancion.portada;
                                    img.classList.add('imgMusica');

                                    let divCancion = document.createElement('div');

                                    let titulo = document.createElement('p');
                                    titulo.classList.add('textoCancion');
                                    titulo.textContent = cancion.titulo;

                                    divCancion.appendChild(img);
                                    divCancion.appendChild(titulo);
                                    grupoCanciones.appendChild(divCancion);
                                    document.getElementById('contenidoPlaylist').appendChild(grupoCanciones);
                                    divCancion.addEventListener('click', () => {


                                        tituloFooter.textContent = cancion.titulo;
                                        console.log(cancion.titulo);

                                        let nombreCancion = cancion.titulo + ".mp3";
                                        let audioSrc = `/cancion/${nombreCancion}/play`; //enlazamos con el controller y nos devuelve el binario de la cancion

                                        audioPlayer.src = audioSrc; //ponemos el binario en el src del reproductor
                                        audioPlayer.style.visibility = 'visible';
                                        audioPlayer.play(); //esto hace que cuando pinches inicie la reproduccion automaticamente
                                    });
                                }
                        })
                    })
                }
            })
    }

    verPlaylist();

})