@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="bi bi-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">QR Code Scanner</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Scanner Section -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Scan QR Code</h2>
                <!-- Camera Error/Instructions -->
                <div id="camera-error" class="hidden mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                    <strong>Camera access denied or not available.</strong><br>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Click the <b>lock</b> or <b>camera</b> icon in your browser's address bar and allow camera access.</li>
                        <li>Check your browser and Windows privacy settings.</li>
                        <li>Try Incognito/Private mode or a different browser.</li>
                        <li>If prompted, always click <b>Allow</b> for camera access.</li>
                    </ul>
                    <button id="retry-camera" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Retry Camera Access</button>
                </div>
                <!-- Camera Preview -->
                <div class="mb-4">
                    <div id="scanner-container" class="relative">
                        <video id="scanner-video" class="w-full h-64 bg-gray-200 rounded-lg object-cover" autoplay playsinline></video>
                        <canvas id="scanner-canvas" class="hidden"></canvas>
                        <div id="scanner-loading" class="absolute inset-0 flex items-center justify-center bg-gray-200 rounded-lg">
                            <div class="text-center">
                                <i class="bi bi-camera text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600">Click "Start Camera" to begin scanning</p>
                            </div>
                        </div>
                        <!-- Scanning overlay -->
                        <div id="scanning-overlay" class="absolute inset-0 border-4 border-blue-500 rounded-lg hidden">
                            <div class="absolute top-2 left-2 bg-blue-500 text-white px-2 py-1 rounded text-xs">
                                Scanning...
                            </div>
                        </div>
                        <!-- QR Code Detection Overlay -->
                        <div id="qr-detected-overlay" class="absolute inset-0 border-4 border-green-500 rounded-lg hidden bg-green-500 bg-opacity-20">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-white rounded-lg p-4 shadow-lg text-center">
                                    <div class="text-green-600 text-4xl mb-2">✓</div>
                                    <p class="text-green-800 font-semibold">QR Code Detected!</p>
                                    <p class="text-sm text-gray-600">Processing...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Scanner Controls -->
                <div class="flex justify-center space-x-4 mb-6">
                    <button id="start-camera" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                        <i class="bi bi-camera mr-2"></i> Start Camera
                    </button>
                    <button id="stop-camera" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg" style="display: none;">
                        <i class="bi bi-stop-circle mr-2"></i> Stop Camera
                    </button>
                </div>
                <!-- Manual Input -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold mb-3">Manual Entry</h3>
                    <form id="manual-scan-form">
                        <div class="flex space-x-2">
                            <input type="text" 
                                   id="manual-qr-input" 
                                   placeholder="Enter QR code data manually"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                                Verify
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Results Section -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Scan Results</h2>
                <div id="scan-results" class="space-y-4">
                    <div class="text-center text-gray-500 py-8">
                        <i class="bi bi-qr-code text-4xl mb-2"></i>
                        <p>Scan a QR code to see ticket details</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Scans -->
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Recent Scans</h2>
            <div id="recent-scans" class="space-y-2">
                <p class="text-gray-500 text-center py-4">No recent scans</p>
            </div>
        </div>
    </div>
</div>

