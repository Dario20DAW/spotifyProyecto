

let navSeparado = document.getElementById('navSeparado')


document.addEventListener('DOMContentLoaded', () => {


    fetch('/getSession')
        .then(response => response.json()) // Convertimos la respuesta a JSON
        .then(data => {

            if (data.email != null) {
                fetch(`/usuario/mostrarRol/${data.email}`)
                    .then(response => response.json()) // Convertimos la respuesta a JSON
                    .then(data2 => {

                        if (data2.rol == "ROLE_USER") {


                            let crearPlalistEnlace = document.getElementById('crearPlaylist');
                            crearPlalistEnlace.style.display = "";

                            console.log("ROL USER", data.email);

                        } else {
                            console.log("ROL ADMIN o ROL MANAGER");
                        }
                    })
                    .catch(error => console.error("Error al obtener la sesión:", error))

                let loginEnlace = document.getElementById('eLogin');
                let registroEnlace = document.getElementById('eRegistro');
                let logoutEnlace = document.getElementById('eLogout');

                loginEnlace.style.display = "none";
                registroEnlace.style.display = "none";
                logoutEnlace.style.display = "";

            }
        })

})

