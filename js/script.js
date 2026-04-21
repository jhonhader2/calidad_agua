/*
    Se carga la información y se dibuja la gráfica con await de nivel superior.
*/
try {
    const respuestaRaw = await fetch("./dataChart.php");
    const respuesta = await respuestaRaw.json();

    const $grafica = document.querySelector("#grafica");
    const etiquetas = respuesta.etiquetas;

    const datos = {
        label: "Promedio",
        data: respuesta.datos,
        backgroundColor: "rgba(255, 99, 132, 0.2)",
        borderColor: "rgba(255, 99, 132, 1)",
        borderWidth: 1,
    };

    new Chart($grafica, {
        type: "line",
        data: {
            labels: etiquetas,
            datasets: [datos]
        },
        options: {}
    });
} catch (error) {
    console.error("No se pudo cargar la gráfica:", error);
}
