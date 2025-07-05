<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - SendNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/4.1.11/lib.min.js" integrity="sha512-tE7j0ptGYRtx0sHRAOkHNLAuIqVW7udzmjvNh1A6vIEnWUJnx7j7khwTEjemjDaauV+lHo0jEtdW8jn5weoxhw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="assest/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assest/favicon/favicon-32x32.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="assest/favicon/favicon-16x16.png">
    <link rel="manifest" href="assest/favicon/site.webmanifest">
    <style>
        /* File icons */
        .file-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .file-pdf { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%); }
        .file-jpg { background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%); }
        .file-doc { background: linear-gradient(135deg, #45b7d1 0%, #96c5eb 100%); }
        .file-zip { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .file-mp4 { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); }

        /* Floating background files */
        .floating-file {
            width: 40px;
            height: 40px;
            animation: float 6s ease-in-out infinite;
            opacity: 0.1;
        }
        
        .floating-slow { animation-duration: 8s; animation-delay: 0s; }
        .floating-medium { animation-duration: 6s; animation-delay: 2s; }
        .floating-fast { animation-duration: 4s; animation-delay: 1s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Background blur effect */
        .section-blur {
            background: rgba(17, 24, 39, 0.8);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }

        /* Button styles */
        .btn-primary {
            background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .btn-secondary {
            background: rgba(75, 85, 99, 0.5);
            border: 1px solid rgba(156, 163, 175, 0.3);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(75, 85, 99, 0.7);
        }

        /* Step cards */
        .step-card {
            background: rgba(31, 41, 55, 0.5);
            border: 1px solid rgba(75, 85, 99, 0.3);
            transition: all 0.3s ease;
        }

        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-color: rgba(6, 182, 212, 0.5);
        }

        /* Progress line */
        .progress-line {
            background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
            height: 3px;
            border-radius: 2px;
        }

        /* Animated icons */
        .animated-icon {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Feature highlights */
        .feature-highlight {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(59, 130, 246, 0.1) 50%, rgba(139, 92, 246, 0.1) 100%);
            border: 1px solid rgba(6, 182, 212, 0.3);
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen overflow-x-hidden">
    
    <!-- Floating Background Files -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-20 left-10 floating-file file-pdf rounded-lg floating-slow"></div>
        <div class="absolute top-2/3 right-16 floating-file file-jpg rounded-lg floating-medium"></div>
        <div class="absolute top-1/3 right-20 floating-file file-doc rounded-lg floating-fast"></div>
        <div class="absolute bottom-1/4 left-16 floating-file file-zip rounded-lg floating-slow"></div>
        <div class="absolute top-1/2 left-8 floating-file file-mp4 rounded-lg floating-medium"></div>
        <div class="absolute top-16 right-1/3 floating-file file-pdf rounded-lg floating-fast"></div>
        <div class="absolute bottom-20 right-1/4 floating-file file-jpg rounded-lg floating-slow"></div>
        <div class="absolute top-3/4 left-1/4 floating-file file-doc rounded-lg floating-medium"></div>
    </div>

    <!-- Main Content -->
    <main class="relative z-10 py-8 px-4">
        <div class="max-w-4xl mx-auto">
            
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 gradient-text">
                    About SendNow
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    The simplest way to share files securely with anyone, anywhere. 
                    Fast, reliable, and completely free.
                </p>
            </div>

            <!-- Mission Statement -->
            <div class="section-blur rounded-2xl p-8 mb-12">
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 animated-icon">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-4 text-cyan-400">Our Mission</h2>
                    <p class="text-lg text-gray-300 leading-relaxed">
                        We believe file sharing should be simple, secure, and accessible to everyone. 
                        SendNow eliminates the complexity of traditional file sharing methods by providing 
                        a streamlined experience that just works.
                    </p>
                </div>
            </div>

            <!-- How It Works -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-center mb-8 gradient-text">How SendNow Works</h2>
                
                <!-- Steps Container -->
                <div class="space-y-8">
                    <!-- Step 1 -->
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="w-full md:w-1/2">
                            <div class="step-card rounded-2xl p-8 h-full">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        1
                                    </div>
                                    <h3 class="text-2xl font-bold text-green-400">Upload Your Files</h3>
                                </div>
                                <p class="text-gray-300 text-lg leading-relaxed">
                                    Simply drag and drop your files or click to browse. We support all file types 
                                    and sizes up to 10MB. Your files are encrypted immediately upon upload for 
                                    maximum security.
                                </p>
                                <div class="mt-6 flex gap-2">
                                    <div class="file-icon file-pdf rounded-lg flex items-center justify-center text-white font-bold text-xs">PDF</div>
                                    <div class="file-icon file-jpg rounded-lg flex items-center justify-center text-white font-bold text-xs">JPG</div>
                                    <div class="file-icon file-doc rounded-lg flex items-center justify-center text-white font-bold text-xs">DOC</div>
                                    <div class="file-icon file-zip rounded-lg flex items-center justify-center text-white font-bold text-xs">ZIP</div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 flex justify-center">
                            <div class="w-32 h-32 bg-gradient-to-r from-green-400 to-blue-500 rounded-3xl flex items-center justify-center animated-icon">
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Line -->
                    <div class="flex justify-center">
                        <div class="progress-line w-24"></div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col md:flex-row-reverse items-center gap-8">
                        <div class="w-full md:w-1/2">
                            <div class="step-card rounded-2xl p-8 h-full">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        2
                                    </div>
                                    <h3 class="text-2xl font-bold text-purple-400">Get Unique Code</h3>
                                </div>
                                <p class="text-gray-300 text-lg leading-relaxed">
                                    Once uploaded, your files are assigned a unique random code. This code serves as 
                                    your secure access key, ensuring only those with the code can access your files. 
                                    No accounts or sign-ups required.
                                </p>
                                <div class="mt-6 bg-gradient-to-r from-purple-500/20 to-pink-500/20 rounded-xl p-4 border border-purple-400/30">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-purple-400 tracking-wider">ABC123XYZ</div>
                                        <p class="text-sm text-gray-400 mt-1">Example unique code</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 flex justify-center">
                            <div class="w-32 h-32 bg-gradient-to-r from-purple-400 to-pink-500 rounded-3xl flex items-center justify-center animated-icon">
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Line -->
                    <div class="flex justify-center">
                        <div class="progress-line w-24"></div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="w-full md:w-1/2">
                            <div class="step-card rounded-2xl p-8 h-full">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-12 h-12 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        3
                                    </div>
                                    <h3 class="text-2xl font-bold text-cyan-400">Share the Link</h3>
                                </div>
                                <p class="text-gray-300 text-lg leading-relaxed">
                                    Share your unique link via email, text, or any messaging platform. Recipients 
                                    can access files instantly using the link or by entering the unique code. 
                                    No downloads or installations required.
                                </p>
                                <div class="mt-6 flex gap-3">
                                    <div class="bg-blue-500/20 p-3 rounded-xl flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-sm text-blue-300">Email</span>
                                    </div>
                                    <div class="bg-green-500/20 p-3 rounded-xl flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <span class="text-sm text-green-300">Text</span>
                                    </div>
                                    <div class="bg-purple-500/20 p-3 rounded-xl flex items-center gap-2">
                                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                        <span class="text-sm text-purple-300">Link</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 flex justify-center">
                            <div class="w-32 h-32 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-3xl flex items-center justify-center animated-icon">
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="section-blur rounded-2xl p-8 mb-12">
                <h2 class="text-3xl font-bold text-center mb-8 gradient-text">Why Choose SendNow?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="feature-highlight rounded-xl p-6 text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-green-400">Secure & Private</h3>
                        <p class="text-gray-300">End-to-end encryption ensures your files remain private and secure.</p>
                    </div>
                    
                    <div class="feature-highlight rounded-xl p-6 text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-purple-400">Lightning Fast</h3>
                        <p class="text-gray-300">Upload and share files in seconds with our optimized infrastructure.</p>
                    </div>
                    
                    <div class="feature-highlight rounded-xl p-6 text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-cyan-400">Completely Free</h3>
                        <p class="text-gray-300">No hidden fees, no subscriptions. Share files without any cost.</p>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center mb-12">
                <a href="index.php" class="btn-primary px-8 py-4 rounded-xl font-semibold text-white text-lg shadow-lg hover:shadow-xl transition-all duration-300 inline-flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                    </svg>
                    Start Sharing Files Now
                </a>
            </div>

            <!-- Footer -->
            <div class="section-blur rounded-2xl p-8 text-center">
                <div class="mb-4">
                    <h3 class="text-2xl font-bold gradient-text mb-2">SendNow</h3>
                    <p class="text-gray-400">Simple. Secure. Free.</p>
                </div>
                <div class="border-t border-gray-700 pt-4">
                    <p class="text-gray-500 text-sm">
                        Designed by <span class="text-cyan-400 font-medium">Claude AI</span> • 
                        Made with <span class="text-red-400">❤️</span> by <span class="text-purple-400 font-medium">Bhavneet Verma</span>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <script>
      

        // Add smooth scrolling for better UX
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Apply animation to step cards
            document.querySelectorAll('.step-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
</body>
</html>