<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Offering Scanner Debug Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        input, select { font-size: 16px !important; }
        #video { object-fit: cover; }
        .scan-line {
            height: 3px;
            background: #3b82f6;
            box-shadow: 0 0 15px #3b82f6;
            position: absolute;
            width: 100%;
            z-index: 20;
            top: 0;
            animation: scan 2s linear infinite;
        }
        @keyframes scan { 0% { top: 0%; } 100% { top: 100%; } }
        
        /* Debug Console Styles */
        #debug-console {
            background: #0f172a;
            color: #4ade80;
            font-family: 'Courier New', Courier, monospace;
            font-size: 10px;
            padding: 10px;
            border-radius: 8px;
            height: 150px;
            overflow-y: auto;
            border: 1px solid #334155;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col font-sans">

    <header class="bg-blue-800 text-white p-4 shadow-lg sticky top-0 z-50">
        <h1 class="text-center font-bold tracking-tight uppercase">Church Offering Entry</h1>
    </header>

    <main class="p-4 max-w-md mx-auto w-full space-y-4">
        
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 grid grid-cols-2 gap-3">
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase">Service ID</label>
                <select id="service_id" class="w-full bg-slate-50 p-2 rounded-lg border border-slate-200">
                    <option value="1">Sunday Morning</option>
                    <option value="2">Youth Meeting</option>
                </select>
            </div>
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase">Service Date</label>
                <input type="date" id="service_date" value="<?php echo date('Y-m-d'); ?>" class="w-full bg-slate-50 p-2 rounded-lg border border-slate-200">
            </div>
        </div>

        <div class="relative aspect-[3/4] bg-black rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
            <video id="video" autoplay playsinline class="w-full h-full"></video>
            <canvas id="canvas" class="hidden"></canvas>
            <img id="photo-preview" class="hidden w-full h-full object-cover">
            <div id="scanner-line" class="scan-line hidden"></div>
        </div>

        <div class="space-y-3">
            <button id="btn-capture" class="w-full bg-blue-600 text-white text-lg font-bold py-4 rounded-2xl shadow-xl active:scale-95 transition-all">
                📸 Take Photo
            </button>
            <div id="post-capture-ui" class="hidden flex flex-col gap-3">
                <button id="btn-process" class="w-full bg-indigo-600 text-white text-lg font-bold py-4 rounded-2xl shadow-xl active:scale-95">
                    ✨ AI Analyze
                </button>
                <button id="btn-retake" class="w-full bg-slate-200 text-slate-600 font-bold py-2 rounded-2xl text-sm">Retake</button>
            </div>
        </div>

        <div class="mt-4">
            <div class="flex justify-between items-center mb-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase">Debug Logs</span>
                <button onclick="document.getElementById('debug-console').innerHTML=''" class="text-[10px] text-blue-500">Clear</button>
            </div>
            <div id="debug-console">
                > System ready...
            </div>
        </div>
    </main>

    <div id="review-modal" class="fixed inset-0 bg-black/60 z-[100] flex items-end sm:items-center justify-center hidden p-4">
        <div class="bg-white w-full max-w-md rounded-t-3xl sm:rounded-3xl p-6 shadow-2xl">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Verify Details</h2>
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase">Donor Name</label>
                    <input type="text" id="edit_name" class="w-full border-b-2 border-slate-100 focus:border-blue-500 p-2 outline-none font-bold text-blue-900">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase">₹ 500 Count</label>
                        <input type="number" id="edit_d500" class="w-full bg-slate-50 p-2 rounded-lg border border-slate-100">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase">₹ 100 Count</label>
                        <input type="number" id="edit_d100" class="w-full bg-slate-50 p-2 rounded-lg border border-slate-100">
                    </div>
                </div>
            </div>
            <div class="mt-6 flex flex-col gap-2">
                <button id="btn-final-save" class="w-full bg-green-600 text-white font-bold py-4 rounded-xl active:scale-95 transition-all">Confirm & Save</button>
                <button onclick="document.getElementById('review-modal').classList.add('hidden')" class="w-full text-slate-400 py-2">Close</button>
            </div>
        </div>
    </div>

    <script>
        const debugConsole = document.getElementById('debug-console');
        const log = (msg, isError = false) => {
            const time = new Date().toLocaleTimeString();
            const color = isError ? 'text-red-400' : 'text-green-400';
            debugConsole.innerHTML += `<div class="${color}">[${time}] ${msg}</div>`;
            debugConsole.scrollTop = debugConsole.scrollHeight;
        };

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const photoPreview = document.getElementById('photo-preview');
        const btnCapture = document.getElementById('btn-capture');
        const btnProcess = document.getElementById('btn-process');
        const btnRetake = document.getElementById('btn-retake');
        const reviewModal = document.getElementById('review-modal');
        const scannerLine = document.getElementById('scanner-line');

        // Compress image to target file size
        function compressImage(dataUrl, maxSizeKB = 150) {
            let quality = 0.85;
            let compressed = dataUrl;
            
            while (compressed.length / 1024 > maxSizeKB && quality > 0.2) {
                quality -= 0.05;
                const tempCanvas = document.createElement('canvas');
                const img = new Image();
                img.src = dataUrl;
                tempCanvas.width = img.width;
                tempCanvas.height = img.height;
                tempCanvas.getContext('2d').drawImage(img, 0, 0);
                compressed = tempCanvas.toDataURL('image/jpeg', quality);
            }
            
            const originalSize = (dataUrl.length / 1024).toFixed(2);
            const compressedSize = (compressed.length / 1024).toFixed(2);
            log(`Image compressed: ${originalSize}KB → ${compressedSize}KB (Quality: ${Math.round(quality * 100)}%)`);
            return compressed;
        }

        // Init Camera
        async function init() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
                video.srcObject = stream;
                log("Camera initialized.");
            } catch (err) {
                log("Camera Error: " + err.message, true);
            }
        }

        btnCapture.addEventListener('click', () => {
            // Resize canvas to max dimensions to reduce file size
            const maxWidth = 800;
            const maxHeight = 1000;
            const videoWidth = video.videoWidth;
            const videoHeight = video.videoHeight;
            
            let width = videoWidth;
            let height = videoHeight;
            
            // Scale down if larger than max dimensions
            if (width > maxWidth || height > maxHeight) {
                const ratio = Math.min(maxWidth / width, maxHeight / height);
                width = Math.round(width * ratio);
                height = Math.round(height * ratio);
            }
            
            canvas.width = width;
            canvas.height = height;
            canvas.getContext('2d').drawImage(video, 0, 0, width, height);
            
            // Compress and set preview
            let imageData = canvas.toDataURL('image/jpeg', 0.8);
            imageData = compressImage(imageData, 150);
            
            photoPreview.src = imageData;
            video.classList.add('hidden');
            photoPreview.classList.remove('hidden');
            btnCapture.classList.add('hidden');
            document.getElementById('post-capture-ui').classList.remove('hidden');
            log("Image captured and compressed.");
        });

        btnRetake.addEventListener('click', () => {
            video.classList.remove('hidden');
            photoPreview.classList.add('hidden');
            btnCapture.classList.remove('hidden');
            document.getElementById('post-capture-ui').classList.add('hidden');
            log("Camera reset.");
        });

        btnProcess.addEventListener('click', async () => {
            log("Sending image to PHP for AI analysis...");
            scannerLine.classList.remove('hidden');
            
            try {
                const response = await fetch('process_offering.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action: 'parse', image: photoPreview.src })
                });

                // Check if response is actually JSON
                const text = await response.text();
                log("Raw Response received (First 50 chars): " + text.substring(0, 50));

                const result = JSON.parse(text);
                
                if (result.success) {
                    log("AI Success: " + result.data.name);
                    document.getElementById('edit_name').value = result.data.name;
                    document.getElementById('edit_d500').value = result.data.d500 || 0;
                    document.getElementById('edit_d100').value = result.data.d100 || 0;
                    reviewModal.classList.remove('hidden');
                } else {
                    log("PHP Error: " + result.error, true);
                }
            } catch (err) {
                log("JS Error: " + err.message, true);
            } finally {
                scannerLine.classList.add('hidden');
            }
        });

        document.getElementById('btn-final-save').addEventListener('click', async () => {
            log("Saving verified data...");
            const finalData = {
                action: 'save',
                service_id: document.getElementById('service_id').value,
                service_date: document.getElementById('service_date').value,
                name: document.getElementById('edit_name').value,
                d500: document.getElementById('edit_d500').value,
                d100: document.getElementById('edit_d100').value
            };

            try {
                const response = await fetch('process_offering.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(finalData)
                });
                const res = await response.json();
                if (res.success) {
                    log("DB Save Success!");
                    alert("Saved successfully.");
                    location.reload();
                } else {
                    log("DB Error: " + res.error, true);
                }
            } catch (err) {
                log("Save JS Error: " + err.message, true);
            }
        });

        init();
    </script>
</body>
</html>