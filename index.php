<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "include/config.php";
//require "backend/clean.php";
$sql = "SELECT SUM(file_size) as total_bytes FROM files";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalBytes = $row['total_bytes'];

    // Convert bytes to gigabytes (1 GB = 1073741824 bytes)
    $size = $totalBytes / 1048576;
    $size = round($size, 2);

    $sql1 = "SELECT * FROM files";
    $result1 = $db->query($sql1);

    if ($result1->num_rows > 0) {
        $number = $result1->num_rows;
    } else {
        $number = 0;
    }
} else {
    $size = 0;
    $number = 0;
}




?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SendNow - Secure File Sharing</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description" content="Send files up to 10 MB instantly using QR codes, PINs, or private links. No login needed. Files are auto-deleted after 3 hours for full security.">
    <meta name="keywords" content="SendNow, file sharing, send files, receive files, QR file transfer, secure upload, temporary link, no login, file delivery">
    <meta name="author" content="Bhavneet Verma">
    <link rel="canonical" href="https://sendnow.free.nf">

    <!-- Favicon & Mobile App Icon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="/assets/apple-icon.png">
    <meta name="theme-color" content="#007aff">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- Open Graph Meta for Social Sharing -->
    <meta property="og:title" content="SendNow - Secure File Sharing">
    <meta property="og:description" content="Send and receive files using codes or QR without registration. Secure. Auto-delete after 3 hours.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://sendnow.free.nf">
    <meta property="og:image" content="https://sendnow.free.nf/assets/favicon/favicon-16x16.png">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SendNow - Share Files Securely">
    <meta name="twitter:description" content="Send or receive files with QR or PIN no login auto-expiring links.">
    <meta name="twitter:image" content="https://sendnow.fun/assets/favicon/favicon-16x16.png">

    <!-- Preconnect for Faster Font Load (Optional) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/4.1.11/lib.min.js" integrity="sha512-tE7j0ptGYRtx0sHRAOkHNLAuIqVW7udzmjvNh1A6vIEnWUJnx7j7khwTEjemjDaauV+lHo0jEtdW8jn5weoxhw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="assest/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assest/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assest/favicon/favicon-16x16.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="manifest" href="assest/favicon/site.webmanifest">

    <!-- jquery cdn -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        @import url('assest/css/style.css');

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .receive-btn.loading .spinner {
            display: inline-block;
        }

        .receive-btn.loading .btn-text {
            display: none;
        }

        .receive-btn:disabled {
            cursor: not-allowed;
            opacity: 0.8;
        }

        .receive-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
    </style>
</head>

