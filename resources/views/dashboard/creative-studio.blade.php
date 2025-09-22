@extends('layout.fe_dashboard_master')

@section('title', 'My Creative Studio — mood.x')

@section('content')
<div class="creative-studio-wrapper">

    {{-- TEXTOS --}}
    <div class="studio-header">
        <p class="studio-subtitle">Start with one fabric, and build your vision.</p>
        <p class="studio-subtitle">Your moodboard starts here</p>
    </div>

    {{-- TOOLBAR CENTRAL --}}
    <div class="studio-toolbar">

        {{-- BOTÃO + COM DROPDOWN --}}
        <div class="studio-btn-wrapper">
            <button class="studio-btn" type="button" onclick="toggleDropdown('dropdown-add')">
                <img src="{{ asset('images/icons/addblock_icon.png') }}" alt="Add">
            </button>

            <div class="studio-dropdown" id="dropdown-add">
                <p class="dropdown-title">Add Block</p>
                <div class="dropdown-item">
                    <img src="{{ asset('images/icons/text_icon.png') }}" alt="Text">
                    <span>Text</span>
                </div>
                <div class="dropdown-item">
                    <img src="{{ asset('images/icons/image_icon.png') }}" alt="Image">
                    <span>Image</span>
                </div>
                <div class="dropdown-item">
                    <img src="{{ asset('images/icons/video_icon.png') }}" alt="Video">
                    <span>Video</span>
                </div>
                <div class="dropdown-item">
                    <img src="{{ asset('images/icons/upload_icon.png') }}" alt="Upload">
                    <span>Upload</span>
                </div>
            </div>
        </div>

        {{-- BOTÃO ASSETS --}}
        <div class="studio-btn-wrapper">
            <button class="studio-btn" type="button" onclick="toggleDropdown('dropdown-assets')">
                <img src="{{ asset('images/icons/searchassets_icon.png') }}" alt="Assets">
            </button>

            <div class="dropdown-assets" id="dropdown-assets">
                <div class="search-bar">
                    <img src="{{ asset('images/icons/search_icon.png') }}" alt="Search">
                    <input type="text" placeholder="Search Assets..." />
                </div>
                <label for="assetUpload" class="upload-box">
                    + Upload
                </label>
                <input type="file" id="assetUpload" style="display: none" />
            </div>
        </div>

        {{-- BOTÃO HISTORY COM DROPDOWN --}}
        <div class="studio-btn-wrapper">
            <button class="studio-btn" type="button" onclick="toggleDropdown('dropdown-history')">
                <img src="{{ asset('images/icons/searchhistory_icon.png') }}" alt="History">
            </button>

            <div class="studio-dropdown history-dropdown" id="dropdown-history">
                <div class="search-bar">
                    <img src="{{ asset('images/icons/search_icon.png') }}" alt="Search">
                    <input type="text" placeholder="Search History..." />
                </div>
                {{-- Aqui podes carregar as entradas do histórico dinamicamente no futuro --}}
            </div>
        </div>

       {{-- BOTÃO NOTES --}}
<div class="studio-btn-wrapper">
    <button class="studio-btn" id="noteModeBtn">
        <img src="{{ asset('images/icons/notes_icon.png') }}" alt="Notes">
    </button>
