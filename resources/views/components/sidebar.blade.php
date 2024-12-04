<div class="w-1/6 bg-[#E3CAA5] h-screen px-6 py-8">
    <!-- Profil Pengguna -->
    <div class="flex items-center space-x-4 mb-8">
        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
            <i class="fa fa-user text-gray-500"></i>
        </div>
        
        <div>
            <p class="text-3xl font-medium">{{ Auth::user()->name }}</p>
            <a href="{{ route('logout') }}"
                class="text-xl text-gray-600 hover:underline"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="text-xl fa fa-sign-out-alt"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>

    <!-- Menu Sidebar -->
    <nav>
        <ul class="space-y-4">
            <li>
                <a href="{{route('dashboard') }}"
                    class="block text-2xl text-gray-800 font-medium hover:bg-[#DAB89C] py-2 px-4 rounded-lg">
                    <i class="fa fa-home"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{route('data.index')}}"
                    class="block text-2xl text-gray-800 font-medium hover:bg-[#DAB89C] py-2 px-4 rounded-lg">
                    <i class="fa fa-database"></i> Kelola Data
                </a>
            </li>
            <li>
                <a href="#"
                    class="block text-2xl text-gray-800 font-medium hover:bg-[#DAB89C] py-2 px-4 rounded-lg">
                    <i class="fa fa-chart-bar"></i> Hasil Analisis
                </a>
            </li>
        </ul>
    </nav>
</div>
