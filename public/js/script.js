// Aguarda o DOM estar pronto (parte do menu mobile)
document.addEventListener("DOMContentLoaded", function () {
    /*  MENU HAMBÚRGUER (MOBILE) */
    const hamburger = document.querySelector(".hamburger");
    const menu = document.getElementById("mobile-menu");

    if (hamburger && menu) {
        // Abre/fecha o menu ao clicar no hambúrguer
        hamburger.addEventListener("click", function (e) {
            e.stopPropagation(); // evita fechar imediatamente
            menu.classList.toggle("show");
        });

        // Fecha o menu ao clicar fora
        document.addEventListener("click", function (e) {
            if (!e.target.closest(".mobile-menu") && !e.target.closest(".hamburger")) {
                menu.classList.remove("show");
            }
        });
    }
});

// Script principal do Admin
document.addEventListener("DOMContentLoaded", function () {

    /* Dropdown de Ações (⋮) */
    function toggleDropdown(button) {
        const menu = button.nextElementSibling; // dropdown deste botão
        const rect = button.getBoundingClientRect();

        // Fecha outros dropdowns abertos
        document.querySelectorAll('.dropdown-menu-custom').forEach(m => m.style.display = 'none');

        if (menu.style.display === 'block') {
            menu.style.display = 'none';
        } else {
            menu.style.display = 'block';
            menu.style.position = "fixed";

            // Posicionamento à direita do botão, ajustando às bordas da janela
            let left = rect.right - menu.offsetWidth;
            if (left < 10) left = 10;
            if (left + menu.offsetWidth > window.innerWidth) {
                left = window.innerWidth - menu.offsetWidth - 10;
            }

            menu.style.top = rect.bottom + 4 + "px";
            menu.style.left = left + "px";
        }
    }

    // Liga o clique aos botões ⋮
    document.querySelectorAll(".dropdown-trigger").forEach(trigger => {
        trigger.addEventListener("click", function (e) {
            e.stopPropagation();
            toggleDropdown(this);
        });
    });

    // Fecha dropdowns ao clicar fora
    document.addEventListener("click", function (event) {
        if (!event.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu-custom').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });

    /* Modal: Adicionar Utilizador */
    const addUserModal = document.getElementById("addUserModal");
    const openModalBtn  = document.getElementById("openModalBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");

    if (addUserModal && openModalBtn && closeModalBtn) {
        // Abre modal
        openModalBtn.addEventListener("click", () => addUserModal.style.display = "flex");
        // Fecha modal (X)
        closeModalBtn.addEventListener("click", () => addUserModal.style.display = "none");
        // Fecha ao clicar fora do conteúdo
        window.addEventListener("click", function (e) {
            if (e.target === addUserModal) addUserModal.style.display = "none";
        });
    }

    /* Modal: Actualizar Utilizador */
    const updateUserModal = document.getElementById("updateUserModal");
    const closeModalBtnUpdate = document.getElementById("closeModalBtnUpdate");

    if (updateUserModal && closeModalBtnUpdate) {
        // Fecha modal (X)
        closeModalBtnUpdate.addEventListener("click", () => updateUserModal.style.display = "none");
        // Fecha ao clicar fora do conteúdo
        window.addEventListener("click", function (e) {
            if (e.target === updateUserModal) updateUserModal.style.display = "none";
        });
    }

    // Edit user functionality
    document.querySelectorAll('.edit-user-btn').forEach(function(btn) {
        btn.addEventListener("click", function(e) {
            e.preventDefault();

            const userId = this.dataset.userId;
            const username = this.dataset.username;
            const firstname = this.dataset.firstname;
            const lastname = this.dataset.lastname;
            const email = this.dataset.email;
            const role = this.dataset.role;

            document.getElementById('update_user_id').value = userId;
            document.getElementById('update_username').value = username;
            document.getElementById('update_first_name').value = firstname;
            document.getElementById('update_last_name').value = lastname;
            document.getElementById('update_email').value = email;
            document.getElementById('update_role').value = role;

            updateUserModal.style.display = "flex";
        });
    });

    /* Checkbox de status (tooltip) */
    document.querySelectorAll(".status-checkbox").forEach(checkbox => {
        checkbox.title = checkbox.checked ? "Active" : "Inactive";
        checkbox.addEventListener("change", function () {
            this.title = this.checked ? "Active" : "Inactive";
        });
    });

    /* Modal: Confirmar mudança de status */
    let selectedCheckbox = null;
    const statusModal         = document.getElementById("statusModal");
    const statusMessage       = document.getElementById("statusModalMessage");
    const closeStatusModal    = document.getElementById("closeStatusModal");
    const cancelStatusChange  = document.getElementById("cancelStatusChange");
    const confirmStatusChange = document.getElementById("confirmStatusChange");

    // Função global chamada pelo link "Change Status"
    window.openStatusModal = function (userName, element) {
        selectedCheckbox = element.closest("tr").querySelector(".status-checkbox");
        if (!selectedCheckbox) return;

        const isActive = selectedCheckbox.checked;
        statusMessage.textContent = `Do you want to change status for "${userName}" to ${isActive ? "Inactive" : "Active"}?`;
        statusModal.style.display = "flex";
    };

    // Status change functionality with data attributes
    document.querySelectorAll('.change-status-btn').forEach(function(btn) {
        btn.addEventListener("click", function(e) {
            e.preventDefault();

            const userId = this.dataset.userId;
            const username = this.dataset.username;
            const currentStatus = this.dataset.currentStatus;
            const newStatus = currentStatus === 'active' ? 'inactive' : 'active';

            statusMessage.textContent = `Do you want to change status for "${username}" to ${newStatus}?`;
            statusModal.style.display = "flex";

            // Store the user ID for later use
            statusModal.dataset.userId = userId;
        });
    });

    if (statusModal) {
        // Fechar (X) e Cancel
        closeStatusModal?.addEventListener("click", () => statusModal.style.display = "none");
        cancelStatusChange?.addEventListener("click", () => statusModal.style.display = "none");

        // Confirmar mudança
        confirmStatusChange?.addEventListener("click", () => {
            const userId = statusModal.dataset.userId;
            if (userId) {
                // Submit form or make AJAX request to change status
                window.location.href = `/admin/users/${userId}/toggle-status`;
            }
            statusModal.style.display = "none";
        });

        // Fecha ao clicar fora do conteúdo
        window.addEventListener("click", function (e) {
            if (e.target === statusModal) statusModal.style.display = "none";
        });
    }

    /* Modal: Confirmar Eliminacao de user */
    const deleteModal = document.getElementById("deleteModal");
    const closeDeleteModal = document.getElementById("closeDeleteModal");
    const cancelDelete = document.getElementById("cancelDelete");
    const confirmDelete = document.getElementById("confirmDelete");
    const deleteModalMessage = document.getElementById("deleteModalMessage");

    // Delete user functionality
    document.querySelectorAll('.delete-user-btn').forEach(function(btn) {
        btn.addEventListener("click", function(e) {
            e.preventDefault();

            const userId = this.dataset.userId;
            const username = this.dataset.username;

            deleteModalMessage.textContent = `Are you sure you want to delete ${username}? This action cannot be undone.`;
            deleteModal.style.display = "flex";

            // Store the user ID for later use
            deleteModal.dataset.userId = userId;
        });
    });

    if (deleteModal) {
        // Fechar (X) e Cancel
        closeDeleteModal?.addEventListener("click", () => deleteModal.style.display = "none");
        cancelDelete?.addEventListener("click", () => deleteModal.style.display = "none");

        // Confirmar delete
        confirmDelete?.addEventListener("click", () => {
            const userId = deleteModal.dataset.userId;
            if (userId) {
                // Submit form or make AJAX request to delete user
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${userId}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
            deleteModal.style.display = "none";
        });

        // Fecha ao clicar fora do conteúdo
        window.addEventListener("click", function (e) {
            if (e.target === deleteModal) deleteModal.style.display = "none";
        });
    }

    /*  PESQUISA NA TABELA */
    const searchInput = document.querySelector(".admin-search");
    const table       = document.querySelector(".table");
    const tbody       = table?.querySelector("tbody");
    const NO_RESULTS_ROW_ID = "no-results-row";

    // Normaliza string - minusculas e sem acentos
    function norm(str) {
        return (str || "")
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, ""); // remove acentos
    }

    function ensureNoResultsRow() {
        if (!document.getElementById(NO_RESULTS_ROW_ID)) {
            const tr = document.createElement("tr");
            tr.id = NO_RESULTS_ROW_ID;
            const td = document.createElement("td");
            td.colSpan = 7;
            td.style.textAlign = "center";
            td.style.color = "#666";
            td.style.padding = "16px";
            td.textContent = "No results";
            tr.appendChild(td);
            return tr;
        }
        return document.getElementById(NO_RESULTS_ROW_ID);
    }

    function removeNoResultsRow() {
        const row = document.getElementById(NO_RESULTS_ROW_ID);
        if (row) row.remove();
    }

    function filterRows() {
        if (!tbody) return;
        const q = norm(searchInput.value.trim());
        let matches = 0;

        removeNoResultsRow();

        Array.from(tbody.querySelectorAll("tr")).forEach(tr => {
            const cells = tr.querySelectorAll("td");
            const hay = [
                cells[0]?.textContent,
                cells[1]?.textContent,
                cells[2]?.textContent,
                cells[3]?.textContent
            ].map(norm).join(" ");

            const show = q === "" || hay.includes(q);
            tr.style.display = show ? "" : "none";
            if (show) matches++;
        });

        if (matches === 0) {
            const row = ensureNoResultsRow();
            tbody.appendChild(row);
        }
    }

    if (searchInput) {
        searchInput.addEventListener("input", filterRows);
    }
});
