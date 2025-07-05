function setPassword() {
  const password = document.getElementById("access-password").value;
  if (password.trim()) {
    setPass();
    // const button = event.target;
  } else {
    alert("Please enter a password");
  }
}

// for file upload request through ajax

function setPass() {
  $.ajax({
    url: "../backend/setpassword.php",
    type: "POST",
    data: { password: $("#access-password").val() },
    // beforeSend: function() {
    //     $("#button-text").css("opacity", "0");
    //     $("#button-loader").css("opacity", "1");
    //     $("#button-text").css("transform", "translateY(-20px)");
    //     $("#button-loader").css("transform", "translateY(0px)");

    // },
    success: function (res) {
      if (res == "yes") {
        $("#button-text").html("✅ Password Set");
        $("#button-text").css("opacity", "1");
        $("#button-text").css("transform", "translateY(0px)");
        window.location.reload();
        setTimeout(() => {
          $("#button-text").html("🔒 Set Password");
          $("#button-text").css("opacity", "0");
          $("#button-text").css("transform", "translateY(-20px)");
        }, 2000);
      }
    },
  });
}

document.getElementById("send-email").addEventListener("click", function (e) {
  e.preventDefault();
  
  sendMail();
});

function sendMail() {
  

  $.ajax({
    url: "sendMail.php",
    type: "POST",
    data: {
      email: $("#recipient-email").val(),
      msg: $("#email-message").val(),
      link: $("#share-link").val(),
    },
    beforeSend: function () {
      $("#send-email").css("opacity", "0.7");
      $("#send-email").addClass("loading");
      $("#send-email").attr("disabled", "true");
    },
    success: function (res) {

      if (res == "yes") {
        $("#send-email").css("opacity", "1");
        $("#send-email").removeClass("loading");
        $("#send-email").removeAttr("disabled");
        $("#send-email").html("✅ Email Sent");
        setTimeout(() => {
          $("#send-email").html("📧 Send Email");
        }, 2000);
      }
    },
  });
}
