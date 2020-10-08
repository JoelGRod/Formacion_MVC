document.addEventListener("DOMContentLoaded", () => {

    (function() {
        'use strict';
        let formation = document.getElementById('formation');
        let fechas = document.querySelectorAll(".fechas");

        mostrarFechas();

        function mostrarFechas() {
            for (let fecha of fechas) {
                if (formation.value == "1") {
                    fecha.textContent = "Inicio: 2020/02/01, fin: 2021/02/02";
                } else if (formation.value == "2") {
                    fecha.textContent = "Inicio: 2020/07/29, fin: 2021/04/14";
                } else if (formation.value == "3") {
                    fecha.textContent = "Inicio: 2020/05/01, fin: 2021/05/02";
                } else if (formation.value == "4") {
                    fecha.textContent = "Inicio: 2020/03/01, fin: 2021/04/02";
                }
            }
        }

        formation.addEventListener("change", () => {
            mostrarFechas();
        });
    })();

})