</div>

        {{-- BOTÃO HELP COM DROPDOWN --}}
        <div class="studio-btn-wrapper">
            <button class="studio-btn" type="button" onclick="toggleDropdown('dropdown-help')">
                <img src="{{ asset('images/icons/help_icon.png') }}" alt="Help">
            </button>

            <div class="studio-dropdown help-dropdown" id="dropdown-help">
                <div class="dropdown-item">
                    <img src="{{ asset('images/icons/help_resources_icon.png') }}" alt="Help">
                    <span>Help & Resources</span>
                </div>
                <div class="dropdown-item">
                    <img src="{{ asset('images/icons/bug_icon.png') }}" alt="Bug">
                    <span>Report a bug</span>
                </div>
                <div class="dropdown-item">
                    <img src="{{ asset('images/icons/suggest_icon.png') }}" alt="Feature">
                    <span>Suggest a feature</span>
                </div>

                <hr class="dropdown-divider">

                {{-- Redes Sociais --}}
                <div class="social-icons">
                    <a href="https://www.instagram.com/modatex.pt/" target="_blank">
                        <img src="{{ asset('images/icons/instagram_icon.png') }}" alt="Instagram">
                    </a>
                    <a href="https://www.youtube.com/c/modatexpt" target="_blank">
                        <img src="{{ asset('images/icons/youtube_icon.png') }}" alt="YouTube">
                    </a>
                    <a href="https://www.facebook.com/modatex.portugal/" target="_blank">
                        <img src="{{ asset('images/icons/facebook_icon.png') }}" alt="Facebook">
                    </a>
                    <a href="https://www.linkedin.com/school/modatexportugal/?originalSubdomain=pt" target="_blank">
                        <img src="{{ asset('images/icons/linkedin_icon.png') }}" alt="LinkedIn">
                    </a>
                </div>

                <hr class="dropdown-divider">

                <div class="dropdown-footer">
                    <small>mood.x v1.0.0<br>Last Updated set 01, 2025</small>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        const allDropdowns = document.querySelectorAll('.studio-dropdown, .dropdown-assets');

        allDropdowns.forEach(el => {
            if (el !== dropdown) el.style.display = 'none';
        });

        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function (event) {
        const isInside = event.target.closest('.studio-btn-wrapper');
        if (!isInside) {
            document.querySelectorAll('.studio-dropdown, .dropdown-assets').forEach(el => {
                el.style.display = 'none';
            });
        }
    });



    let noteMode = false;
    const noteBtn = document.getElementById('noteModeBtn');
    const studioArea = document.querySelector('.creative-studio-wrapper');

    noteBtn.addEventListener('click', () => {
        noteMode = !noteMode;
        noteBtn.classList.toggle('active', noteMode);
    });

    studioArea.addEventListener('click', function (e) {
        // Garante que só cria nota quando em modo ativo
        if (!noteMode) return;

        // Cria a nota apenas uma vez
        createNote(e.clientX, e.clientY);
        noteMode = false;
        noteBtn.classList.remove('active');
    });

    function createNote(x, y) {
        const note = document.createElement('div');
        note.classList.add('note');
        note.style.left = `${x}px`;
        note.style.top = `${y}px`;

        note.innerHTML = `
            <textarea placeholder="Leave a note..."></textarea>
            <div class="note-actions">
                <button class="note-btn save-note">OK</button>
                <button class="note-btn delete-note">Delete</button>
            </div>
        `;

        // Guardar a nota
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

            makeDraggable(note);
        });

        // Apagar a nota
        note.querySelector('.delete-note').addEventListener('click', () => {
            note.remove();
        });

        studioArea.appendChild(note);
        makeDraggable(note);
    }

    function editNote(note, oldText) {
        note.innerHTML = `
            <textarea>${oldText}</textarea>
            <div class="note-actions">
                <button class="note-btn save-note">OK</button>
                <button class="note-btn delete-note">Delete</button>
            </div>
        `;

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

        note.querySelector('.delete-note').addEventListener('click', () => note.remove());
    }

    function makeDraggable(el) {
        let isDragging = false;
        let offsetX, offsetY;

        el.addEventListener('mousedown', (e) => {
            isDragging = true;
            offsetX = e.offsetX;
            offsetY = e.offsetY;
            el.style.cursor = 'grabbing';
        });

        window.addEventListener('mousemove', (e) => {
            if (isDragging) {
                el.style.left = `${e.clientX - offsetX}px`;
                el.style.top = `${e.clientY - offsetY}px`;
            }
        });

        window.addEventListener('mouseup', () => {
            isDragging = false;
            el.style.cursor = 'grab';
        });
    }


</script>
@endpush
