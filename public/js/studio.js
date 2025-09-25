let isResizing = false; // flag global para saber se estamos a redimensionar um elemento

/* Dropdowns */
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const allDropdowns = document.querySelectorAll('.studio-dropdown, .dropdown-assets');

    // fecha todos os outros dropdowns antes de abrir o clicado
    allDropdowns.forEach(el => {
        if (el !== dropdown) el.style.display = 'none';
    });

    // alterna visibilidade do dropdown clicado
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

// fecha dropdowns ao clicar fora
document.addEventListener('click', function (event) {
    const isInside = event.target.closest('.studio-btn-wrapper');
    if (!isInside) {
        document.querySelectorAll('.studio-dropdown, .dropdown-assets').forEach(el => el.style.display = 'none');
    }
});

/* Notas */
let noteMode = false; // flag para saber se estamos no modo de criar nota
const noteBtn = document.getElementById('noteModeBtn');
const studioArea = document.querySelector('.creative-studio-wrapper');

// alterna o modo notas ao clicar no botão
noteBtn.addEventListener('click', () => {
    noteMode = !noteMode;
    noteBtn.classList.toggle('active', noteMode);
});

// cria uma nova nota na posição do clique
studioArea.addEventListener('click', function (e) {
    if (!noteMode) return;
    createNote(e.clientX, e.clientY);
    noteMode = false; // desliga o modo notas após criar
    noteBtn.classList.remove('active');
});

// função que cria a estrutura da nota
function createNote(x, y) {
    const note = document.createElement('div');
    note.classList.add('note');
    note.style.left = `${x}px`;
    note.style.top = `${y}px`;

    // estrutura inicial com textarea
    note.innerHTML = `
        <textarea placeholder="Leave a note..."></textarea>
        <div class="note-actions">
            <button class="note-btn save-note">OK</button>
            <button class="note-btn delete-note">Delete</button>
        </div>
    `;

    // guardar nota
    note.querySelector('.save-note').addEventListener('click', () => {
        const text = note.querySelector('textarea').value.trim();
        if (text === "") return;
        note.innerHTML = `
            <div class="note-text">${text}</div>
            <div class="note-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
            </div>
        `;
        note.querySelector('.edit-btn').addEventListener('click', () => editNote(note, text));
        note.querySelector('.delete-btn').addEventListener('click', () => note.remove());
        makeDraggable(note); // permite arrastar depois de criada
    });

    // apagar nota
    note.querySelector('.delete-note').addEventListener('click', () => note.remove());

    studioArea.appendChild(note);
    makeDraggable(note);
}

// função para editar uma nota existente
function editNote(note, oldText) {
    note.innerHTML = `
        <textarea>${oldText}</textarea>
        <div class="note-actions">
            <button class="note-btn save-note">OK</button>
            <button class="note-btn delete-note">Delete</button>
        </div>
    `;

    // guardar alterações
    note.querySelector('.save-note').addEventListener('click', () => {
        const newText = note.querySelector('textarea').value.trim();
        if (newText === "") return;
        note.innerHTML = `
            <div class="note-text">${newText}</div>
            <div class="note-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
            </div>
        `;
        note.querySelector('.edit-btn').addEventListener('click', () => editNote(note, newText));
        note.querySelector('.delete-btn').addEventListener('click', () => note.remove());
        makeDraggable(note);
    });

    // apagar nota
    note.querySelector('.delete-note').addEventListener('click', () => note.remove());
}

/* Drag and Drop (arrrastar elementos) */
function makeDraggable(el) {
    let isDragging = false;
    let offsetX, offsetY;

    el.addEventListener('mousedown', (e) => {
        // não arrasta se clicar no handle de resize
        if (e.target.classList.contains('chat-resize-handle')) return;

        if (!isResizing) {
            isDragging = true;
            offsetX = e.offsetX;
            offsetY = e.offsetY;
            el.style.cursor = 'grabbing';
        }
    });

    window.addEventListener('mousemove', (e) => {
        if (isDragging && !isResizing) {
            el.style.left = `${e.clientX - offsetX}px`;
            el.style.top = `${e.clientY - offsetY}px`;
        }
    });

    window.addEventListener('mouseup', () => {
        isDragging = false;
        el.style.cursor = 'grab';
    });
}

/* Caixa de prompts para a IA */
function createImageChat(x, y) {
    const chat = document.createElement('div');
    chat.classList.add('image-chat');
    chat.style.left = `${x}px`;
    chat.style.top = `${y}px`;

    chat.innerHTML = `
        <button class="chat-close-btn">&times;</button>
        <div class="chat-content">
            <textarea class="chat-textarea" placeholder="Describe your concept..."></textarea>
            <div class="chat-actions">
                <button class="chat-generate-btn">Generate</button>
            </div>
        </div>
        <div class="chat-resize-handle"></div>
    `;

    // fechar chat
    chat.querySelector('.chat-close-btn').addEventListener('click', () => chat.remove());

   // gerar imagem (simulado por enquanto)
chat.querySelector('.chat-generate-btn').addEventListener('click', () => {
    const prompt = chat.querySelector('textarea').value.trim();
    if (!prompt) return;

    // Aqui vamos chamar o backend.
    // Por agora usamos uma imagem placeholder
    const fakeImage = "https://placehold.co/600x400?text=" + encodeURIComponent(prompt);
    showImageModal(fakeImage);
});

    document.querySelector('.creative-studio-wrapper').appendChild(chat);
    makeDraggable(chat);
    makeResizable(chat);
}

