document.addEventListener("DOMContentLoaded", function () {
    // Labels flutuantes
    const inputs = document.querySelectorAll(".input");

    inputs.forEach((input) => {
        input.addEventListener("focus", () => {
            input.parentNode.classList.add("focused");
        });

        input.addEventListener("blur", () => {
            if (input.value === "") {
                input.parentNode.classList.remove("focused");
            }
        });
    });

    // Validação de password
    const password = document.getElementById("password");
    if (password) {
        password.addEventListener("input", () => {
            const minLength = 6;
            const hasNumber = /\d/.test(password.value);
            const hasUpper = /[A-Z]/.test(password.value);

            let message = "";
            if (password.value.length < minLength) {
                message = "A password deve ter pelo menos 6 caracteres.";
            } else if (!hasNumber) {
                message = "A password deve conter pelo menos um número.";
            } else if (!hasUpper) {
                message = "A password deve conter pelo menos uma letra maiúscula.";
            }

            let feedback = document.getElementById("password-feedback");
            if (!feedback) {
                feedback = document.createElement("small");
                feedback.id = "password-feedback";
                feedback.style.color = "red";
                password.parentNode.appendChild(feedback);
            }

            feedback.textContent = message;
        });
    }
});



// Upload de imagem de perfil
$(document).ready(function() {


    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $(".file-upload").on('change', function(){
        readURL(this);
    });

    $(".upload-button").on('click', function() {
       $(".file-upload").click();
    });
});
