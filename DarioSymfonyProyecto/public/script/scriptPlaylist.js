document.addEventListener("DOMContentLoaded", () => {

    let playAudio = document.getElementById('audioPlayer');
    let footer = document.querySelector('footer');
    let navCanciones = document.getElementById('navCanciones');
    let navPlaylist = document.getElementById('navPlaylist');
    
    
    function verPlaylist(){
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
    
            }
        })
    }

    verPlaylist();
})