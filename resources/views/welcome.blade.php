<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Certificate Verification System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased">
    /*   This is a simple certificate verification system that allows users to upload certificates,*/
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-xl font-bold">Certificate Verification System</h1>
                        </div>
                    </div>
                    @if (Route::has('login'))
                        <div class="flex items-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Certificate Upload Section -->
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h2 class="text-xl font-semibold mb-4">Upload Certificate</h2>
                                <form id="uploadForm" class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Certificate File</label>
                                        <input type="file" class="mt-1 block w-full" accept=".pdf,.jpg,.jpeg,.png" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Certificate Details</label>
                                        <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Certificate ID" required>
                                    </div>
                                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                                        Generate QR Code
                                    </button>
                                </form>
                            </div>

                            <!-- QR Scanner Section -->
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h2 class="text-xl font-semibold mb-4">Verify Certificate</h2>
                                
                                <!-- Tabs for Scanner/Manual Input -->
                                <div class="mb-4">
                                    <div class="border-b border-gray-200">
                                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                            <button id="scanner-tab" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                                Scanner
                                            </button>
                                            <button id="manual-tab" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                                Manual Input
                                            </button>
                                        </nav>
                                    </div>
                                </div>

                                <!-- Scanner Section -->
                                <div id="scanner-section">
                                    <div id="reader" class="w-full"></div>
                                    <div class="mt-4">
                                        <button id="startScanner" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">
                                            Start Scanner
                                        </button>
                                    </div>
                                </div>

                                <!-- Manual Input Section -->
                                <div id="manual-section" class="hidden">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Verification Code</label>
                                            <input type="text" id="verificationCode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter certificate code">
                                        </div>
                                        <button id="verifyManual" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                                            Verify Certificate
                                        </button>
                                    </div>
                                </div>

                                <div id="result" class="mt-4 p-4 bg-gray-50 rounded-md hidden">
                                    <h3 class="font-medium">Verification Result</h3>
                                    <p id="verificationText" class="mt-2"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        let html5QrcodeScanner = null;
        let isScanning = false;

        // Tab switching
        document.getElementById('scanner-tab').addEventListener('click', function() {
            document.getElementById('scanner-section').classList.remove('hidden');
            document.getElementById('manual-section').classList.add('hidden');
            this.classList.add('border-blue-500', 'text-blue-600');
            this.classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('manual-tab').classList.remove('border-blue-500', 'text-blue-600');
            document.getElementById('manual-tab').classList.add('border-transparent', 'text-gray-500');
        });

        document.getElementById('manual-tab').addEventListener('click', function() {
            document.getElementById('scanner-section').classList.add('hidden');
            document.getElementById('manual-section').classList.remove('hidden');
            this.classList.add('border-blue-500', 'text-blue-600');
            this.classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('scanner-tab').classList.remove('border-blue-500', 'text-blue-600');
            document.getElementById('scanner-tab').classList.add('border-transparent', 'text-gray-500');
            if (isScanning) {
                stopScanner();
            }
        });

        // Scanner functionality
        document.getElementById('startScanner').addEventListener('click', function() {
            if (!isScanning) {
                startScanner();
            } else {
                stopScanner();
            }
        });

        function startScanner() {
            if (!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader",
                    { 
                        fps: 10, 
                        qrbox: {width: 250, height: 250},
                        aspectRatio: 1.0
                    },
                    false
                );
            }

            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            isScanning = true;
            document.getElementById('startScanner').textContent = 'Stop Scanner';
            document.getElementById('startScanner').classList.remove('bg-green-600', 'hover:bg-green-700');
            document.getElementById('startScanner').classList.add('bg-red-600', 'hover:bg-red-700');
        }

        function stopScanner() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }
            isScanning = false;
            document.getElementById('startScanner').textContent = 'Start Scanner';
            document.getElementById('startScanner').classList.remove('bg-red-600', 'hover:bg-red-700');
            document.getElementById('startScanner').classList.add('bg-green-600', 'hover:bg-green-700');
        }

        function onScanSuccess(decodedText, decodedResult) {
            stopScanner();
            verifyCertificate(decodedText);
        }

        function onScanFailure(error) {
            console.warn(`QR Code scan error: ${error}`);
        }

        // Manual verification
        document.getElementById('verifyManual').addEventListener('click', function() {
            const code = document.getElementById('verificationCode').value;
            if (code) {
                verifyCertificate(code);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Please enter a verification code',
                    icon: 'error'
                });
            }
        });

        function verifyCertificate(code) {
            document.getElementById('result').classList.remove('hidden');
            document.getElementById('verificationText').textContent = 'Verifying certificate...';
            
            // Here you would typically make an API call to verify the certificate
            // For now, we'll just show a success message
            Swal.fire({
                title: 'Certificate Found!',
                text: 'Verifying authenticity...',
                icon: 'info',
                showConfirmButton: false,
                timer: 2000
            });
        }

        // Handle form submission
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would typically handle the file upload and QR code generation
            Swal.fire({
                title: 'Processing...',
                text: 'Generating QR code for your certificate',
                icon: 'info',
                showConfirmButton: false,
                timer: 2000
            });
        });
    </script>
</body>
</html>
