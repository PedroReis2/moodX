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

    if (statusModal) {
        // Fechar (X) e Cancel
        closeStatusModal?.addEventListener("click", () => statusModal.style.display = "none");
        cancelStatusChange?.addEventListener("click", () => statusModal.style.display = "none");

        // Confirmar mudança
        confirmStatusChange?.addEventListener("click", () => {
            if (selectedCheckbox) {
                selectedCheckbox.checked = !selectedCheckbox.checked;
                selectedCheckbox.title = selectedCheckbox.checked ? "Active" : "Inactive";
            }
            statusModal.style.display = "none";
        });

        // Fecha ao clicar fora do conteúdo
        window.addEventListener("click", function (e) {
            if (e.target === statusModal) statusModal.style.display = "none";
        });
    }

    /* Adicionar Novo Utilizador na Tabela */
    const addUserButton = document.querySelector("#addUserModal button.btn-black");
    const tableBody     = document.querySelector(".table tbody");

    if (addUserButton && tableBody) {
        addUserButton.addEventListener("click", function () {
            // Lê valores do formulário
            const inputs = document.querySelectorAll("#addUserModal input, #addUserModal select");
            const name  = inputs[0].value;
            const email = inputs[1].value;
            const role  = inputs[2].value;
            const phone = inputs[3].value;

            // Validação simples
            if (!name || !email || !role || !phone) {
                alert("Please fill all fields!");
                return;
            }

            // Nova linha
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

            // Reaplica eventos da nova linha
            newRow.querySelector(".dropdown-trigger").addEventListener("click", function (e) {
                e.stopPropagation();
                toggleDropdown(this);
            });

            const newCheckbox = newRow.querySelector(".status-checkbox");
            newCheckbox.title = "Active";
            newCheckbox.addEventListener("change", function () {
                this.title = this.checked ? "Active" : "Inactive";
            });

            // Fecha modal
            addUserModal.style.display = "none";

            // Reaplica filtro de pesquisa (se houver texto no search)
            if (searchInput && searchInput.value.trim() !== "") {
                filterRows();
            }
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
