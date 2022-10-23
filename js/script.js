/*
    Encierro todo en una función asíncrona para poder usar async y await cómodamente
*/
(async () => {
    // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
    const respuestaRaw = await fetch("./dataChart.php");

    // Decodificar como JSON
    const respuesta = await respuestaRaw.json();
    // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"

    // Obtener una referencia al elemento canvas del DOM
    const $grafica = document.querySelector("#grafica");
    const etiquetas = respuesta.etiquetas; // <- Aquí estamos pasando el valor traído usando AJAX

    // Podemos tener varios conjuntos de datos. Comencemos con uno
    const datos = {
        label: "Promedio",
        // Pasar los datos igualmente desde PHP
        data: respuesta.datos, // <- Aquí estamos pasando el valor traído usando AJAX
        backgroundColor: 'rgba(255, 99, 132, 0.2)', // Color de fondo
        borderColor: 'rgba(255, 99, 132, 1)', // Color del borde
        borderWidth: 1, // Ancho del borde
    };

    new Chart($grafica, {
        type: 'line', // Tipo de gráfica
        data: {
            labels: etiquetas,
            datasets: [
                datos,
                // Aquí más datos...
            ]
        },
        options: {}
    });
})();
