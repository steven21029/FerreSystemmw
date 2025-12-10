document.addEventListener("DOMContentLoaded", () => {

    const btnEfectivo = document.getElementById("btn-efectivo");

    if (!btnEfectivo) return;

    btnEfectivo.addEventListener("click", function (e) {
        e.preventDefault();

        let confirmar = confirm("¿Desea finalizar esta compra y pagar en efectivo?");

        if (confirmar) {
            window.location.href = "?controller=cart&action=store";
        } else {
            alert("Compra cancelada.");
        }
    });

});