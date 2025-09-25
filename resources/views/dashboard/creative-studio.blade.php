@extends('layout.fe_dashboard_master')

@section('title', 'My Creative Studio — mood.x')

@section('content')
<div class="creative-studio-wrapper">

    {{-- TEXTOS INICIAIS--}}
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
               <div class="dropdown-item" onclick="createImageChat(420, 180)">
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
                {{-- Aqui pode-se carregar as entradas do histórico dinamicamente no futuro --}}
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
               <a href="/under-construction" class="dropdown-item">
                    <img src="{{ asset('images/icons/help_resources_icon.png') }}" alt="Help">
                    <span>Help & Resources</span>
                </a>

                <a href="/under-construction" class="dropdown-item">
                    <img src="{{ asset('images/icons/bug_icon.png') }}" alt="Bug">
                    <span>Report a bug</span>
                </a>

                <a href="/under-construction" class="dropdown-item">
                    <img src="{{ asset('images/icons/suggest_icon.png') }}" alt="Feature">
                    <span>Suggest a feature</span>
                </a>

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
<!-- MODAL DE PRÉ-VISUALIZAÇÃO DA IMAGEM GERADA -->
<div id="generatedImageModal" class="modal hidden">
    <div class="modal-content">
        <!-- Botão para fechar -->
        <span class="modal-close" onclick="closeImageModal()">&times;</span>

        <div class="modal-inner">
            <!-- Lado esquerdo: imagem -->
            <div class="modal-image-section">
                <img id="generatedImagePreview" src="" alt="Generated Image">
            </div>

            <!-- Lado direito: título, descrição e botões -->
            <div class="modal-details">
                <h3 class="modal-title">Generated Image</h3>
                <p class="description-text">You can save this image to your Studio project.</p>

                <!-- Botões lado a lado -->
                <div class="save-buttons">
                    <button class="chat-generate-btn" onclick="createNewSketchbook()">
                        Create New Sketchbook
                    </button>
                    <button class="chat-generate-btn secondary" onclick="openSketchbookList()">
                        Add to Existing Sketchbook
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: CREATE NEW SKETCHBOOK -->
<div id="modalCreateSketchbook" class="modal hidden">
    <div class="modal-content small">
        <span class="modal-close" onclick="closeModal('modalCreateSketchbook')">&times;</span>

        <h2 class="modal-form-title">Create New Sketchbook</h2>

        <div class="modal-form-body">
            <!-- Nome do Sketchbook -->
            <label for="newSketchbookName">Sketchbook Title</label>
            <input type="text" id="newSketchbookName" placeholder="Enter sketchbook title">

            <!-- Descrição do Sketchbook -->
            <label for="newSketchbookDesc">Sketchbook Description</label>
            <textarea id="newSketchbookDesc" placeholder="Describe this sketchbook"></textarea>

            <!-- Pré-visualização da imagem -->
            <div class="modal-image-preview">
                <img id="previewNewSketchbookImage" src="" alt="Generated Image">
            </div>

            <!-- Descrição da imagem -->
            <label for="newImageDesc">Image Description</label>
            <textarea id="newImageDesc" placeholder="Describe this image"></textarea>

            <!-- Botão Guardar -->
            <button class="chat-generate-btn" onclick="saveNewSketchbook()">Save Sketchbook</button>
        </div>
    </div>
</div>

<!-- MODAL: ADD TO EXISTING SKETCHBOOK -->
<div id="modalAddToSketchbook" class="modal hidden">
    <div class="modal-content small">
        <span class="modal-close" onclick="closeModal('modalAddToSketchbook')">&times;</span>

        <h2 class="modal-form-title">Add to Existing Sketchbook</h2>

        <div class="modal-form-body">
            <!-- Pré-visualização da imagem -->
            <div class="modal-image-preview">
                <img id="previewExistingSketchbookImage" src="" alt="Generated Image">
            </div>

            <!-- Descrição da imagem -->
            <label for="existingImageDesc">Image Description</label>
            <textarea id="existingImageDesc" placeholder="Describe this image"></textarea>

            <!-- Lista de Sketchbooks -->
            <label for="sketchbookSelect">Select a Sketchbook</label>
            <select id="sketchbookSelect">
                <!-- Vai ser preenchido dinamicamente com dados do utilizador -->
            </select>

            <!-- Botão Guardar -->
            <button class="chat-generate-btn" onclick="saveToExistingSketchbook()">Add to Sketchbook</button>
        </div>
    </div>
</div>


@endsection
