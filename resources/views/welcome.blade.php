<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'EasyInvoice') }} - Professional Invoicing Made Simple</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-gray-50 text-gray-900">
        
        <!-- Navigation -->
        <nav class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <div class="w-10 h-10 bg-royal-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-royal-500/30">
                            <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                        </div>
                        <span class="font-bold text-2xl tracking-tight text-gray-900">Easy<span class="text-royal-600">Invoice</span></span>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-royal-600 transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-royal-600 transition-colors">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-royal-600 text-white text-sm font-semibold rounded-lg hover:bg-royal-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">Get Started</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-royal-50 rounded-full blur-3xl opacity-50"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[600px] h-[600px] bg-blue-50 rounded-full blur-3xl opacity-50"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-royal-50 border border-royal-100 text-royal-700 text-sm font-medium mb-8 animate-fade-in-up">
                    <span class="flex h-2 w-2 rounded-full bg-royal-600 mr-2"></span>
                    Now available 100% Free
                </div>
                
                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 mb-8 leading-tight">
                    Invoicing made <br class="hidden md:block" />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-royal-600 to-blue-500">beautifully simple</span>
                </h1>
                
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600 mb-10 leading-relaxed">
                    Create professional invoices in seconds, manage customers, and get paid faster. Designed for freelancers and small businesses who value their time.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-royal-600 text-white text-lg font-bold rounded-xl hover:bg-royal-700 transition-all shadow-xl shadow-royal-500/30 transform hover:-translate-y-1 flex items-center justify-center">
                        Start Invoicing Now <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#features" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 text-lg font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all flex items-center justify-center">
                        Learn More
                    </a>
                </div>

                <!-- Hero Image Placeholder/Preview -->
                <div class="mt-20 relative mx-auto max-w-5xl">
                    <div class="bg-gray-900 rounded-2xl p-2 shadow-2xl ring-1 ring-gray-900/10">
                        <div class="bg-gray-800 rounded-t-xl h-6 flex items-center px-4 space-x-2 mb-[-1px]">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                        </div>
                        <img src="/dashboard-preview.png" onerror="this.src='https://placehold.co/1200x800/1e293b/ffffff?text=EasyInvoice+Dashboard+Preview'" alt="App Screenshot" class="rounded-b-xl w-full h-auto border-t border-gray-700 opacity-90 hover:opacity-100 transition-opacity">
                    </div>
                    <!-- Floating Badge -->
                    <div class="absolute -bottom-10 -right-10 bg-white p-6 rounded-2xl shadow-xl border border-gray-100 hidden md:block animate-bounce-slow">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                <i class="fa-solid fa-check text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Invoice Paid</p>
                                <p class="text-xl font-bold text-gray-900">$1,250.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <h2 class="text-royal-600 font-semibold tracking-wide uppercase text-sm mb-3">Why EasyInvoice?</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Everything you need to run your business</h3>
                    <p class="text-lg text-gray-600">Stop wrestling with spreadsheets. We provide the tools you need to look professional and stay organized.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <!-- Feature 1 -->
                    <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-white border border-transparent hover:border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Smart Invoice Builder</h4>
                        <p class="text-gray-600 leading-relaxed">Create beautiful invoices in seconds. Auto-calculations for taxes and discounts mean zero math errors.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-white border border-transparent hover:border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-address-book"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Client Management</h4>
                        <p class="text-gray-600 leading-relaxed">Keep all your client details in one place. One-click reuse for recurring invoices.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-white border border-transparent hover:border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Instant PDF & Sharing</h4>
                        <p class="text-gray-600 leading-relaxed">Download professional PDFs or share a secure public link with your clients instantly.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-royal-900 rounded-3xl p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
                    <!-- Decor -->
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-64 h-64 bg-royal-700 rounded-full opacity-20 blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-64 h-64 bg-blue-600 rounded-full opacity-20 blur-3xl"></div>

                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 relative z-10">Ready to streamline your billing?</h2>
                    <p class="text-royal-200 text-xl mb-10 max-w-2xl mx-auto relative z-10">Join thousands of freelancers who trust EasyInvoice. No credit card required.</p>
                    
                    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-royal-900 text-lg font-bold rounded-xl hover:bg-royal-50 transition-all shadow-lg transform hover:-translate-y-1 relative z-10">
                        Get Started for Free
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 pt-16 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                    <div class="col-span-1 md:col-span-1">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 bg-royal-600 rounded-lg flex items-center justify-center text-white">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </div>
                            <span class="font-bold text-xl text-gray-900">EasyInvoice</span>
                        </div>
                        <p class="text-gray-500 text-sm">
                            Simplifying business for freelancers world wide.
                        </p>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-900 mb-4">Product</h5>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li><a href="#" class="hover:text-royal-600">Features</a></li>
                            <li><a href="#" class="hover:text-royal-600">Pricing</a></li>
                            <li><a href="#" class="hover:text-royal-600">Updates</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-900 mb-4">Company</h5>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li><a href="#" class="hover:text-royal-600">About</a></li>
                            <li><a href="#" class="hover:text-royal-600">Contact</a></li>
                            <li><a href="#" class="hover:text-royal-600">Privacy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-500">&copy; {{ date('Y') }} EasyInvoice. All rights reserved.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-royal-600"><i class="fa-brands fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-royal-600"><i class="fa-brands fa-github text-xl"></i></a>
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>
