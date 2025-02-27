document.addEventListener("DOMContentLoaded", () => {

    let footer = document.getElementById('footer');
    let tituloFooter = document.getElementById('tituloFooter');
    let autorFooter = document.getElementById('autorFooter');
    let audioPlayer = document.getElementById('audioPlayer');
    let barraBusqueda = document.getElementById('campoBuscar');



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



    function verPlaylist() {
        let parrafoAdmin = document.createElement('h1');
        parrafoAdmin.textContent = "Playlist del sistema";
        parrafoAdmin.classList.add('tituloContenido');
        let parrafoUser = document.createElement('h1');
        parrafoUser.textContent = "Tus Playlist";
        parrafoUser.classList.add('tituloContenido');
        document.getElementById('contenidoPlaylist').appendChild(parrafoAdmin);
        


        fetch('/playlist/mostrarPlaylist')
            .then(response => response.json())
            .then(datosPlaylist => {
                let playlists = datosPlaylist;
                let grupoPlaylistAdmin = document.createElement('div');
                grupoPlaylistAdmin.classList.add('playlists');
                let grupoPlaylistUsuario = document.createElement('div');
                grupoPlaylistUsuario.classList.add('playlists');

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

                    /*En las siguientes lineas, se compara el rol del propietario de la playlist, caso de ser rol admin, 
                    las añade al div de listas predeterminadas, en caso de ser rol user las añade al div de playlist de ese usuario
                    luego verificamos si el usuario logueado es propietario de alguna de las playlist, en caso de ser asi
                    se le mostrarian, si no, solo le saldrian las playlist por defecto*/ 


                    if (p.rolPropietario == "ROLE_ADMIN") {

                        grupoPlaylistAdmin.appendChild(divPlaylist);
                        document.getElementById('contenidoPlaylist').appendChild(grupoPlaylistAdmin);
                        console.log(p.rolPropietario);
                    }
                    else if (p.rolPropietario == "ROLE_USER") {
                        fetch('/getSession')
                            .then(response => response.json())
                            .then(data => {

                                if (data) {
                                    console.log("detecta el mail del primer fetch " + data.email);
                                    fetch(`/usuario/mostrarId/${data.email}`)
                                        .then(response => response.json())
                                        .then(data2 => {
                                            if (data2.id == p.propietario) {
                                                document.getElementById('contenidoPlaylistUsuario').appendChild(parrafoUser);
                                                grupoPlaylistUsuario.appendChild(divPlaylist);
                                                document.getElementById('contenidoPlaylistUsuario').appendChild(grupoPlaylistUsuario);
                                                console.log("si el id coincide con alguna playlist, la muestra");
                                            }
                                            else{
                                                console.log("este usuario no es propietario de niguna playlist");
                                            }
                                        })
                                }
                            })
                    }



                    barraBusqueda.addEventListener('input', () => {
                        if ((p.nombre.toLowerCase().includes(barraBusqueda.value.toLowerCase()))) {
                            divPlaylist.style.display = "block";
                        }
                        else {
                            divPlaylist.style.display = "none";
                        }
                    })


                    divPlaylist.addEventListener('click', () => {


                        document.getElementById('contenidoPlaylist').innerHTML = "";
                        document.getElementById('contenidoPlaylistUsuario').innerHTML = "";
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

                                    barraBusqueda.addEventListener('input', () => {
                                        if ((cancion.titulo.toLowerCase().includes(barraBusqueda.value.toLowerCase()))) {
                                            divCancion.style.display = "block";
                                        }
                                        else {
                                            divCancion.style.display = "none";
                                        }
                                    })

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