/* Redimensionar o chat de IA */
function makeResizable(el) {
    const handle = el.querySelector('.chat-resize-handle');
    let startX, startY, startWidth, startHeight;

    handle.addEventListener('mousedown', (e) => {
        e.preventDefault();
        e.stopPropagation();
        isResizing = true;

        startX = e.clientX;
        startY = e.clientY;
        const rect = el.getBoundingClientRect();
        startWidth = rect.width;
        startHeight = rect.height;

        document.body.style.userSelect = 'none'; // desativa seleção de texto
    });

    window.addEventListener('mousemove', (e) => {
        if (!isResizing) return;

        // calcula novo tamanho
        const newWidth = startWidth + (e.clientX - startX);
        const newHeight = startHeight + (e.clientY - startY);

        el.style.width = `${Math.max(220, newWidth)}px`;
        el.style.height = `${Math.max(150, newHeight)}px`;
    });

    window.addEventListener('mouseup', () => {
        if (isResizing) {
            isResizing = false;
            document.body.style.userSelect = '';
        }
    });
}



/* Gestão de imagens geradas */

// Array para guardar imagens geradas temporariamente
let generatedImages = [];

/* Abre o modal de pré-visualização com a imagem gerada */
function showImageModal(url) {
    // coloca o URL da imagem no <img> do modal
    document.getElementById('generatedImagePreview').src = url;
    // mostra o modal removendo a classe hidden
    document.getElementById('generatedImageModal').classList.remove('hidden');
}

/* Fecha o modal de pré-visualização */
function closeImageModal() {
    document.getElementById('generatedImageModal').classList.add('hidden');
}

/* Guarda a imagem no Studio e adiciona-a à lista temporária*/
function saveImageToStudio() {
    const imgSrc = document.getElementById('generatedImagePreview').src;

    // adiciona a imagem ao array temporário
    generatedImages.push(imgSrc);

    // feedback ao utilizador
    alert("Image saved to Studio! Total: " + generatedImages.length);

    // fecha o modal
    closeImageModal();

    // cria um "bloco" visual no Studio para mostrar que a imagem foi guardada
    const block = document.createElement('div');
    block.classList.add('project-card'); // podes trocar por outra classe se quiseres
    block.innerHTML = `<img src="${imgSrc}" class="project-image" alt="Generated">`;

    // adiciona o bloco no fim do wrapper principal
    document.querySelector('.creative-studio-wrapper').appendChild(block);
}


/* Ações dos botões do Modal */

/*Ação para criar novo Sketchbook */
function createNewSketchbook() {
    const imgSrc = document.getElementById('generatedImagePreview').src;
    alert("Novo Sketchbook criado com esta imagem: " + imgSrc);
    closeImageModal();
}

/* Ação para adicionar imagem a um Sketchbook já existente */
function openSketchbookList() {
    const imgSrc = document.getElementById('generatedImagePreview').src;
    alert("Seleciona um Sketchbook existente para adicionar a imagem: " + imgSrc);
    closeImageModal();
}


/*Para adicionar ao sketchbook*/
function createNewSketchbook() {
    const imgSrc = document.getElementById('generatedImagePreview').src;
    document.getElementById('previewNewSketchbookImage').src = imgSrc;
    openModal('modalCreateSketchbook');
}

function openSketchbookList() {
    const imgSrc = document.getElementById('generatedImagePreview').src;
    document.getElementById('previewExistingSketchbookImage').src = imgSrc;

    // TODO: carregar sketchbooks do utilizador via AJAX (Laravel route)
    const select = document.getElementById('sketchbookSelect');
    select.innerHTML = `
        <option value="">Select...</option>
        <option value="1">Sketchbook 1</option>
        <option value="2">Sketchbook 2</option>
    `;

    openModal('modalAddToSketchbook');
}

function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function saveNewSketchbook() {
    const title = document.getElementById('newSketchbookName').value;
    const desc = document.getElementById('newSketchbookDesc').value;
    const imgDesc = document.getElementById('newImageDesc').value;

    console.log("Saving new sketchbook:", { title, desc, imgDesc });

    // Aqui podes fazer fetch POST para Laravel
    closeModal('modalCreateSketchbook');
}

function saveToExistingSketchbook() {
    const selected = document.getElementById('sketchbookSelect').value;
    const imgDesc = document.getElementById('existingImageDesc').value;

    console.log("Adding to sketchbook:", { selected, imgDesc });

    // Aqui podes fazer fetch POST para Laravel
    closeModal('modalAddToSketchbook');
}

