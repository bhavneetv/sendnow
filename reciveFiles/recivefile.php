<?php
require_once '../backend/clean.php';
require_once '../include/config.php';
session_start();


if (empty($_GET['code'])) {

    header("Location: ../index.php");
    exit();
}
$code = base64_encode($_GET['code']);

$sql = "SELECT * FROM files WHERE unique_code = '$code'";
$result = $db->query($sql);

if ($result->num_rows == 0) {
    echo "<script>alert('Invalid code');window.location.href = '../index.php';</script>";
    exit();
}
$row = $result->fetch_assoc();
$pin = $row['pin_code'];

if ($pin != "") {

    if (!empty($_SESSION['uniqe_code']) && base64_decode($_SESSION['uniqe_code']) == $_GET['code']) {
    } else {
        header("Location: pin.php?code=" . $_GET['code']);
        exit();
    }
} elseif ($pin == "") {
} else {
    header("Location: recivefile.php?code=" . $_GET['code']);
    exit();
}


$file = base64_decode($row['original_name']);
$uniq_code = $_GET['code'];
$pin = $row['pin_code'];
$size = $row['file_size'];
$size = $size / 1048576;
$size = round($size, 2);
$expire = $row['expiry_time'];
$type = base64_decode($row['type']);
$act = $row['status'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Files - SendNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/4.1.11/lib.min.js" integrity="sha512-tE7j0ptGYRtx0sHRAOkHNLAuIqVW7udzmjvNh1A6vIEnWUJnx7j7khwTEjemjDaauV+lHo0jEtdW8jn5weoxhw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../assest/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assest/favicon/favicon-32x32.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="../assest/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assest/favicon/site.webmanifest">
    <style>
        /* Background effects */
        .section-blur {
            background: rgba(30, 41, 59, 0.3);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(71, 85, 105, 0.3);
        }

        .nav-backdrop {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
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

        .file-icon-small {
            width: 48px;
            height: 48px;
        }

        .file-icon-list {
            width: 40px;
            height: 40px;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0891b2, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(6, 182, 212, 0.3);
        }

        .btn-secondary {
            background: rgba(71, 85, 105, 0.5);
            border: 1px solid rgba(148, 163, 184, 0.3);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(71, 85, 105, 0.7);
            border-color: rgba(148, 163, 184, 0.5);
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
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

        /* Pin input styling */
        .pin-input {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(71, 85, 105, 0.5);
            backdrop-filter: blur(10px);
        }

        .pin-input:focus {
            border-color: #06b6d4;
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
        }

        /* File item hover effects */
        .file-item {
            transition: all 0.3s ease;
        }

        .file-item:hover {
            background: rgba(71, 85, 105, 0.2);
            transform: translateY(-2px);
        }

        /* Progress bar */
        .progress-bar {
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            animation: progress-fill 2s ease-in-out;
        }

        @keyframes progress-fill {
            0% {
                width: 0%;
            }

            100% {
                width: 100%;
            }
        }

        /* Expire animation */
        @keyframes pulse-red {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .pulse-red {
            animation: pulse-red 2s ease-in-out infinite;
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
    <main class="relative z-10 pt-12 pb-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 bg-clip-text text-transparent">
                        Download Files
                    </h1>
                    <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                        Files are ready for download. Choose individual files or download all at once.
                    </p>
                </div>

                <!-- Expiration Notice (Always visible, changes based on status) -->
                <div id="expiration-notice" class="mb-8 text-center p-4 rounded-xl border">
                    <div class="flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium" id="expiration-text">Files expire in </span>
                    </div>
                    <p class="text-sm mt-2 opacity-80" id="expiration-subtitle">
                        Download them before they're automatically deleted
                    </p>
                </div>

                <!-- Main Content Container -->
                <div id="main-content">
                    <!-- Download All Section -->

                    <!-- Individual Files Section -->
                    <div class="section-blur rounded-3xl p-6 sm:p-8">
                        <h2 class="text-2xl font-bold text-cyan-400 mb-6">Download File</h2>

                        <div class="space-y-4" id="files-list">
                            <!-- File Item 1 -->
                            <div class="file-item p-4 bg-gray-800/30 rounded-xl border border-gray-700/30">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                    <!-- File Info -->
                                    <div class="flex items-center gap-4 flex-1 min-w-0">
                                        <div class="file-pdf rounded-lg file-icon-list flex items-center justify-center text-white font-bold text-xs shadow-lg flex-shrink-0" style="text-transform: uppercase">
                                            <?php echo $type; ?>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="font-semibold text-white truncate" title="presentation.pdf"><?php echo $file; ?></p>
                                            <p class="text-sm text-gray-400" style="text-transform: uppercase"><?php echo $type; ?> • <?php echo $size; ?> MB</p>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-2 w-full sm:w-auto" id="download-btn">
                                       <a href="download.php?code=<?php echo $uniq_code; ?>" class="btn-success px-4 py-2 rounded-lg font-medium text-white text-sm flex items-center gap-2 flex-1 sm:flex-none justify-center" i>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1"></path>
                                            </svg>
                                            Download
                                        </a>

                                    </div>
                                </div>
                            </div>

                            <!-- File Item 2 -->


                            <!-- File Item 3 -->

                        </div>
                    </div>
                </div>

            </div>

            <!-- Expired Content (Hidden by default) -->
            <div id="expired-content" class="hidden">
                <div class="section-blur rounded-3xl p-8 sm:p-12 text-center">
                    <div class="mb-6">
                        <svg class="w-24 h-24 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="text-3xl font-bold text-red-500 mb-4">Files Have Expired</h2>
                        <p class="text-xl text-gray-300 mb-6">
                            These files have been automatically deleted for security purposes.
                        </p>
                        <p class="text-gray-400 mb-8">
                            Files are only available for a limited time after sharing. Please contact the sender for a new link.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button
                            onclick="goHome()"
                            class="btn-primary px-8 py-4 rounded-xl font-semibold text-white shadow-lg">
                            🏠 Go to Home
                        </button>
                        <button
                            onclick="requestNewLink()"
                            class="btn-secondary px-8 py-4 rounded-xl font-semibold text-gray-200">
                            📧 Request New Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    <!-- Download Progress Modal -->


    <script>
        // Simulate file expiration - Set to false to test expired state
        let filesExpired = false;

        // Initialize page based on expiration status
        function initializePage() {

            updateExpirationNotice();


            if (filesExpired) {
                showExpiredContent();
            }


            let status = "<?php echo $act; ?>";
            if (status == "expired") {
                filesExpired = true;
                showExpiredContent();
            }
        }

        // Update expiration notice
        function updateExpirationNotice() {
            const notice = document.getElementById('expiration-notice');
            const text = document.getElementById('expiration-text');
            const subtitle = document.getElementById('expiration-subtitle');

            if (filesExpired) {
                notice.className = 'mb-8 text-center p-4 rounded-xl border bg-red-500/10 border-red-400/30 pulse-red';
                text.textContent = 'Files Have Expired';
                text.className = 'font-bold text-red-400';
                subtitle.textContent = 'These files are no longer available for download';
                subtitle.className = 'text-sm mt-2 text-red-300/80';
            } else {
                notice.className = 'mb-8 text-center p-4 rounded-xl border bg-amber-500/10 border-amber-400/30';
                // text.textContent = 'Files expire in 2 hours 45 minutes';
                text.className = 'font-medium text-amber-400';
                subtitle.textContent = 'Download them before they\'re automatically deleted';
                subtitle.className = 'text-sm mt-2 text-amber-300/80 opacity-80';
            }
        }

        // Show expired content and hide main content
        function showExpiredContent() {
            document.getElementById('main-content').classList.add('hidden');
            document.getElementById('expired-content').classList.remove('hidden');
        }

       


        // Navigation functions
        function goHome() {
            window.location.href = '../index.php';
        }
        function requestNewLink() {
            window.location.href = '../index.php#upload';
        }



        // Initialize page when loaded
        document.addEventListener('DOMContentLoaded', initializePage);


        function getTimeLeft(targetDateTime) {
            // Parse the target date
            const targetDate = new Date(targetDateTime.replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$3-$2-$1'));

            // Get current date
            const now = new Date();

            // Calculate difference in seconds
            let diffInSeconds = Math.floor((targetDate - now) / 1000);

            // If time is already passed
            if (diffInSeconds <= 0) {
                return "Expired";
            }

            // Calculate hours and minutes
            const hours = Math.floor(diffInSeconds / 3600);
            diffInSeconds %= 3600;
            const minutes = Math.ceil(diffInSeconds / 60); // Using ceil to round up minutes

            // Format the time string
            let timeString = '';
            if (hours > 0) {
                timeString += `${hours} hour${hours !== 1 ? 's' : ''} `;
            }
            timeString += `${minutes} minute${minutes !== 1 ? 's' : ''}`;

            return timeString;
        }

        // For auto-updating time left
        function updateTimeLeft() {
            let time = "<?php echo $expire; ?>";
            let timeLeft = getTimeLeft(time);
            const expirationElement = document.getElementById('expiration-text');
            expirationElement.textContent = "Files expire in "+timeLeft;

            if (timeLeft === "Expired") {
                expirationElement.classList.add('text-red-500');
                expirationElement.textContent = "Expired";
                document.getElementById('download-btn').style.display = 'none';
                filesExpired = true;
                showExpiredContent(); 
            }
        }

        function runExpire(){
            let time = "<?php echo $act; ?>";
            if(time === "expired"){
                document.getElementById('download-btn').style.display = 'none';
                filesExpired = true;
                showExpiredContent();
                

            }
        }

        // Update every minute (60000ms) instead of every second since we're not showing seconds
        setInterval(updateTimeLeft, 60000);
        setInterval(runExpire, 60000 *15);

        // Initial call to display the time immediately
        updateTimeLeft();
        runExpire();
    </script>
</body>

</html>