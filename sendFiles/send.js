function getTimeLeft(targetDateTime) {
    // Parse the target date
    const targetDate = new Date(targetDateTime.replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$3-$2-$1'));

    // Get current date
    const now = new Date();

    // Calculate difference in seconds
    let diffInSeconds = Math.floor((targetDate - now) / 1000);

    // If time is already passed
    if (diffInSeconds <= 0) {
        return "00:00:00";
    }

    // Calculate hours, minutes, seconds
    const hours = Math.floor(diffInSeconds / 3600);
    diffInSeconds %= 3600;
    const minutes = Math.floor(diffInSeconds / 60);
    const seconds = diffInSeconds % 60;

    // Format to 2 digits
    const format = (num) => num.toString().padStart(2, '0');

    return `${format(hours)}:${format(minutes)}:${format(seconds)}`;
}


// For auto-updating time left (e.g., in a countdown)
function updateTimeLeft() {
    let time = document.getElementById('countdown').getAttribute('time');

    let timeLeft = getTimeLeft(time);
    document.getElementById('countdown').textContent = timeLeft;
    if(timeLeft == "00:00:00") {
        document.getElementById('countdown').textContent = "Expired";
        document.getElementById('countdown').classList.add('text-red-500');
    }
}

// Update every second
setInterval(updateTimeLeft, 1000);


// Initial update
updateTimeLeft();
