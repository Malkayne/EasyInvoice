<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets') }}/">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <title>{{ config('app.name', 'EasyInvoice') }} - Professional Invoicing Made Simple</title>
        
        <meta name="description" content="Create and manage invoices for your business with ease." />
        
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />

        <!-- Page CSS -->
        <link rel="stylesheet" href="{{ asset('assets/custom/theme-overrides.css') }}" />

        <!-- Helpers -->
        <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
        <script src="{{ asset('assets/js/config.js') }}"></script>

        <style>
            .hero-gradient {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            }
            .feature-card {
                transition: all 0.3s ease;
            }
            .badge-pulse {
                animation: pulse 2s infinite;
            }
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.5; }
            }
        </style>
    </head>
    <body>
        
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <span class="d-flex align-items-center justify-content-center bg-primary text-white rounded" style="width: 40px; height: 40px;">
                        <i class="ti ti-file-invoice fs-4"></i>
                    </span>
                    <span class="ms-2 fw-bold fs-4">Easy<span class="text-primary">Invoice</span></span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item">
                                    <a href="{{ url('/dashboard') }}" class="nav-link fw-semibold">Dashboard</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="nav-link fw-semibold">Log in</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item ms-2">
                                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                                    </li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-gradient text-white" style="padding-top: 120px; padding-bottom: 80px; margin-top: 56px;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12 text-center">
                        <div class="mb-4">
                            <span class="badge bg-white text-primary px-3 py-2 rounded-pill">
                                <span class="badge-pulse me-2">●</span>
                                Now available 100% Free
                            </span>
                        </div>
                        
                        <h1 class="display-2 fw-bold mb-4">
                            Invoicing made<br />
                            <span class="text-warning">beautifully simple</span>
                        </h1>
                        
                        <p class="lead mb-5 mx-auto" style="max-width: 700px; opacity: 0.95;">
                            Create professional invoices in seconds, manage customers, and get paid faster. Designed for freelancers and small businesses who value their time.
                        </p>
                        
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow">
                                Start Invoicing Now <i class="ti ti-arrow-right ms-2"></i>
                            </a>
                            <a href="#features" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">
                                Learn More
                            </a>
                        </div>

                        <!-- Hero Image -->
                        <div class="mt-5 position-relative">
                            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                                <div class="card-header bg-dark py-2 px-3">
                                    <div class="d-flex gap-1">
                                        <span class="rounded-circle bg-danger" style="width: 12px; height: 12px;"></span>
                                        <span class="rounded-circle bg-warning" style="width: 12px; height: 12px;"></span>
                                        <span class="rounded-circle bg-success" style="width: 12px; height: 12px;"></span>
                                    </div>
                                </div>
                                <img src="/dashboard-preview.png" onerror="this.src='https://placehold.co/1200x800/696cff/ffffff?text=EasyInvoice+Dashboard+Preview'" alt="App Screenshot" class="card-img-bottom" style="opacity: 0.95;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-5 bg-light">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h6 class="text-primary fw-bold text-uppercase mb-2">Why EasyInvoice?</h6>
                    <h2 class="display-5 fw-bold mb-3">Everything you need to run your business</h2>
                    <p class="lead text-muted mx-auto" style="max-width: 700px;">
                        Stop wrestling with spreadsheets. We provide the tools you need to look professional and stay organized.
                    </p>
                </div>

                <div class="row g-4">
                    <!-- Feature 1 -->
                    <div class="col-md-4">
                        <div class="card border-0 h-100 feature-card shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded mb-4" style="width: 64px; height: 64px;">
                                    <i class="ti ti-wand fs-1"></i>
                                </div>
                                <h4 class="fw-bold mb-3">Smart Invoice Builder</h4>
                                <p class="text-muted mb-0">Create beautiful invoices in seconds. Auto-calculations for taxes and discounts mean zero math errors.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="col-md-4">
                        <div class="card border-0 h-100 feature-card shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info rounded mb-4" style="width: 64px; height: 64px;">
                                    <i class="ti ti-address-book fs-1"></i>
                                </div>
                                <h4 class="fw-bold mb-3">Client Management</h4>
                                <p class="text-muted mb-0">Keep all your client details in one place. One-click reuse for recurring invoices.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="col-md-4">
                        <div class="card border-0 h-100 feature-card shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded mb-4" style="width: 64px; height: 64px;">
                                    <i class="ti ti-file-type-pdf fs-1"></i>
                                </div>
                                <h4 class="fw-bold mb-3">Instant PDF & Sharing</h4>
                                <p class="text-muted mb-0">Download professional PDFs or share a secure public link with your clients instantly.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-5">
            <div class="container py-5">
                <div class="card border-0 shadow-lg hero-gradient text-white" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body text-center p-5">
                        <h2 class="display-4 fw-bold mb-4">Ready to streamline your billing?</h2>
                        <p class="lead mb-4 mx-auto" style="max-width: 700px; opacity: 0.95;">
                            Join thousands of freelancers who trust EasyInvoice. No credit card required.
                        </p>
                        
                        <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow">
                            Get Started for Free
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-top py-5">
            <div class="container">
                <div class="row g-4 mb-4">
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center mb-3">
                            <span class="d-flex align-items-center justify-content-center bg-primary text-white rounded" style="width: 32px; height: 32px;">
                                <i class="ti ti-file-invoice"></i>
                            </span>
                            <span class="ms-2 fw-bold fs-5">EasyInvoice</span>
                        </div>
                        <p class="text-muted small">
                            Simplifying business for freelancers worldwide.
                        </p>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <h6 class="fw-bold mb-3">Product</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#features" class="text-muted text-decoration-none small">Features</a></li>
                            <li class="mb-2"><a href="#" class="text-muted text-decoration-none small">Pricing</a></li>
                            <li class="mb-2"><a href="#" class="text-muted text-decoration-none small">Updates</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <h6 class="fw-bold mb-3">Company</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-muted text-decoration-none small">About</a></li>
                            <li class="mb-2"><a href="#" class="text-muted text-decoration-none small">Contact</a></li>
                            <li class="mb-2"><a href="#" class="text-muted text-decoration-none small">Privacy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-top pt-4">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            <p class="text-muted small mb-0">&copy; {{ date('Y') }} EasyInvoice. All rights reserved.</p>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <a href="#" class="text-muted me-3"><i class="ti ti-brand-twitter fs-5"></i></a>
                            <a href="#" class="text-muted"><i class="ti ti-brand-github fs-5"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Core JS -->
        <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script>
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });
        </script>
    </body>
</html>
