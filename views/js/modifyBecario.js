document.addEventListener("DOMContentLoaded", () => {
    (function() {
        "use strict";
        let formations = document.querySelectorAll(".formation");
        let fechas = document.querySelectorAll(".fechas");

        mostrarFechas();

        function mostrarFechas() {
            for (let formation of formations) {
                let formation_id = formation.value;
                let becario_id = formation.name.split("-")[1];
                for (let fecha of fechas) {
                    if (formation_id == "1" && fecha.id == becario_id) {
                        fecha.textContent = "Inicio: 2020/02/01, fin: 2021/02/02";
                    } else if (formation_id == "2" && fecha.id == becario_id) {
                        fecha.textContent = "Inicio: 2020/07/29, fin: 2021/04/14";
                    } else if (formation_id == "3" && fecha.id == becario_id) {
                        fecha.textContent = "Inicio: 2020/05/01, fin: 2021/05/02";
                    } else if (formation_id == "4" && fecha.id == becario_id) {
                        fecha.textContent = "Inicio: 2020/03/01, fin: 2021/04/02";
                    }
                }
            }
        }

        for (let formation of formations) {
            formation.addEventListener("change", () => {
                mostrarFechas();
            });
        }
    })();
});