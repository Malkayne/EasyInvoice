<div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

<div x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-royal-900 lg:translate-x-0 lg:static lg:inset-0 shadow-2xl lg:shadow-none font-sans">
    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center text-white space-x-2">
            <i class="fa-solid fa-file-invoice-dollar text-3xl"></i>
            <span class="text-2xl font-bold tracking-wide">EasyInvoice</span>
        </div>
    </div>

    <nav class="mt-10 px-4 space-y-2">
        <a class="flex items-center px-4 py-3 duration-200 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-royal-800 text-white shadow-lg' : 'text-royal-200 hover:bg-royal-800 hover:text-white' }}"
           href="{{ route('dashboard') }}" @click="sidebarOpen = false">
            <i class="fa-solid fa-gauge-high w-6 text-center"></i>
            <span class="mx-4 font-medium">Dashboard</span>
        </a>

        <a class="flex items-center px-4 py-3 duration-200 rounded-lg {{ request()->routeIs('invoices.*') ? 'bg-royal-800 text-white shadow-lg' : 'text-royal-200 hover:bg-royal-800 hover:text-white' }}"
           href="{{ route('invoices.index') }}" @click="sidebarOpen = false">
            <i class="fa-solid fa-file-invoice w-6 text-center"></i>
            <span class="mx-4 font-medium">Invoices</span>
        </a>

        <a class="flex items-center px-4 py-3 duration-200 rounded-lg {{ request()->routeIs('customers.*') ? 'bg-royal-800 text-white shadow-lg' : 'text-royal-200 hover:bg-royal-800 hover:text-white' }}"
           href="{{ route('customers.index') }}" @click="sidebarOpen = false">
            <i class="fa-solid fa-users w-6 text-center"></i>
            <span class="mx-4 font-medium">Customers</span>
        </a>
        
        <a class="flex items-center px-4 py-3 duration-200 rounded-lg {{ request()->routeIs('business.*') ? 'bg-royal-800 text-white shadow-lg' : 'text-royal-200 hover:bg-royal-800 hover:text-white' }}"
           href="{{ route('business.setup') }}" @click="sidebarOpen = false">
            <i class="fa-solid fa-building w-6 text-center"></i>
            <span class="mx-4 font-medium">Business Profile</span>
        </a>
    </nav>
    
    <!-- User Profile Bottom -->
    <div class="absolute bottom-0 w-full bg-royal-950/50 backdrop-blur-sm border-t border-royal-800">
        <div class="flex items-center px-6 py-4">
            <div class="flex-shrink-0">
                <div class="h-10 w-10 rounded-full bg-royal-600 flex items-center justify-center text-white font-bold text-sm shadow-inner ring-2 ring-royal-500">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
            <div class="ml-3 overflow-hidden">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-royal-300 hover:text-white flex items-center mt-0.5 transition-colors">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i> Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
