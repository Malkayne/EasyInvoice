<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'EasyInvoice') }} - Professional Invoicing Made Simple</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --primary-color: #7367f0;
                --primary-dark: #5f55d6;
                --primary-light: #8b82f8;
                --primary-50: #f5f3ff;
                --primary-100: #e9e5ff;
                --primary-200: #d4ccff;
                --primary-600: #7367f0;
                --primary-700: #5f55d6;
                --primary-900: #3b3666;
            }
            
            .text-primary-600 { color: var(--primary-600); }
            .text-primary-700 { color: var(--primary-700); }
            .text-primary-900 { color: var(--primary-900); }
            .bg-primary-600 { background-color: var(--primary-600); }
            .bg-primary-700 { background-color: var(--primary-700); }
            .bg-primary-900 { background-color: var(--primary-900); }
            .bg-primary-50 { background-color: var(--primary-50); }
            .bg-primary-100 { background-color: var(--primary-100); }
            .border-primary-100 { border-color: var(--primary-100); }
            .hover\:bg-primary-700:hover { background-color: var(--primary-700); }
            .hover\:bg-primary-50:hover { background-color: var(--primary-50); }
            .hover\:text-primary-600:hover { color: var(--primary-600); }
            .shadow-primary-500\/30 { box-shadow: 0 10px 15px -3px rgba(115, 103, 240, 0.3); }
            
            /* Animations */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            @keyframes fadeInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            @keyframes fadeInRight {
                from {
                    opacity: 0;
                    transform: translateX(30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            @keyframes bounceSlow {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.7; }
            }
            
            @keyframes slideInFromTop {
                from {
                    opacity: 0;
                    transform: translateY(-100px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .animate-fade-in-up {
                animation: fadeInUp 0.8s ease-out;
            }
            
            .animate-fade-in-left {
                animation: fadeInLeft 0.8s ease-out;
            }
            
            .animate-fade-in-right {
                animation: fadeInRight 0.8s ease-out;
            }
            
            .animate-bounce-slow {
                animation: bounceSlow 3s ease-in-out infinite;
            }
            
            .animate-float {
                animation: float 4s ease-in-out infinite;
            }
            
            .animate-pulse {
                animation: pulse 2s ease-in-out infinite;
            }
            
            .animate-slide-in-top {
                animation: slideInFromTop 0.6s ease-out;
            }
            
            /* Scroll animations */
            .scroll-animate {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.6s ease-out;
            }
            
            .scroll-animate.visible {
                opacity: 1;
                transform: translateY(0);
            }
            
            /* Hover effects */
            .hover-lift {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            
            .hover-lift:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
            
            /* Gradient text */
            .gradient-text {
                background: linear-gradient(135deg, var(--primary-color) 0%, #667eea 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            /* Glass effect */
            .glass-effect {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body class="antialiased font-sans bg-gray-50 text-gray-900">
        
        <!-- Navigation -->
        <nav class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-gray-100 animate-slide-in-top">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center gap-3 hover-lift">
                        <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary-500/30">
                            <i class="fas fa-file-invoice-dollar text-xl"></i>
                        </div>
                        <span class="font-bold text-2xl tracking-tight text-gray-900">Easy<span class="text-primary-600">Invoice</span></span>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition-colors hover-lift">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition-colors hover-lift">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 hover-lift">Get Started</a>
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
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-primary-50 rounded-full blur-3xl opacity-50 animate-float"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[600px] h-[600px] bg-blue-50 rounded-full blur-3xl opacity-50 animate-float" style="animation-delay: 2s;"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary-50 border border-primary-100 text-primary-700 text-sm font-medium mb-8 animate-fade-in-up">
                    <span class="flex h-2 w-2 rounded-full bg-primary-600 mr-2 animate-pulse"></span>
                    Now available 100% Free
                </div>
                
                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 mb-8 leading-tight animate-fade-in-up">
                    Invoicing made <br class="hidden md:block" />
                    <span class="gradient-text">beautifully simple</span>
                </h1>
                
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600 mb-10 leading-relaxed animate-fade-in-up" style="animation-delay: 0.2s;">
                    Create professional invoices in seconds, manage customers, and get paid faster. Designed for freelancers and small businesses who value their time.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up" style="animation-delay: 0.4s;">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-primary-600 text-white text-lg font-bold rounded-xl hover:bg-primary-700 transition-all shadow-xl shadow-primary-500/30 transform hover:-translate-y-1 flex items-center justify-center hover-lift">
                        <i class="fas fa-rocket mr-2"></i>
                        Start Invoicing Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#features" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 text-lg font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all flex items-center justify-center hover-lift">
                        <i class="fas fa-play-circle mr-2"></i>
                        Learn More
                    </a>
                </div>

                <!-- Stats Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 animate-fade-in-up" style="animation-delay: 0.6s;">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary-600 mb-2">10K+</div>
                        <div class="text-gray-600">Happy Users</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary-600 mb-2">$50M+</div>
                        <div class="text-gray-600">Invoices Processed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary-600 mb-2">99.9%</div>
                        <div class="text-gray-600">Uptime</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-20 scroll-animate">
                    <h2 class="text-primary-600 font-semibold tracking-wide uppercase text-sm mb-3">Why EasyInvoice?</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Everything you need to run your business</h3>
                    <p class="text-lg text-gray-600">Stop wrestling with spreadsheets. We provide the tools you need to look professional and stay organized.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <!-- Feature 1 -->
                    <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-white border border-transparent hover:border-gray-100 hover:shadow-xl transition-all duration-300 scroll-animate hover-lift">
                        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-magic"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Smart Invoice Builder</h4>
                        <p class="text-gray-600 leading-relaxed">Create beautiful invoices in seconds. Auto-calculations for taxes and discounts mean zero math errors.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-white border border-transparent hover:border-gray-100 hover:shadow-xl transition-all duration-300 scroll-animate hover-lift" style="animation-delay: 0.1s;">
                        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Client Management</h4>
                        <p class="text-gray-600 leading-relaxed">Keep all your client details in one place. One-click reuse for recurring invoices.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-white border border-transparent hover:border-gray-100 hover:shadow-xl transition-all duration-300 scroll-animate hover-lift" style="animation-delay: 0.2s;">
                        <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Instant PDF & Sharing</h4>
                        <p class="text-gray-600 leading-relaxed">Download professional PDFs or share a secure public link with your clients instantly.</p>
                    </div>
                </div>

                <!-- Additional Features -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">
                    <div class="text-center scroll-animate hover-lift">
                        <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5 class="font-semibold text-gray-900 mb-2">Email Invoices</h5>
                        <p class="text-sm text-gray-600">Send invoices directly to clients with one click</p>
                    </div>
                    <div class="text-center scroll-animate hover-lift" style="animation-delay: 0.1s;">
                        <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h5 class="font-semibold text-gray-900 mb-2">Track Payments</h5>
                        <p class="text-sm text-gray-600">Monitor invoice status and payment history</p>
                    </div>
                    <div class="text-center scroll-animate hover-lift" style="animation-delay: 0.2s;">
                        <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h5 class="font-semibold text-gray-900 mb-2">Mobile Friendly</h5>
                        <p class="text-sm text-gray-600">Create and manage invoices on any device</p>
                    </div>
                    <div class="text-center scroll-animate hover-lift" style="animation-delay: 0.3s;">
                        <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5 class="font-semibold text-gray-900 mb-2">Secure & Private</h5>
                        <p class="text-sm text-gray-600">Your data is encrypted and always protected</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-20 scroll-animate">
                    <h2 class="text-primary-600 font-semibold tracking-wide uppercase text-sm mb-3">How It Works</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Get started in 3 simple steps</h3>
                    <p class="text-lg text-gray-600">From signup to your first invoice in less than 5 minutes</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center scroll-animate">
                        <div class="w-16 h-16 bg-primary-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold hover-lift">
                            1
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Sign Up Free</h4>
                        <p class="text-gray-600">Create your account in seconds. No credit card required.</p>
                    </div>
                    <div class="text-center scroll-animate" style="animation-delay: 0.1s;">
                        <div class="w-16 h-16 bg-primary-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold hover-lift">
                            2
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Add Clients</h4>
                        <p class="text-gray-600">Import your client list or add them manually.</p>
                    </div>
                    <div class="text-center scroll-animate" style="animation-delay: 0.2s;">
                        <div class="w-16 h-16 bg-primary-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold hover-lift">
                            3
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Send Invoices</h4>
                        <p class="text-gray-600">Create professional invoices and get paid faster.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 scroll-animate">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Loved by freelancers worldwide</h2>
                    <p class="text-lg text-gray-600">See what our users have to say about EasyInvoice</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 scroll-animate hover-lift">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-3">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-900">Sarah Johnson</h5>
                                <p class="text-sm text-gray-500">Freelance Designer</p>
                            </div>
                        </div>
                        <div class="flex mb-3">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <p class="text-gray-600">"EasyInvoice transformed how I handle my billing. I save hours each month and my clients love the professional look."</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 scroll-animate hover-lift" style="animation-delay: 0.1s;">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-3">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-900">Mike Chen</h5>
                                <p class="text-sm text-gray-500">Developer</p>
                            </div>
                        </div>
                        <div class="flex mb-3">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <p class="text-gray-600">"The best invoicing tool I've used. Simple, clean, and gets the job done without any complications."</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 scroll-animate hover-lift" style="animation-delay: 0.2s;">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-3">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-900">Emily Davis</h5>
                                <p class="text-sm text-gray-500">Consultant</p>
                            </div>
                        </div>
                        <div class="flex mb-3">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <p class="text-gray-600">"I've tried many invoicing apps, but EasyInvoice is by far the most intuitive. Highly recommended!"</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-20 scroll-animate">
                    <h2 class="text-primary-600 font-semibold tracking-wide uppercase text-sm mb-3">Pricing</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Simple, transparent pricing</h3>
                    <p class="text-lg text-gray-600">Start free and scale as you grow</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <div class="bg-white rounded-2xl p-8 border border-gray-200 scroll-animate hover-lift">
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Starter</h4>
                        <div class="text-3xl font-bold text-gray-900 mb-4">Free</div>
                        <p class="text-gray-600 mb-6">Perfect for freelancers just starting out</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Up to 10 invoices per month
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Basic templates
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Email support
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" class="w-full py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors text-center block">
                            Get Started
                        </a>
                    </div>

                    <div class="bg-primary-600 text-white rounded-2xl p-8 transform scale-105 scroll-animate hover-lift">
                        <div class="bg-primary-700 text-xs font-semibold px-3 py-1 rounded-full inline-block mb-4">MOST POPULAR</div>
                        <h4 class="text-xl font-bold mb-2">Professional</h4>
                        <div class="text-3xl font-bold mb-4">$19<span class="text-lg font-normal">/month</span></div>
                        <p class="text-primary-100 mb-6">For growing businesses</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary-200 mr-2"></i>
                                Unlimited invoices
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary-200 mr-2"></i>
                                Premium templates
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary-200 mr-2"></i>
                                Priority support
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary-200 mr-2"></i>
                                Advanced analytics
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" class="w-full py-3 bg-white text-primary-600 rounded-lg font-semibold hover:bg-primary-50 transition-colors text-center block">
                            Start Free Trial
                        </a>
                    </div>

                    <div class="bg-white rounded-2xl p-8 border border-gray-200 scroll-animate hover-lift">
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Enterprise</h4>
                        <div class="text-3xl font-bold text-gray-900 mb-4">Custom</div>
                        <p class="text-gray-600 mb-6">For large teams and organizations</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Everything in Pro
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Custom branding
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                API access
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Dedicated support
                            </li>
                        </ul>
                        <a href="#" class="w-full py-3 bg-gray-900 text-white rounded-lg font-semibold hover:bg-gray-800 transition-colors text-center block">
                            Contact Sales
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-primary-900 rounded-3xl p-12 md:p-20 text-center relative overflow-hidden shadow-2xl scroll-animate">
                    <!-- Decor -->
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-64 h-64 bg-primary-700 rounded-full opacity-20 blur-3xl animate-float"></div>
                    <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-64 h-64 bg-blue-600 rounded-full opacity-20 blur-3xl animate-float" style="animation-delay: 1s;"></div>

                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 relative z-10">Ready to streamline your billing?</h2>
                    <p class="text-primary-200 text-xl mb-10 max-w-2xl mx-auto relative z-10">Join thousands of freelancers who trust EasyInvoice. No credit card required.</p>
                    
                    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-primary-900 text-lg font-bold rounded-xl hover:bg-primary-50 transition-all shadow-lg transform hover:-translate-y-1 relative z-10 hover-lift">
                        <i class="fas fa-rocket mr-2"></i>
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
                            <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <span class="font-bold text-xl text-gray-900">EasyInvoice</span>
                        </div>
                        <p class="text-gray-500 text-sm">
                            Simplifying business for freelancers world wide.
                        </p>
                        <div class="flex space-x-4 mt-4">
                            <a href="#" class="text-gray-400 hover:text-primary-600 transition-colors">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary-600 transition-colors">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary-600 transition-colors">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-900 mb-4">Product</h5>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li><a href="#features" class="hover:text-primary-600 transition-colors">Features</a></li>
                            <li><a href="#pricing" class="hover:text-primary-600 transition-colors">Pricing</a></li>
                            <li><a href="#" class="hover:text-primary-600 transition-colors">Updates</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-900 mb-4">Company</h5>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li><a href="#" class="hover:text-primary-600 transition-colors">About</a></li>
                            <li><a href="#" class="hover:text-primary-600 transition-colors">Contact</a></li>
                            <li><a href="#" class="hover:text-primary-600 transition-colors">Privacy</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-900 mb-4">Support</h5>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li><a href="#" class="hover:text-primary-600 transition-colors">Help Center</a></li>
                            <li><a href="#" class="hover:text-primary-600 transition-colors">Documentation</a></li>
                            <li><a href="#" class="hover:text-primary-600 transition-colors">FAQ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-500">&copy; {{ date('Y') }} EasyInvoice. All rights reserved.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-primary-600 transition-colors">Terms</a>
                        <a href="#" class="text-gray-400 hover:text-primary-600 transition-colors">Privacy</a>
                    </div>
                </div>
            </div>
        </footer>

        <script>
            // Scroll animation
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.scroll-animate').forEach(el => {
                observer.observe(el);
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add parallax effect to floating elements
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const parallax = document.querySelectorAll('.animate-float');
                parallax.forEach(element => {
                    const speed = element.dataset.speed || 0.5;
                    element.style.transform = `translateY(${scrolled * speed}px)`;
                });
            });
        </script>
    </body>
</html>
