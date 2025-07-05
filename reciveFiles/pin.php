<?php


require("../include/config.php");

if (empty($_GET['code'])) {

    header("Location: ../index.php");
    exit();
}
$code2 = base64_encode($_GET['code']);

$sql = "SELECT * FROM files WHERE unique_code = '$code2'";
$result = $db->query($sql);

if ($result->num_rows == 0) {
    echo "<script>alert('Invalid code');window.location.href = '../index.php';</script>";
    exit();
}

else {
    $sql1 = "SELECT * FROM files WHERE unique_code = '$code2'";
    $result1 = $db->query($sql1);
    $row = $result1->fetch_assoc();
    $pin = $row['pin_code'];
   
    if($pin == ""){
            //echo $_GET['code'];
        header("Location: recivefile.php?code=" . $_GET['code']);
       exit();
    }
}





?>








<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter PIN - SendNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/4.1.11/lib.min.js" integrity="sha512-tE7j0ptGYRtx0sHRAOkHNLAuIqVW7udzmjvNh1A6vIEnWUJnx7j7khwTEjemjDaauV+lHo0jEtdW8jn5weoxhw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../assest/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assest/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assest/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assest/favicon/site.webmanifest">
   
   <style>
        /* Background effects */
        .section-blur {
            background: rgba(30, 41, 59, 0.3);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(71, 85, 105, 0.3);
        }

        /* Floating animations */
        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-10px) rotate(2deg);
            }

            66% {
                transform: translateY(5px) rotate(-1deg);
            }
        }

        @keyframes floating-slow {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(3deg);
            }
        }

        @keyframes floating-fast {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            25% {
                transform: translateY(-8px) rotate(1deg);
            }

            75% {
                transform: translateY(8px) rotate(-2deg);
            }
        }

        .floating-animation {
            animation: floating 6s ease-in-out infinite;
        }

        .floating-slow {
            animation: floating-slow 8s ease-in-out infinite;
        }

        .floating-fast {
            animation: floating-fast 4s ease-in-out infinite;
        }

        /* File icons */
        .file-icon {
            width: 48px;
            height: 48px;
            position: absolute;
            opacity: 0.7;
        }

        /* File type colors */
        .file-pdf {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .file-jpg {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .file-doc {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .file-zip {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .file-mp4 {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .file-txt {
            background: linear-gradient(135deg, #6b7280, #4b5563);
        }

        .file-png {
            background: linear-gradient(135deg, #f97316, #ea580c);
        }

        /* PIN input styling */
        .pin-input {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(71, 85, 105, 0.5);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .pin-input:focus {
            border-color: #06b6d4;
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
            background: rgba(30, 41, 59, 0.7);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            transition: all 0.3s ease;
        }

        .btn-primary:hover:not(:disabled) {
            background: linear-gradient(135deg, #0891b2, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(6, 182, 212, 0.3);
        }

        .btn-primary:disabled {
            background: rgba(71, 85, 105, 0.5);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-show {
            background: rgba(71, 85, 105, 0.5);
            border: 1px solid rgba(148, 163, 184, 0.3);
            transition: all 0.3s ease;
        }

        .btn-show:hover {
            background: rgba(71, 85, 105, 0.7);
            border-color: rgba(148, 163, 184, 0.5);
        }

        /* Lock icon animation */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        /* Error state */
        .error-state {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }

        /* Success state */
        .success-state {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }
    </style>
</head>

<body class="bg-gray-900 text-white min-h-screen overflow-x-hidden">

    <!-- Floating Background Files -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <!-- PDF Files -->
        <div class="absolute top-20 left-10 floating-slow">
            <div class="file-icon file-pdf rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-lg">
                PDF
            </div>
        </div>
        <div class="absolute top-2/3 right-16 floating-animation">
            <div class="file-icon file-pdf rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-lg">
                PDF
            </div>
        </div>

        <!-- JPG Files -->
        <div class="absolute top-1/3 right-20 floating-fast">
            <div class="file-icon file-jpg rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-lg">
                JPG
            </div>
        </div>
        <div class="absolute bottom-1/4 left-16 floating-slow">
            <div class="file-icon file-jpg rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-lg">
                JPG
            </div>
        </div>

        <!-- DOC Files -->
        <div class="absolute top-1/2 left-8 floating-animation">
            <div class="file-icon file-doc rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-lg">
                DOC
            </div>
        </div>
        <div class="absolute top-16 right-1/3 floating-fast">
            <div class="file-icon file-doc rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-lg">
                DOC
            </div>
        </div>

        <!-- ZIP Files -->
        <div class="absolute bottom-20 right-1/4 floating-slow">
            <div class="file-icon file-zip rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-lg">
                ZIP
            </div>
        </div>
        <div class="absolute top-3/4 left-1/4 floating-animation">
            <div class="file-icon file-zip rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-lg">
                ZIP
            </div>
        </div>

        <!-- MP4 Files -->
        <div class="absolute top-40 left-1/2 floating-fast hidden sm:block">
            <div class="file-icon file-mp4 rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-lg">
                MP4
            </div>
        </div>
        <div class="absolute bottom-32 right-1/3 floating-slow hidden md:block">
            <div class="file-icon file-mp4 rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-lg">
                MP4
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="relative z-10 min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md">
            <!-- PIN Entry Container -->
            <div class="section-blur rounded-3xl p-6 sm:p-8">
                <!-- Lock Icon -->
                <div class="text-center mb-6">
                    <div id="lock-icon" class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl sm:text-3xl font-bold mb-3 bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 bg-clip-text text-transparent">
                        Password Protected
                    </h1>
                    <p class="text-gray-300 text-sm sm:text-base">
                        This file is password protected. Enter the PIN to access the download.
                    </p>
                </div>

                <!-- PIN Input Form -->
                <form id="pin-form" class="space-y-6">
                    <!-- PIN Input Field -->
                    <div class="relative">
                        <label for="pin-input" class="block text-sm font-medium text-gray-300 mb-2">
                            Enter PIN
                        </label>
                        <div class="relative">
                            <input
                            un_code="<?php echo base64_decode($code2); ?>"
                                type="password"
                                id="pin-input"
                                name="pin"
                                class="pin-input w-full px-4 py-3 sm:py-4 text-lg rounded-xl text-white placeholder-gray-400 focus:outline-none pr-12"
                                placeholder="Enter your PIN"
                                maxlength="20"
                                required>
                            <button
                                type="button"
                                id="show-pin-btn"
                                class="btn-show absolute right-3 top-1/2 transform -translate-y-1/2 px-3 py-1.5 rounded-lg text-sm font-medium text-gray-300 flex items-center gap-1"
                                onclick="togglePinVisibility()">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span id="show-text">Show</span>
                            </button>
                        </div>

                        <!-- Error Message -->
                        <div id="error-message" class="hidden mt-2 text-red-400 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span id="error-text">Incorrect PIN. Please try again.</span>
                        </div>

                        <!-- Success Message -->
                        <div id="success-message" class="hidden mt-2 text-green-400 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>PIN verified successfully!</span>
                        </div>
                    </div>

                    <!-- Next Button -->
                    <button
                        type="submit"
                        id="next-btn"
                        class="btn-primary w-full px-6 py-3 sm:py-4 rounded-xl font-semibold text-white text-lg shadow-lg flex items-center justify-center gap-3">
                        <span id="btn-text">Next</span>
                        <svg id="btn-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>

                        <!-- Loading Spinner (Hidden by default) -->
                        <svg id="loading-spinner" class="hidden animate-spin w-5 h-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>

                <!-- Help Text -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-400">
                        Don't have the PIN? Contact the person who shared this file with you.
                    </p>
                </div>
            </div>

            <!-- Additional Security Info -->
            <div class="mt-6 text-center">
                <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span>Secured by SendNow</span>
                </div>
            </div>
        </div>
    </main>

    <script>
       
    </script>
    <script src="backend/pincheck.js"></script>
</body>

</html>