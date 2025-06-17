document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const nomeInput = document.getElementById("nome");
    const emailInput = document.getElementById("email");
    const telefoneInput = document.getElementById("telefone");

    // Impede que números sejam digitados no campo nome
    nomeInput.addEventListener("keypress", function (e) {
        if (/\d/.test(e.key)) {
            e.preventDefault();
        }
    });

    // Máscara para telefone: (99) 99999-9999
    telefoneInput.addEventListener("input", function (e) {
        let value = e.target.value.replace(/\D/g, ""); // Remove tudo que não for número

        if (value.length > 11) {
            value = value.slice(0, 11);
        }

        if (value.length <= 10) {
            value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, "($1) $2-$3");
        } else {
            value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, "($1) $2-$3");
        }

        e.target.value = value;
    });

    // Validação de email no envio
    form.addEventListener("submit", function (e) {
        const email = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert("Por favor, insira um email válido.");
        }
    });
});
