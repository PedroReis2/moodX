{{-- dashboard formando --}}

{{-- resources/views/dashboard.blade.php --}}
@extends('layout.fe_dashboard_master')

@section('title', 'Dashboard — mood.x')

{{-- Hero (título/subtítulo no topo da página) --}}
@section('hero')
  <h2 class="text-center mt-2" style="color:#2b2b2b; font-size:22px;">
    Start with one fabric, and build your vision.
  </h2>
  <p class="text-center" style="color:#6d6d6d;">
    Your moodboard starts here
  </p>
@endsection

{{-- Toolbar preta (pill com botões) --}}
@section('toolbar')
  <div class="tool-pill">
    <button class="tool-btn">＋</button>
    <button class="tool-btn">🖼️ Assets</button>
    <button class="tool-btn">⏱️ History</button>
    <button class="tool-btn">📝 Notes</button>
    <button class="tool-btn">❓ Help</button>
  </div>

@endsection

  @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>

                        <form action="{{route('logout')}}" method='Post'>@CSRF <button type="submit">Logout</button></form>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('users.add'))
                            <a
                                href="{{ route('users.add') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif



