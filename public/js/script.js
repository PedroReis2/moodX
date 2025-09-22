document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.querySelector(".hamburger");
    const menu = document.getElementById("mobile-menu");

    if (hamburger && menu) {
        hamburger.addEventListener("click", function () {
            menu.classList.toggle("show");
        });
    }
});




// Admin
document.addEventListener("DOMContentLoaded", function () {

    /* === DROPDOWN MENU === */
    function toggleDropdown(button) {
        const menu = button.nextElementSibling;
        const rect = button.getBoundingClientRect();

        // Fecha outros dropdowns
        document.querySelectorAll('.dropdown-menu-custom').forEach(m => m.style.display = 'none');

        if (menu.style.display === 'block') {
            menu.style.display = 'none';
        } else {
            menu.style.display = 'block';
            menu.style.position = "fixed";

            let left = rect.right - menu.offsetWidth;
            if (left < 10) left = 10;
            if (left + menu.offsetWidth > window.innerWidth) {
                left = window.innerWidth - menu.offsetWidth - 10;
            }

            menu.style.top = rect.bottom + 4 + "px";
            menu.style.left = left + "px";
        }
    }

    document.querySelectorAll(".dropdown-trigger").forEach(trigger => {
        trigger.addEventListener("click", function (e) {
            e.stopPropagation();
            toggleDropdown(this);
        });
    });

    // Fecha dropdown ao clicar fora
    document.addEventListener("click", function (event) {
        if (!event.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu-custom').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });

    /* === MODAL DE ADIÇÃO DE UTILIZADOR === */
    const addUserModal = document.getElementById("addUserModal");
    const openModalBtn = document.getElementById("openModalBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");

    if (addUserModal && openModalBtn && closeModalBtn) {
        openModalBtn.addEventListener("click", () => addUserModal.style.display = "flex");
        closeModalBtn.addEventListener("click", () => addUserModal.style.display = "none");

        window.addEventListener("click", function (e) {
            if (e.target === addUserModal) addUserModal.style.display = "none";
        });
    }

    /* === STATUS CHECKBOX === */
    document.querySelectorAll(".status-checkbox").forEach(checkbox => {
        checkbox.title = checkbox.checked ? "Active" : "Inactive";
        checkbox.addEventListener("change", function () {
            this.title = this.checked ? "Active" : "Inactive";
        });
    });

    /* === MODAL DE CONFIRMAÇÃO DE STATUS === */
    let selectedCheckbox = null;
    const statusModal = document.getElementById("statusModal");
    const statusMessage = document.getElementById("statusModalMessage");
    const closeStatusModal = document.getElementById("closeStatusModal");
    const cancelStatusChange = document.getElementById("cancelStatusChange");
    const confirmStatusChange = document.getElementById("confirmStatusChange");

    window.openStatusModal = function (userName, element) {
        selectedCheckbox = element.closest("tr").querySelector(".status-checkbox");
        if (!selectedCheckbox) return;

        const isActive = selectedCheckbox.checked;
        statusMessage.textContent = `Do you want to change status for "${userName}" to ${isActive ? "Inactive" : "Active"}?`;
        statusModal.style.display = "flex";
    };

    if (statusModal) {
        closeStatusModal?.addEventListener("click", () => statusModal.style.display = "none");
        cancelStatusChange?.addEventListener("click", () => statusModal.style.display = "none");

        confirmStatusChange?.addEventListener("click", () => {
            if (selectedCheckbox) {
                selectedCheckbox.checked = !selectedCheckbox.checked;
                selectedCheckbox.title = selectedCheckbox.checked ? "Active" : "Inactive";
            }
            statusModal.style.display = "none";
        });

        window.addEventListener("click", function (e) {
            if (e.target === statusModal) statusModal.style.display = "none";
        });
    }

    /* === ADICIONAR NOVO UTILIZADOR === */
    const addUserButton = document.querySelector("#addUserModal button.btn-black");
    const tableBody = document.querySelector(".table tbody");

    if (addUserButton) {
        addUserButton.addEventListener("click", function () {
            const inputs = document.querySelectorAll("#addUserModal input, #addUserModal select");
            const name = inputs[0].value;
            const email = inputs[1].value;
            const role = inputs[2].value;
            const phone = inputs[3].value;

            if (!name || !email || !role || !phone) {
                alert("Please fill all fields!");
                return;
            }

            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>${name}</td>
                <td>${email}</td>
                <td>${role}</td>
                <td>${phone}</td>
                <td class="status-col">
                    <input type="checkbox" class="status-checkbox" checked>
                </td>
                <td>No</td>
                <td class="dropdown-cell">
                    <div class="dropdown">
                        <button class="dropdown-trigger">⋮</button>
                        <div class="dropdown-menu-custom">
                            <a class="dropdown-item" href="#"><span>✏️</span> Edit</a>
                            <a class="dropdown-item" href="#"><span>🔑</span> Reset Password</a>
                            <a class="dropdown-item text-danger" href="#"><span>🗑️</span> Delete User</a>
                            <a class="dropdown-item change-status" href="#" onclick="openStatusModal('${name}', this)">
                                <span>🔄</span> Change Status
                            </a>
                        </div>
                    </div>
                </td>
            `;
            tableBody.appendChild(newRow);

            // Reaplica listeners
            newRow.querySelector(".dropdown-trigger").addEventListener("click", function (e) {
                e.stopPropagation();
                toggleDropdown(this);
            });

            newRow.querySelector(".status-checkbox").addEventListener("change", function () {
                this.title = this.checked ? "Active" : "Inactive";
            });

            addUserModal.style.display = "none";
        });
    }
});
