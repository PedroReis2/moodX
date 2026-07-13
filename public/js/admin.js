

function openAddUserModal() {
    const modal = document.getElementById("addUserModal");
    modal.classList.add("show");
    modal.style.display = "block";
    modal.removeAttribute("aria-hidden");
    modal.setAttribute("aria-modal", "true");

    // cria o fundo escuro (backdrop)
    const backdrop = document.createElement("div");
    backdrop.className = "modal-backdrop fade show";
    backdrop.id = "customBackdrop";
    document.body.appendChild(backdrop);
}

function closeModal() {
    const modal = document.getElementById("addUserModal");
    modal.classList.remove("show");
    modal.style.display = "none";
    modal.setAttribute("aria-hidden", "true");
    modal.removeAttribute("aria-modal");

    // remove o fundo escuro (backdrop)
    const backdrop = document.getElementById("customBackdrop");
    if (backdrop) backdrop.remove();
}

document.addEventListener("DOMContentLoaded", () => {
    alert("JS ativo");
    console.log("JS carregado e a funcionar");
});