<!-- Include jsQR library -->
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let scanner = null;
    let videoElement = document.getElementById('scanner-video');
    let canvasElement = document.getElementById('scanner-canvas');
    let startButton = document.getElementById('start-camera');
    let stopButton = document.getElementById('stop-camera');
    let loadingDiv = document.getElementById('scanner-loading');
    let scanningOverlay = document.getElementById('scanning-overlay');
    let qrDetectedOverlay = document.getElementById('qr-detected-overlay');
    let manualForm = document.getElementById('manual-scan-form');
    let manualInput = document.getElementById('manual-qr-input');
    let cameraErrorDiv = document.getElementById('camera-error');
    let scanningInterval = null;
    let isScanning = false;
    let qrCodeDetected = false;

    // Camera controls
    async function requestCamera() {
        cameraErrorDiv.classList.add('hidden');
        qrCodeDetected = false;
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    facingMode: 'environment',
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                } 
            });
            videoElement.srcObject = stream;
            loadingDiv.style.display = 'none';
            scanningOverlay.classList.remove('hidden');
            qrDetectedOverlay.classList.add('hidden');
            startButton.style.display = 'none';
            stopButton.style.display = 'inline-block';
            
            // Wait for video to load
            videoElement.addEventListener('loadedmetadata', function() {
                startQRScanning();
            });
        } catch (error) {
            console.error('Camera error:', error);
            cameraErrorDiv.classList.remove('hidden');
            loadingDiv.style.display = 'flex';
            scanningOverlay.classList.add('hidden');
            qrDetectedOverlay.classList.add('hidden');
            startButton.style.display = 'inline-block';
            stopButton.style.display = 'none';
        }
    }

    startButton.addEventListener('click', requestCamera);

    // Retry camera access
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'retry-camera') {
            requestCamera();
        }
    });

    stopButton.addEventListener('click', function() {
        stopQRScanning();
        if (videoElement.srcObject) {
            videoElement.srcObject.getTracks().forEach(track => track.stop());
            videoElement.srcObject = null;
        }
        loadingDiv.style.display = 'flex';
        scanningOverlay.classList.add('hidden');
        qrDetectedOverlay.classList.add('hidden');
        startButton.style.display = 'inline-block';
        stopButton.style.display = 'none';
    });

    // Manual form submission
    manualForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const qrData = manualInput.value.trim();
        if (qrData) {
            verifyTicket(qrData);
            manualInput.value = '';
        }
    });

    function startQRScanning() {
        if (isScanning) return;
        isScanning = true;
        
        // Set up canvas for QR detection
        const canvas = canvasElement;
        const context = canvas.getContext('2d', { willReadFrequently: true });
        
        scanningInterval = setInterval(function() {
            if (videoElement.readyState === videoElement.HAVE_ENOUGH_DATA && !qrCodeDetected) {
                canvas.height = videoElement.videoHeight;
                canvas.width = videoElement.videoWidth;
                context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
                
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: "dontInvert",
                });
                
                if (code && code.data && code.data.trim() !== '') {
                    console.log("QR Code detected:", code.data);
                    console.log("QR Code length:", code.data.length);
                    qrCodeDetected = true;
                    
                    // Show QR detected overlay
                    scanningOverlay.classList.add('hidden');
                    qrDetectedOverlay.classList.remove('hidden');
                    
                    // Stop scanning and close camera after a short delay
                    setTimeout(function() {
                        stopQRScanning();
                        if (videoElement.srcObject) {
                            videoElement.srcObject.getTracks().forEach(track => track.stop());
                            videoElement.srcObject = null;
                        }
                        
                        // Hide overlays and show loading state
                        scanningOverlay.classList.add('hidden');
                        qrDetectedOverlay.classList.add('hidden');
                        loadingDiv.style.display = 'flex';
                        startButton.style.display = 'inline-block';
                        stopButton.style.display = 'none';
                        
                        // Process the QR code
                        verifyTicket(code.data);
                    }, 1500); // Wait 1.5 seconds to show the detection feedback
                }
            }
        }, 100); // Scan every 100ms
    }

    function stopQRScanning() {
        if (scanningInterval) {
            clearInterval(scanningInterval);
            scanningInterval = null;
        }
        isScanning = false;
    }

    function verifyTicket(qrData) {
        console.log("Verifying ticket with data:", qrData);
        
        // Show loading state
        const resultsDiv = document.getElementById('scan-results');
        resultsDiv.innerHTML = `
            <div class="border rounded-lg p-4 border-blue-200 bg-blue-50">
                <div class="flex items-center mb-2">
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600 mr-2"></div>
                    <span class="font-semibold text-blue-800">Verifying ticket...</span>
                </div>
            </div>
        `;

        // Send verification request
        fetch('{{ route("admin.scan.ticket") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ qr_data: qrData })
        })
        .then(response => {
            console.log("Response status:", response.status);
            console.log("Response headers:", response.headers);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                return response.text().then(text => {
                    console.error("Non-JSON response:", text);
                    throw new Error('Server returned non-JSON response');
                });
            }
            
            return response.json();
        })
        .then(data => {
            console.log("Response data:", data);
            displayScanResult(data);
            addToRecentScans(data, qrData);
        })
        .catch(error => {
            console.error('Error:', error);
            displayScanResult({ 
                success: false, 
                message: `Error: ${error.message}. Please try again or use manual entry.` 
            });
        });
    }

    function displayScanResult(result) {
        const resultsDiv = document.getElementById('scan-results');
        const timestamp = new Date().toLocaleTimeString();
        
        // Determine the styling based on the result
        let borderClass, bgClass, iconClass, textClass, title, message;
        
        if (result.success) {
            borderClass = 'border-green-200';
            bgClass = 'bg-green-50';
            iconClass = 'bi-check-circle text-green-600';
            textClass = 'text-green-800';
            title = 'Valid Ticket';
            message = result.message;
        } else if (result.expired) {
            borderClass = 'border-orange-200';
            bgClass = 'bg-orange-50';
            iconClass = 'bi-clock text-orange-600';
            textClass = 'text-orange-800';
            title = 'Expired Ticket';
            message = 'This ticket has expired and cannot be used for boarding.';
        } else if (result.already_checked_in) {
            borderClass = 'border-blue-200';
            bgClass = 'bg-blue-50';
            iconClass = 'bi-info-circle text-blue-600';
            textClass = 'text-blue-800';
            title = 'Already Checked In';
            message = 'This passenger has already been checked in for this trip.';
        } else {
            borderClass = 'border-red-200';
            bgClass = 'bg-red-50';
            iconClass = 'bi-x-circle text-red-600';
            textClass = 'text-red-800';
            title = 'Invalid Ticket';
            message = result.message || 'This ticket is not valid for boarding.';
        }
        
        let html = `<div class="border rounded-lg p-4 ${borderClass} ${bgClass}">`;
        html += `<div class="flex items-center mb-3">`;
        html += `<i class="bi ${iconClass} text-2xl mr-3"></i>`;
        html += `<div>`;
        html += `<h3 class="font-bold ${textClass} text-lg">${title}</h3>`;
        html += `<p class="text-sm text-gray-600">${message}</p>`;
        html += `</div>`;
        html += `</div>`;
        
        if (result.booking) {
            html += `<div class="bg-white rounded-lg p-4 mb-3 border border-gray-200">`;
            html += `<h4 class="font-semibold text-gray-800 mb-2">Passenger Details</h4>`;
            html += `<div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">`;
            html += `<div><span class="font-medium text-gray-600">Name:</span> <span class="text-gray-800">${result.booking.user.name}</span></div>`;
            html += `<div><span class="font-medium text-gray-600">Route:</span> <span class="text-gray-800">${result.booking.trip.route.origin} → ${result.booking.trip.route.destination}</span></div>`;
            html += `<div><span class="font-medium text-gray-600">Seat:</span> <span class="font-bold text-blue-600">${result.booking.seat.seat_number}</span></div>`;
            html += `<div><span class="font-medium text-gray-600">Date:</span> <span class="text-gray-800">${result.booking.trip.departure_date} ${result.booking.trip.departure_time}</span></div>`;
            
            // Show expiry information if available
            if (result.booking.expires_at) {
                const expiryDate = new Date(result.booking.expires_at);
                const now = new Date();
                const isExpired = expiryDate < now;
                
                html += `<div class="md:col-span-2"><span class="font-medium text-gray-600">Expires:</span> <span class="${isExpired ? 'text-red-600 font-semibold' : 'text-green-600'}">${expiryDate.toLocaleString()}</span></div>`;
            }
            html += `</div>`;
            html += `</div>`;
        }
        
        // Add action buttons based on ticket status
        if (result.success) {
            html += `<div class="bg-green-100 border border-green-300 rounded-lg p-3 mb-3">`;
            html += `<div class="flex items-center">`;
            html += `<i class="bi bi-check-circle text-green-600 text-xl mr-2"></i>`;
            html += `<span class="text-green-800 font-semibold">Passenger successfully checked in!</span>`;
            html += `</div>`;
            html += `</div>`;
        } else if (result.already_checked_in) {
            html += `<div class="bg-blue-100 border border-blue-300 rounded-lg p-3 mb-3">`;
            html += `<div class="flex items-center">`;
            html += `<i class="bi bi-info-circle text-blue-600 text-xl mr-2"></i>`;
            html += `<span class="text-blue-800">This passenger is already on the manifest.</span>`;
            html += `</div>`;
            html += `</div>`;
        } else if (result.expired) {
            html += `<div class="bg-orange-100 border border-orange-300 rounded-lg p-3 mb-3">`;
            html += `<div class="flex items-center">`;
            html += `<i class="bi bi-exclamation-triangle text-orange-600 text-xl mr-2"></i>`;
            html += `<span class="text-orange-800">Please inform the passenger that their ticket has expired.</span>`;
            html += `</div>`;
            html += `</div>`;
        } else {
            html += `<div class="bg-red-100 border border-red-300 rounded-lg p-3 mb-3">`;
            html += `<div class="flex items-center">`;
            html += `<i class="bi bi-x-circle text-red-600 text-xl mr-2"></i>`;
            html += `<span class="text-red-800">Please inform the passenger that their ticket is not valid.</span>`;
            html += `</div>`;
            html += `</div>`;
        }
        
        html += `<p class="text-xs text-gray-500">Scanned at ${timestamp}</p>`;
        html += `</div>`;
        resultsDiv.innerHTML = html;
        
        // Show a toast notification
        showToast(title, message, result.success ? 'success' : (result.expired ? 'warning' : 'error'));
    }

    function showToast(title, message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 max-w-sm w-full bg-white rounded-lg shadow-lg border-l-4 p-4 transform transition-all duration-300 translate-x-full`;
        
        // Set border color based on type
        if (type === 'success') {
            toast.classList.add('border-green-500');
        } else if (type === 'warning') {
            toast.classList.add('border-orange-500');
        } else if (type === 'error') {
            toast.classList.add('border-red-500');
        } else {
            toast.classList.add('border-blue-500');
        }
        
        // Set icon and colors
        let icon, textColor;
        if (type === 'success') {
            icon = 'bi-check-circle text-green-600';
            textColor = 'text-green-800';
        } else if (type === 'warning') {
            icon = 'bi-exclamation-triangle text-orange-600';
            textColor = 'text-orange-800';
        } else if (type === 'error') {
            icon = 'bi-x-circle text-red-600';
            textColor = 'text-red-800';
        } else {
            icon = 'bi-info-circle text-blue-600';
            textColor = 'text-blue-800';
        }
        
        toast.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="bi ${icon} text-xl"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium ${textColor}">${title}</p>
                    <p class="text-sm text-gray-600 mt-1">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                        <i class="bi bi-x text-lg"></i>
                    </button>
                </div>
            </div>
        `;
        
        // Add to page
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 300);
        }, 5000);
    }

    function addToRecentScans(result, qrData) {
        const recentDiv = document.getElementById('recent-scans');
        const timestamp = new Date().toLocaleTimeString();
        if (recentDiv.querySelector('p')) {
            recentDiv.innerHTML = '';
        }
        const scanItem = document.createElement('div');
        scanItem.className = `flex justify-between items-center p-2 border rounded ${result.success ? 'border-green-200' : 'border-red-200'}`;
        scanItem.innerHTML = `
            <span class="text-sm">${result.success ? '✅' : '❌'} ${result.message}</span>
            <span class="text-xs text-gray-500">${timestamp}</span>
        `;
        recentDiv.insertBefore(scanItem, recentDiv.firstChild);
        // Keep only last 10 scans
        while (recentDiv.children.length > 10) {
            recentDiv.removeChild(recentDiv.lastChild);
        }
    }
});
</script>
@endsection 