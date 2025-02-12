
document.addEventListener("DOMContentLoaded", () => {

let playAudio = document.getElementById('audioPlayer');
let footer = document.querySelector('footer');
let navCanciones = document.getElementById('navCanciones');
let navPlaylist = document.getElementById('navPlaylist');


function verCanciones(){
    let parrafo2 = document.createElement('h1');
    parrafo2.textContent = "Tus Canciones";
    parrafo2.classList.add('tituloContenido');
    document.getElementById('contenidoCanciones').appendChild(parrafo2);


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
            document.getElementById('contenidoCanciones').appendChild(grupoCanciones);

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
}


verCanciones();


})