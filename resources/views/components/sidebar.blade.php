
<div class="w-1/6 bg-[#E3CAA5] h-screen px-0 py-4 font-poppins">
    <!-- Tombol Keluar -->
    <a href="{{ route('logout') }}" 
       class="text-gray-600 hover:text-red-600 absolute top-0 left-0 mt-2 ml-2 flex items-center"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out-alt text-xl" style="transform: scaleX(-1);"></i>
        <span class="ml-1 text-sm font-medium">Keluar</span>
    </a>

    <!-- Profil Pengguna -->
    <div class="mb-6 flex flex-col items-center mt-8">
        <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center mb-2">
            <i class="fa fa-user text-gray-500 text-4xl"></i>
        </div>
        <p class="text-base font-bold text-gray-800">{{ Auth::user()->name }}</p>
    </div>

    <!-- Menu Sidebar -->
    <nav>
        <ul class="space-y-4">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="block text-gray-800 font-bold hover:bg-[#DAB89C] py-2 px-4 rounded-lg flex items-center">
                    <i class="fa fa-home mr-2 text-2xl"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('data.index') }}"
                   class="block text-gray-800 font-medium hover:bg-[#DAB89C] py-2 px-4 rounded-lg flex items-center">
                    <i class="fa fa-database mr-2 text-2xl"></i> Kelola Data
                </a>
            </li>
            <li>
                <a href="{{ route('analisis.index')}}" 
                   class="block text-gray-800 font-medium hover:bg-[#DAB89C] py-2 px-4 rounded-lg flex items-center">
                    <i class="fa fa-chart-bar mr-2 text-2xl"></i> Hasil Analisis
                </a>
            </li>
        </ul>
    </nav>

    <!-- Form Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>