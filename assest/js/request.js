
// for  notification 
function showMsg(color,text) {
    // Create success notification
    const notification = document.createElement('div');
    notification.className = 'fixed top-20 right-6 bg-'+color+'-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
    notification.innerHTML = text;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// for calculate progress 
function calculateProgress(e) {
    var percent = Math.round((e.loaded / e.total) * 100);
    $("#progress-area").css("display", "block");
    $("#progress-bar").css("width", percent + "%");
    $("#progress-text").text(`Uploading... ${percent}%`);
    if (percent == 100) {
        // $("#progress-area").css("display", "none");
        showMsg('green','Files uploaded successfully!');
        setTimeout(() => {
            location.href = "sendFiles/sendfiles.php";
        }, 1000);
    }
}

// for file upload request through ajax 
    $("#file-input").change(function() {

        var file = this.files[0];
        if (!file) return;
        // console.log(file);

        var formData = new FormData();
        formData.append("file", file); // must be 'file'
        // alert(file.size);
        if(file.size > 10 * 1024 * 1024){
            showMsg('red','File size exceeds the limit of 10MB');
            
            return;
        }

        $.ajax({
            url: "backend/upload.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $("#button-text").css("opacity", "0");
                $("#button-loader").css("opacity", "1");
                $("#button-text").css("transform", "translateY(-20px)");
                $("#button-loader").css("transform", "translateY(0px)");
                
            },
            xhr: function () {
                var xhr = new window.XMLHttpRequest();

                // Upload progress
                xhr.upload.addEventListener("progress", function (e) {
                    if (e.lengthComputable) {
                        calculateProgress(e);
                    }
                }, false);

                return xhr;
            },
            success: function(res) {
                console.log(res);
                if(res == "yes"){
                  
                    $("#button-text").css("opacity", "1");
                    $("#button-loader").css("opacity", "0");
                    $("#button-text").css("transform", "translateY(0px)");
                    $("#button-loader").css("transform", "translateY(0px)");
                    $("#progress-area").css("display", "none");
                    setTimeout(() => {
                        location.href = "sendFiles/sendfiles.php";
                    }, 3000);


                    

                }else{
                    showMsg('red','Files uploaded failed!');
                    $("#button-text").css("opacity", "1");
                    $("#button-loader").css("opacity", "0");
                    $("#button-text").css("transform", "translateY(0px)");
                    $("#button-loader").css("transform", "translateY(0px)");
                    $("#progress-area").css("display", "none");
                    
                }
            },
            
        });
    });
