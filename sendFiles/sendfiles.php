<?php
// include 'header.php';
require '../include/config.php';
require_once '../backend/clean.php';
session_start();

if (!isset($_COOKIE['code'])) {
    header("Location: ../index.php");
    exit();
}
$code = $_COOKIE['code'];
$code1 = base64_encode($code);

$query = "SELECT * FROM files WHERE unique_code = '$code1' ";
$result = mysqli_query($db, $query);
$url = "https://" . $_SERVER['HTTP_HOST'] . '/reciveFiles/pin.php?code=' . $code;


if (mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);
    $files = base64_decode($row['original_name']);
    $unique_code = base64_decode($row['unique_code']);
    $password = $row['pin_code'];
    $expiry = $row['expiry_time'];
    $type = base64_decode($row['type']);
    $size = $row['file_size'];
    $size = $size / 1048576;
    $size = round($size, 2);
    if ($password == "") {
        $pas = "block";
        $pas_l = "none";
    } else {
        $pas = "none";
        $pas_l = "block";
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Files - SendNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/4.1.11/lib.min.js" integrity="sha512-tE7j0ptGYRtx0sHRAOkHNLAuIqVW7udzmjvNh1A6vIEnWUJnx7j7khwTEjemjDaauV+lHo0jEtdW8jn5weoxhw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../assest/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assest/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assest/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assest/favicon/site.webmanifest">

    <style>
        /* File icons */
        .file-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .file-pdf {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        }

        .file-jpg {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .file-doc {
            background: linear-gradient(135deg, #45b7d1 0%, #96c5eb 100%);
        }

        .file-zip {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .file-mp4 {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        }

        /* Floating background files */
        .floating-file {
            width: 40px;
            height: 40px;
            animation: float 6s ease-in-out infinite;
            opacity: 0.1;
        }

        .floating-slow {
            animation-duration: 8s;
            animation-delay: 0s;
        }

        .floating-medium {
            animation-duration: 6s;
            animation-delay: 2s;
        }

        .floating-fast {
            animation-duration: 4s;
            animation-delay: 1s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
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

        /* QR Code container */
        .qr-container {
            background: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Input styles */
        .custom-input {
            background: rgba(31, 41, 55, 0.5);
            border: 1px solid rgba(75, 85, 99, 0.5);
            transition: all 0.3s ease;
        }

        .custom-input:focus {
            background: rgba(31, 41, 55, 0.8);
            border-color: #06b6d4;
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
        }

        /* Countdown timer */
        .countdown-timer {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

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

        .btn-primary.loading .spinner {
            display: inline-block;
        }

        .btn-primary.loading .btn-text {
            display: none;
        }

        .btn-primary:disabled {
            cursor: not-allowed;
            opacity: 0.8;
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
        <div class="max-w-2xl mx-auto">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold mb-2 bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 bg-clip-text text-transparent">
                    Your Files Are Ready
                </h1>
                <p class="text-gray-400">Share them securely with the options below</p>
            </div>

            <!-- Main Card -->
            <div class="section-blur rounded-2xl p-6 space-y-8">

                <!-- File Information -->
                <div>
                    <h2 class="text-lg font-semibold mb-4 text-cyan-400 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Files to Share
                    </h2>
                    <div class="space-y-3">
                        <div class="flex items-center gap-4 p-3 bg-gray-800/30 rounded-xl">
                            <div class="file-icon file-pdf rounded-lg flex items-center justify-center text-white font-bold text-xs" style="text-transform: uppercase;">
                                <?php echo $type; ?>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium"><?php echo $files; ?></p>
                                <p class="text-sm text-gray-400"><?php echo $size; ?> MB</p>
                            </div>
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: <?php echo $pas_l; ?>;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>





                    </div>
                </div>

                <!-- Time Expiration -->
                <div class="text-center p-4 bg-gradient-to-r from-amber-500/20 to-orange-500/20 rounded-xl border border-amber-400/30">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-amber-400 font-medium">Expires in</span>
                    </div>
                    <div class="countdown-timer text-2xl font-bold" id="countdown" time="<?php echo $expiry; ?>"><?php echo $expiry; ?></div>
                    <p class="text-amber-300/80 text-sm mt-1">Files will be automatically deleted</p>
                </div>

                <!-- QR Code -->
                <div class="text-center">
                    <h3 class="text-lg font-semibold mb-4 text-purple-400">Quick Access</h3>
                    <div class="qr-container inline-block mb-4">
                        <canvas id="qr-code" class="mx-auto"></canvas>
                    </div>
                    <p class="text-sm text-gray-400">Scan QR code to access files instantly</p>
                </div>

                <!-- Share Link -->
                <div>
                    <h3 class="text-lg font-semibold mb-3 text-blue-400">Share Link</h3>
                    <div class="flex gap-2">
                        <input
                            type="text"
                            id="share-link"
                            value="<?php echo $url ?>"
                            readonly
                            class="flex-1 px-4 py-3 custom-input rounded-xl text-white focus:outline-none" />
                        <button
                            onclick="copyLink()"
                            class="btn-secondary px-4 py-3 rounded-xl hover:bg-gray-700/50 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Unique Code -->
                <div class="text-center">
                    <div class="bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl p-6 border border-cyan-400/30">
                        <h3 class="text-sm text-gray-400 mb-2">Failed to scan QR? Enter this code:</h3>
                        <div class="text-3xl font-bold text-cyan-400 tracking-wider" id="unique-code"><?php echo $unique_code; ?></div>
                    </div>
                </div>

                <!-- Password Protection -->
                <div style="display: <?php echo $pas; ?>;">
                    <h3 class="text-lg font-semibold mb-3 text-red-400 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Set Access Password
                    </h3>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input
                            type="password"
                            id="access-password"
                            placeholder="Enter password (optional)"
                            class="flex-1 px-4 py-3 custom-input rounded-xl text-white placeholder-gray-400 focus:outline-none" />
                        <button
                            onclick="setPassword()"
                            class="btn-primary px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-300" id="button-text">
                            🔒 Set Password
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Recipients will need this password to access files</p>
                </div>

                <!-- Email Share Button -->
                <div class="text-center">
                    <button
                        onclick="openEmailModal()"
                        class="btn-primary px-8 py-4 rounded-xl font-semibold text-white shadow-lg hover:shadow-xl transition-all duration-300 inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        📧 Send via Email
                    </button>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button
                        onclick="shareMore()"
                        class="btn-primary flex-1 px-6 py-3 rounded-xl font-semibold text-white shadow-lg hover:shadow-xl transition-all duration-300">
                        🚀 Share More Files
                    </button>
                    <button
                        onclick="goHome()"
                        class="btn-secondary flex-1 px-6 py-3 rounded-xl font-semibold text-gray-200 hover:bg-gray-700/50 transition-all duration-300">
                        🏠 Go Home
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Email Share Modal -->
    <div id="email-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="section-blur rounded-2xl p-6 sm:p-8 max-w-md w-full mx-4 relative">
            <!-- Close Button -->
            <button
                onclick="closeEmailModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors duration-200 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Header -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Send Files via Email</h3>
                <p class="text-gray-400 text-sm">Share your files with someone via email</p>
            </div>

            <!-- Form -->
            <form id="email-share-form" class="space-y-4">
                <!-- Recipient Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        📧 Recipient Email
                    </label>
                    <input
                        type="email"
                        id="recipient-email"
                        placeholder="Enter recipient's email"
                        required
                        class="custom-input w-full px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none" />
                </div>

                <!-- Message -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        💬 Message (Optional)
                    </label>
                    <textarea
                        id="email-message"
                        placeholder="Add a personal message..."
                        rows="4"
                        class="custom-input w-full px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none resize-none"></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button
                        type="button"
                        onclick="closeEmailModal()"
                        class="btn-secondary flex-1 px-6 py-3 rounded-xl font-medium text-gray-200 order-2 sm:order-1">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="btn-primary flex-1 px-6 py-3 rounded-xl font-semibold text-white shadow-lg order-1 sm:order-2"
                        id="send-email">
                        <div class="spinner"></div>
                        <span class="btn-text">📧 Send Email</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        /**
         * Calculate time left between current time and target date
         * @param {string} targetDateTime - Target date in format 'YYYY-MM-DD HH:MM:SS'
         * @returns {string} Time left in format 'HH:MM:SS'
         */


        // Generate QR Code
        function generateQR() {
            const qr = new QRious({
                element: document.getElementById('qr-code'),
                value: document.getElementById('share-link').value,
                size: 170,
                foreground: '#1f2937',
                background: '#ffffff'
            });
        }

        // Copy link function
        function copyLink(event) {
    const shareLink = document.getElementById('share-link');

    // Only works for input or textarea
    if (shareLink && (shareLink.tagName === 'INPUT' || shareLink.tagName === 'TEXTAREA')) {
        shareLink.select();
        shareLink.setSelectionRange(0, 99999); // For mobile devices

        navigator.clipboard.writeText(shareLink.value).then(() => {
            // Visual feedback
            const button = event.target.closest('button');
            const originalHTML = button.innerHTML;
            button.innerHTML = '✅ Copied!';
            button.classList.add('bg-green-600');
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('bg-green-600');
            }, 2000);
        }).catch((err) => {
            console.error('Failed to copy: ', err);
        });
    }
}



        // Email modal functions
        function openEmailModal() {
            document.getElementById('email-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEmailModal() {
            document.getElementById('email-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('email-share-form').reset();
        }


        // Navigation functions
        function shareMore() {
            // Redirect to upload page
            window.location.href = '../index.php#upload';
        }

        function goHome() {
            // Redirect to home page
            window.location.href = '../index.php';
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            generateQR();

        });
    </script>
    <script src="send.js"></script>
    <script src="pass.js"></script>
</body>

</html>