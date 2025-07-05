const dragArea = document.getElementById('drag-area');
const fileInput = document.getElementById('file-input');
const progressArea = document.getElementById('progress-area');
const progressBar = document.getElementById('progress-bar');
const progressText = document.getElementById('progress-text');

 // Prevent default drag behaviors
 ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
     dragArea.addEventListener(eventName, preventDefaults, false);
     document.body.addEventListener(eventName, preventDefaults, false);
 });

 function preventDefaults(e) {
     e.preventDefault();
     e.stopPropagation();
 }

 // Highlight drag area when item is dragged over it
 ['dragenter', 'dragover'].forEach(eventName => {
     dragArea.addEventListener(eventName, highlight, false);
 });

 ['dragleave', 'drop'].forEach(eventName => {
     dragArea.addEventListener(eventName, unhighlight, false);
 });

 function highlight() {
     dragArea.classList.add('drag-over');
 }

 function unhighlight() {
     dragArea.classList.remove('drag-over');
 }

 // Handle dropped files
 dragArea.addEventListener('drop', handleDrop, false);

 function handleDrop(e) {
     const dt = e.dataTransfer;
     const files = dt.files;
     handleFiles(files);
 }

 // Handle file input
 dragArea.addEventListener('click', () => {
     fileInput.click();
 });

 fileInput.addEventListener('change', (e) => {
     const files = e.target.files;
     handleFiles(files);
 });

 function handleFiles(files) {
     if (files.length > 0) {
         simulateUpload();
     }
 }



