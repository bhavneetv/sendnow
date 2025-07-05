let attempts = 0;
const maxAttempts = 3;
const correctPin = "1234"; // Demo PIN - in real app this would be validated server-side

// Toggle PIN visibility
function togglePinVisibility() {
  const pinInput = document.getElementById("pin-input");
  const eyeIcon = document.getElementById("eye-icon");
  const showText = document.getElementById("show-text");

  if (pinInput.type === "password") {
    pinInput.type = "text";
    showText.textContent = "Hide";
    eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
        `;
  } else {
    pinInput.type = "password";
    showText.textContent = "Show";
    eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
  }
}

// Handle PIN form submission
function handlePinSubmit(res,uniq_code) {
  // Example string
  const fullString = res;

  // Split the string at the colon
  const [firstPart, secondPart] = fullString.split(";");

  

  const pinInput = document.getElementById("pin-input");
  const nextBtn = document.getElementById("next-btn");
  const btnText = document.getElementById("btn-text");
  const btnIcon = document.getElementById("btn-icon");
  const loadingSpinner = document.getElementById("loading-spinner");
  const errorMessage = document.getElementById("error-message");
  const successMessage = document.getElementById("success-message");
  const lockIcon = document.getElementById("lock-icon");

  const enteredPin = pinInput.value.trim();

  // Clear previous states
  hideMessages();
  pinInput.classList.remove("error-state", "success-state");

  // Validate PIN
  if (!enteredPin) {
    showError("Please enter a PIN");
    pinInput.focus();
    return;
  }

  // Show loading state
  showLoadingState(nextBtn, btnText, btnIcon, loadingSpinner);

  // Simulate API call delay
  setTimeout(() => {
    hideLoadingState(nextBtn, btnText, btnIcon, loadingSpinner);

    if (firstPart === secondPart) {
      // Success
      showSuccess();
      pinInput.classList.add("success-state");

      // Update lock icon to unlocked
      lockIcon.innerHTML = `
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                    </svg>
                </div>
            `;

      // Redirect after success
      setTimeout(() => {
        // In a real app, you would redirect to the download page
       
        window.location.href = 'recivefile.php?code='+uniq_code;
      }, 1100);
    } else {
      // Error
      attempts++;
      pinInput.classList.add("error-state");
      lockIcon.classList.add("shake");

      setTimeout(() => {
        lockIcon.classList.remove("shake");
      }, 500);

      if (attempts >= maxAttempts) {
        showError(`Too many incorrect attempts. Please try again later.`);
        nextBtn.disabled = true;
        pinInput.disabled = true;
      } else {
        showError(
          `Incorrect PIN. ${maxAttempts - attempts} attempt${
            maxAttempts - attempts === 1 ? "" : "s"
          } remaining.`
        );
      }

      // Clear the input
      pinInput.value = "";
      pinInput.focus();
    }
  }, 1500);
}

// Show loading state
function showLoadingState(btn, text, icon, spinner) {
  btn.disabled = true;
  text.textContent = "Verifying...";
  icon.classList.add("hidden");
  spinner.classList.remove("hidden");
}

// Hide loading state
function hideLoadingState(btn, text, icon, spinner) {
  btn.disabled = false;
  text.textContent = "Next";
  icon.classList.remove("hidden");
  spinner.classList.add("hidden");
}

// Show error message
function showError(message) {
  const errorMessage = document.getElementById("error-message");
  const errorText = document.getElementById("error-text");

  errorText.textContent = message;
  errorMessage.classList.remove("hidden");
}

// Show success message
function showSuccess() {
  const successMessage = document.getElementById("success-message");
  successMessage.classList.remove("hidden");
}

// Hide all messages
function hideMessages() {
  document.getElementById("error-message").classList.add("hidden");
  document.getElementById("success-message").classList.add("hidden");
}

// Auto-focus on PIN input when page loads
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("pin-input").focus();
});

// Clear error state when user starts typing
document.getElementById("pin-input").addEventListener("input", function () {
  this.classList.remove("error-state");
  hideMessages();
});

// Allow Enter key to submit form
document.getElementById("pin-input").addEventListener("keypress", function (e) {
  if (e.key === "Enter") {
    document.getElementById("pin-form").dispatchEvent(new Event("submit"));
  }
});

document.getElementById("next-btn").addEventListener("click", function (event) {
  event.preventDefault();
  setPass();
});

function setPass() {
  var uniq_code = $("#pin-input").attr("un_code");
  $.ajax({
    url: "backend/pinCheck.php",
    type: "POST",
    data: { password: $("#pin-input").val(), uniq_code: uniq_code },
    // beforeSend: function() {
    //     $("#button-text").css("opacity", "0");
    //     $("#button-loader").css("opacity", "1");
    //     $("#button-text").css("transform", "translateY(-20px)");
    //     $("#button-loader").css("transform", "translateY(0px)");

    // },
    success: function (res) {
      var uniq_code = $("#pin-input").attr("un_code");
      //console.log(res);
      
      
      handlePinSubmit(res,uniq_code);
    },
  });
}
