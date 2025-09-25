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

            <!-- Lado direito: título, descrição e botão -->
            <div class="modal-details">
                <h3 class="modal-title">Generated Image</h3>
                <p class="description-text">You can save this image to your Studio project.</p>
                <button class="chat-generate-btn" onclick="saveImageToStudio()">Save to Studio</button>
            </div>
        </div>
    </div>
</div>

@endsection
