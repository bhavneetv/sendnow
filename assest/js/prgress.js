
const dragArea = document.getElementById('drag-area');
const fileInput = document.getElementById('file-input');
const progressArea = document.getElementById('progress-area');
const progressBar = document.getElementById('progress-bar');
const progressText = document.getElementById('progress-text');

 dragArea.addEventListener('click', () => fileInput.click());

 dragArea.addEventListener('dragover', (e) => {
     e.preventDefault();
     dragArea.classList.add('drag-over');
 });

 dragArea.addEventListener('dragleave', () => {
     dragArea.classList.remove('drag-over');
 });

 dragArea.addEventListener('drop', (e) => {
     e.preventDefault();
     dragArea.classList.remove('drag-over');
     const files = e.dataTransfer.files;
     handleFiles(files);
 });

 fileInput.addEventListener('change', (e) => {
     handleFiles(e.target.files);
 });

 function handleFiles(files) {
     if (files.length > 0) {
         progressArea.classList.remove('hidden');
         simulateUpload();
     }
 }

 function simulateUpload() {
     let progress = 0;
     const interval = setInterval(() => {
         progress += Math.random() * 15;
         if (progress > 100) progress = 100;
         
         progressBar.style.width = progress + '%';
         progressText.textContent = Math.round(progress) + '%';
         
         if (progress >= 100) {
             clearInterval(interval);
             setTimeout(() => {
                 progressArea.classList.add('hidden');
                 progressBar.style.width = '0%';
                 progressText.textContent = '0%';
             }, 2000);
         }
     }, 200);
 }