<body class="bg-gray-900 text-white overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 nav-backdrop border-b border-slate-700/50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo Section -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-600 rounded-xl flex items-center justify-center logo-glow">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 00-2 2v1.816a2.03 2.03 0 00.877.72l3.654 2.195A3 3 0 017.5 9.5v.5H16a1 1 0 011 1v4a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-bold bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent">
                            SendNow
                        </span>
                        <span class="text-xs text-slate-400 -mt-1">Secure • Fast • Reliable</span>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#home" class="nav-link px-4 py-2 rounded-lg hover:text-cyan-400 transition-all duration-300 text-slate-200 hover:bg-slate-800/50">
                        Home
                    </a>
                    <a href="#upload" class="nav-link px-4 py-2 rounded-lg hover:text-cyan-400 transition-all duration-300 text-slate-200 hover:bg-slate-800/50">
                        Upload
                    </a>
                    <a href="#receive-section" class="nav-link px-4 py-2 rounded-lg hover:text-cyan-400 transition-all duration-300 text-slate-200 hover:bg-slate-800/50">
                        Receive
                    </a>
                    <a href="about.php" class="nav-link px-4 py-2 rounded-lg hover:text-cyan-400 transition-all duration-300 text-slate-200 hover:bg-slate-800/50">
                        About
                    </a>

                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg glass-effect hover:bg-slate-800/50 transition-all duration-300">
                    <svg class="w-6 h-6 menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden lg:hidden mt-6 space-y-4 glass-effect rounded-2xl p-6 border border-slate-700/50">
                <a href="#home" class="block px-4 py-3 rounded-xl hover:text-cyan-400 hover:bg-slate-800/50 transition-all duration-300">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Home</span>
                    </div>
                </a>
                <a href="#upload" class="block px-4 py-3 rounded-xl hover:text-cyan-400 hover:bg-slate-800/50 transition-all duration-300">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <span>Upload</span>
                    </div>
                </a>
                <a href="#receive-section" class="block px-4 py-3 rounded-xl hover:text-cyan-400 hover:bg-slate-800/50 transition-all duration-300">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>Receive </span>
                    </div>
                </a>
                <a href="about.php" class="block px-4 py-3 rounded-xl hover:text-cyan-400 hover:bg-slate-800/50 transition-all duration-300">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>About</span>
                    </div>
                </a>


            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center justify-center relative overflow-hidden pt-20">
        <!-- Enhanced Background Elements -->
        <div class="absolute inset-0">
            <!-- Original gradient orbs -->
            <div class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full opacity-20 blur-xl floating-animation"></div>
            <div class="absolute bottom-20 right-10 w-40 h-40 bg-gradient-to-r from-purple-400 to-blue-500 rounded-full opacity-20 blur-xl floating-slow"></div>
            <div class="absolute top-1/2 left-1/4 w-24 h-24 bg-gradient-to-r from-blue-400 to-cyan-500 rounded-full opacity-15 blur-xl floating-fast"></div>

            <!-- Additional gradient elements -->
            <div class="absolute top-32 right-1/4 w-28 h-28 bg-gradient-to-r from-purple-500 to-cyan-400 rounded-full opacity-10 blur-xl floating-animation"></div>
            <div class="absolute bottom-32 left-1/3 w-36 h-36 bg-gradient-to-r from-blue-500 to-purple-400 rounded-full opacity-15 blur-xl floating-slow"></div>
        </div>

        <!-- Floating Files -->
        <div class="absolute inset-0 pointer-events-none">
            <!-- PDF Files -->
            <div class="absolute top-24 left-16 floating-slow opacity-70">
                <div class="file-icon pdf-icon" data-type="PDF">
                    <div class="doc-lines"></div>
                    <div class="line3"></div>
                    <div class="line4"></div>
                </div>
            </div>
            <div class="absolute top-3/4 right-20 floating-animation opacity-60">
                <div class="file-icon pdf-icon" data-type="PDF">
                    <div class="doc-lines"></div>
                    <div class="line3"></div>
                    <div class="line4"></div>
                </div>
            </div>

            <!-- MP4 Files -->
            <div class="absolute top-1/3 right-16 floating-fast opacity-75">
                <div class="file-icon mp4-icon" data-type="MP4">
                    <div class="doc-lines"></div>
                    <div class="line3"></div>
                    <div class="line4"></div>
                </div>
            </div>
            <div class="absolute bottom-1/4 left-20 floating-slow opacity-65">
                <div class="file-icon mp4-icon" data-type="MP4">
                    <div class="doc-lines"></div>
                    <div class="line3"></div>
                    <div class="line4"></div>
                </div>
            </div>

            <!-- DOC Files -->
            <div class="absolute top-1/2 left-12 floating-animation opacity-70">
                <div class="file-icon doc-icon" data-type="DOC">
                    <div class="doc-lines"></div>
                    <div class="line3"></div>
                    <div class="line4"></div>
                </div>
            </div>
            <div class="absolute top-16 right-1/3 floating-fast opacity-60">
                <div class="file-icon doc-icon" data-type="DOC">
                    <div class="doc-lines"></div>
                    <div class="line3"></div>
                    <div class="line4"></div>
                </div>
            </div>

            <!-- ZIP Files -->
            <div class="absolute bottom-16 right-1/4 floating-slow opacity-65">
                <div class="file-icon zip-icon" data-type="ZIP">
                    <div class="doc-lines"></div>
                    <div class="line3"></div>
                    <div class="line4"></div>
                </div>
            </div>
            <div class="absolute top-2/3 left-1/4 floating-animation opacity-70">
                <div class="file-icon zip-icon" data-type="ZIP">
                    <div class="doc-lines"></div>
                    <div class="line3"></div>
                    <div class="line4"></div>
                </div>
            </div>

            <!-- Additional smaller files for mobile -->
            <div class="absolute top-40 left-1/2 floating-fast opacity-50 hidden sm:block">
                <div class="file-icon pdf-icon scale-75" data-type="PDF">
                    <div class="doc-lines"></div>
                    <div class="line3"></div>
                    <div class="line4"></div>
                </div>
            </div>
            <div class="absolute bottom-40 left-1/3 floating-slow opacity-55 hidden sm:block">
                <div class="file-icon mp4-icon scale-75" data-type="MP4">
                    <div class="doc-lines"></div>
                    <div class="line3"></div>
                    <div class="line4"></div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 text-center relative z-10 hero2">
            <!-- Enhanced Heading -->
            <div class="mb-8">
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-4 bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 bg-clip-text text-transparent leading-tight">
                    Share Files
                    <span class="block mt-2">Effortlessly</span>
                </h1>
                <div class="w-24 h-1 bg-gradient-to-r from-cyan-400 to-purple-500 mx-auto rounded-full"></div>
            </div>

            <!-- Enhanced Description -->
            <p class="text-lg sm:text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed">
                Upload, share, and manage your files with our secure, fast, and user-friendly platform.
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 font-semibold">
                    Experience the future of file sharing.
                </span>
            </p>

            <!-- Enhanced Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 justify-center items-center px-9">
                <a href="#upload" class="w-full sm:w-auto">
                    <button class="btn-primary w-full sm:w-auto px-8 py-4 rounded-xl font-semibold text-white text-lg shadow-lg">
                        🚀 Start Sharing Now
                    </button>
                </a>
                <a href="#receive-section">
                    <button class="btn-secondary w-full sm:w-auto px-8 py-4 rounded-xl font-semibold text-gray-200 text-lg">
                        📥 Receive Files
                    </button>
                </a>
            </div>

            <!-- Feature highlights -->
            <div class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto">
                <div class="text-center p-4 rounded-lg bg-gray-800/30 backdrop-blur-sm border border-gray-700/50">
                    <div class="text-2xl mb-2">🔒</div>
                    <h3 class="text-sm font-semibold text-cyan-400 mb-1">Secure</h3>
                    <p class="text-xs text-gray-400">End-to-end encryption</p>
                </div>
                <div class="text-center p-4 rounded-lg bg-gray-800/30 backdrop-blur-sm border border-gray-700/50">
                    <div class="text-2xl mb-2">⚡</div>
                    <h3 class="text-sm font-semibold text-blue-400 mb-1">Fast</h3>
                    <p class="text-xs text-gray-400">Lightning-fast uploads</p>
                </div>
                <div class="text-center p-4 rounded-lg bg-gray-800/30 backdrop-blur-sm border border-gray-700/50">
                    <div class="text-2xl mb-2">🌐</div>
                    <h3 class="text-sm font-semibold text-purple-400 mb-1">Global</h3>
                    <p class="text-xs text-gray-400">Worldwide access</p>
                </div>
            </div>
        </div>
    </section>

    <!-- File Upload Section -->
    <section id="upload" class="py-20 relative overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0">
            <div class="absolute top-10 left-20 w-32 h-32 bg-gradient-to-r from-cyan-400/20 to-blue-500/20 rounded-full blur-xl"></div>
            <div class="absolute bottom-20 right-20 w-40 h-40 bg-gradient-to-r from-purple-400/20 to-blue-500/20 rounded-full blur-xl"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                    Upload Your Files
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Drag and drop your files or click to browse. We support all file types with
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 font-semibold">lightning-fast uploads</span>.
                </p>
            </div>

            <div class="max-w-5xl mx-auto relative">
                <!-- Enhanced Floating File Icons -->
                <div class="absolute inset-0 pointer-events-none">
                    <div class="file-icon top-10 left-10 floating-slow" style="animation-delay: -1s;">
                        <div class="w-full h-full bg-red-500/80 rounded-lg flex items-center justify-center text-white font-bold text-xs">PDF</div>
                    </div>
                    <div class="file-icon top-20 right-16 floating-fast" style="animation-delay: -3s;">
                        <div class="w-full h-full bg-green-500/80 rounded-lg flex items-center justify-center text-white font-bold text-xs">JPG</div>
                    </div>
                    <div class="file-icon bottom-10 left-20 floating-slow" style="animation-delay: -5s;">
                        <div class="w-full h-full bg-blue-500/80 rounded-lg flex items-center justify-center text-white font-bold text-xs">DOC</div>
                    </div>
                    <div class="file-icon bottom-16 right-10 floating-fast" style="animation-delay: -7s;">
                        <div class="w-full h-full bg-purple-500/80 rounded-lg flex items-center justify-center text-white font-bold text-xs">ZIP</div>
                    </div>
                </div>

                <!-- Enhanced Upload Area -->
                <div class="section-blur border-2 border-dashed border-gray-600 rounded-3xl p-8 md:p-12 text-center drag-area" id="drag-area">
                    <div class="mb-8">
                        <div class="w-32 h-32 upload-icon rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold mb-4 bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                            Drop your files here
                        </h3>
                        <p class="text-gray-400 mb-8 text-lg">or click to browse from your device</p>

                        <input type="file" id="file-input" class="hidden" name="file" accept="*">
                        <button class="relative bg-gradient-to-r from-cyan-500 to-blue-500 px-10 py-4 rounded-xl font-semibold text-lg hover:from-cyan-600 hover:to-blue-600 transition-all duration-300 transform hover:scale-105 shadow-lg overflow-hidden" id="button">
                            <!-- Text that shows by default -->
                            <span class="flex items-center justify-center gap-2 transition-opacity duration-200 opacity-100" id="button-text">
                                📁 Choose Files
                            </span>

                            <!-- Loader that shows during loading state -->
                            <span class="absolute inset-0 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-200 " id="button-loader">
                                <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>

                    <!-- File Type Support -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="feature-card rounded-lg p-3">
                            <div class="text-red-400 text-2xl mb-1">📄</div>
                            <div class="text-xs text-gray-400">Documents</div>
                        </div>
                        <div class="feature-card rounded-lg p-3">
                            <div class="text-green-400 text-2xl mb-1">🖼️</div>
                            <div class="text-xs text-gray-400">Images</div>
                        </div>
                        <div class="feature-card rounded-lg p-3">
                            <div class="text-purple-400 text-2xl mb-1">🎥</div>
                            <div class="text-xs text-gray-400">Videos</div>
                        </div>
                        <div class="feature-card rounded-lg p-3">
                            <div class="text-blue-400 text-2xl mb-1">📦</div>
                            <div class="text-xs text-gray-400">Archives</div>
                        </div>
                    </div>

                    <div class="text-sm text-gray-500 space-y-1">
                        <div>✓ Support for all file types • Max 10MB per file • Secure encryption</div>
                        <div>⚡ Lightning fast uploads • 🔒 End-to-end security • 🌐 Global CDN</div>
                    </div>
                </div>

                <!-- Upload Stats -->
                <div class="mt-8 grid grid-cols-3 gap-4">
                    <div class="stats-counter rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-cyan-400"><?php echo $number; ?></div>
                        <div class="text-xs text-gray-400">Files Uploaded</div>
                    </div>
                    <div class="stats-counter rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-blue-400">99.9%</div>
                        <div class="text-xs text-gray-400">Uptime</div>
                    </div>
                    <div class="stats-counter rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-purple-400">1K+</div>
                        <div class="text-xs text-gray-400">Happy Users</div>
                    </div>
                </div>

                <!-- Progress Area -->
                <div id="progress-area" class="mt-8 hidden">
                    <div class="section-blur rounded-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-medium flex items-center">
                                <svg class="w-5 h-5 mr-2 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                </svg>
                                Uploading files...
                            </span>
                            <span class="text-cyan-400 font-bold" id="progress-text">0%</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-3">
                            <div class="bg-gradient-to-r from-cyan-400 to-blue-500 h-3 rounded-full transition-all duration-500 shadow-lg" id="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stylish Divider -->
            <div class="my-20 flex items-center justify-center">
                <div class="flex-grow divider-line max-w-md"></div>
                <div class="mx-8 text-gray-400 font-medium">OR</div>
                <div class="flex-grow divider-line max-w-md"></div>
            </div>

            <!-- Receive Files Section -->
        </div>
    </section>
    <div class="max-w-4xl mx-auto text-center" id="receive-section">
        <div class="section-blur rounded-3xl p-8 md:p-12">
            <div class="mb-8">
                <div class="w-24 h-24 bg-gradient-to-r from-purple-500 to-cyan-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold mb-4 bg-gradient-to-r from-purple-400 to-cyan-400 bg-clip-text text-transparent">
                    Receive Files
                </h3>
                <p class="text-gray-400 mb-8 text-lg max-w-2xl mx-auto">
                    Get files sent to you by others. Enter your unique receive code or share your personal link.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-6">
                    <input id="uniq_code_inp"
                        type="text"
                        placeholder="Enter receive code..."
                        class="px-6 py-4 bg-gray-800/50 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20 transition-all w-full sm:w-80" />
                    <button id="button_r" class="receive-btn px-8 py-4 rounded-xl font-semibold text-white shadow-lg w-full sm:w-auto">
                        <div class="spinner"></div>
                        <span class="btn-text">📥 Receive Files</span>
                    </button>
                </div>

                <div class="text-sm text-gray-500">
                    💡 Don't have a code? <a href="#upload" class="text-cyan-400 hover:text-cyan-300 transition-colors">Request files from someone</a>
                </div>
            </div>

            <!-- Receive Features -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="feature-card rounded-xl p-6 text-center">
                    <div class="text-3xl mb-3">🔐</div>
                    <h4 class="font-semibold text-cyan-400 mb-2">Secure Transfer</h4>
                    <p class="text-gray-400 text-sm">All files are encrypted during transfer and storage</p>
                </div>
                <div class="feature-card rounded-xl p-6 text-center">
                    <div class="text-3xl mb-3">⚡</div>
                    <h4 class="font-semibold text-blue-400 mb-2">Instant Notification</h4>
                    <p class="text-gray-400 text-sm">Get notified immediately when files arrive</p>
                </div>
                <div class="feature-card rounded-xl p-6 text-center">
                    <div class="text-3xl mb-3">📱</div>
                    <h4 class="font-semibold text-purple-400 mb-2">Any Device</h4>
                    <p class="text-gray-400 text-sm">Access your files from any device, anywhere</p>
                </div>
            </div>
        </div>
    </div>



    <!-- Simple separator and receive button -->


    <!-- Features Section -->
    <section id="features" class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                    Why Choose Us?
                </h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                    Experience the perfect blend of security, speed, and simplicity in file sharing.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="section-blur rounded-xl p-8 text-center group hover:bg-gray-800/50 transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-lg flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">End-to-End Encryption</h3>
                    <p class="text-gray-400">Your files are encrypted with military-grade security, ensuring complete privacy and protection.</p>
                </div>

                <div class="section-blur rounded-xl p-8 text-center group hover:bg-gray-800/50 transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-blue-500 rounded-lg flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Lightning Fast</h3>
                    <p class="text-gray-400">Upload and share files at blazing speeds with our optimized global CDN infrastructure.</p>
                </div>

                <div class="section-blur rounded-xl p-8 text-center group hover:bg-gray-800/50 transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-400 to-pink-500 rounded-lg flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Easy Sharing</h3>
                    <p class="text-gray-400">Generate secure links instantly and share with anyone, anywhere, with customizable permissions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-20">
        <div class="container mx-auto px-6">
            <div class="section-blur rounded-2xl p-12">
                <div class="text-center mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                        Trusted by Users
                    </h2>
                    <p class="text-xl text-gray-400">
                        Join the growing community of users who trust us with their files.
                    </p>
                </div>

                <div class="grid md:grid-cols-4 gap-8 text-center">
                    <div class="group">
                        <div class="text-4xl md:text-5xl font-bold text-cyan-400 mb-2 counter" data-target="<?php echo $number; ?>">0</div>
                        <div class="text-gray-400">Files Uploaded</div>
                    </div>
                    <div class="group">
                        <div class="text-4xl md:text-5xl font-bold text-blue-400 mb-2 counter" data-target="<?php echo $size; ?>">0</div>
                        <div class="text-gray-400">MB Data Transferred</div>
                    </div>
                    <div class="group">
                        <div class="text-4xl md:text-5xl font-bold text-purple-400 mb-2 counter" data-target="99.9">0</div>
                        <div class="text-gray-400">% Uptime</div>
                    </div>
                    <div class="group">
                        <div class="text-4xl md:text-5xl font-bold text-green-400 mb-2 counter" data-target="150">0</div>
                        <div class="text-gray-400">Countries Servies</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-gray-800">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 00-2 2v1.816a2.03 2.03 0 00.877.72l3.654 2.195A3 3 0 017.5 9.5v.5H16a1 1 0 011 1v4a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">SendNow</span>
                    </div>
                    <p class="text-gray-400">The most secure and fastest way to share your files online.</p>
                </div>

                <div>
                    <h4 class="font-semibold mb-4 text-cyan-400">Product</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#home" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="#upload" class="hover:text-white transition-colors">Upload</a></li>
                        <li><a href="#receive-section" class="hover:text-white transition-colors">Receive</a></li>
                        <li><a href="about.php" class="hover:text-white transition-colors">About</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4 text-cyan-400">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="about.php" class="hover:text-white transition-colors">About</a></li>

                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4 text-cyan-400">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="mailto:sendnowofficials@gmail.com" class="hover:text-white transition-colors">Contact Us</a></li>

                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 SendNow. All rights reserved. Built with ❤️ for seamless file sharing.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById("button_r").addEventListener("click", function() {
            var uniq_code_inp = document.getElementById("uniq_code_inp").value;
            document.getElementById("button_r").classList.add("loading");
            document.getElementById("button_r").disabled = true;


            window.location.href = "reciveFiles/pin.php?code=" + uniq_code_inp;

            setTimeout(function() {
                document.getElementById("button_r").classList.remove("loading");
                document.getElementById("button_r").disabled = false;
            }, 4000);


        })
        fetch("backend/clean.php")
            .then(res => res.text())
            .then(console.log);
    </script>
    <script src="assest/js/script.js"></script>
    <script src="assest/js/hero.js"></script>
    <script src="assest/js/prgress.js"></script>
    <script src="assest/js/request.js"></script>
</body>

</html>