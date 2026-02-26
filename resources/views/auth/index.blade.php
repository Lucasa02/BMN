<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ESIMBA - Sistem Informasi Barang Milik Negara</title>

    <link rel="shortcut icon" href="{{ asset('img/assets/esimprod_logo_bg.png') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animated-gradient {
            /* Warna Biru Elegant #1b365d dengan transisi ke navy yang lebih dalam */
            background: linear-gradient(-45deg, #1b365d, #254677, #132947, #1b365d);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        /* Motif Pattern Melambangkan Aset & Negara (Building & Shield Geometric) */
        .bmn-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.08'%3E%3Cpath d='M40 40c0-11.046-8.954-20-20-20S0 28.954 0 40s8.954 20 20 20 20-8.954 20-20zm40 0c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20zM0 0c0 11.046 8.954 20 20 20s20-8.954 20-20-8.954-20-20-20S0-11.046 0 0zm40 0c0 11.046 8.954 20 20 20s20-8.954 20-20-8.954-20-20-20-20 8.954-20 20z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        #three-canvas-container {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 0;
            cursor: grab;
        }

        #three-canvas-container:active {
            cursor: grabbing;
        }

        .tab-active {
            background-color: white !important;
            color: #1b365d !important;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
    </style>
</head>

<body class="antialiased overflow-hidden">
    <x-auth-validation></x-auth-validation>

    <div class="min-h-screen flex relative overflow-hidden">
        <div class="absolute inset-0 animated-gradient"></div>

        <div class="absolute inset-0 bmn-pattern"></div>

        <div class="absolute inset-0 opacity-20"
            style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.2) 1px, transparent 0); background-size: 30px 30px;">
        </div>

        <div class="hidden md:flex md:w-1/2 relative items-center justify-center p-12 overflow-hidden">
            <div id="three-canvas-container"></div>

            <div class="relative z-10 text-white max-w-lg pointer-events-none select-none">
                <div class="flex items-center gap-1 mb-8">
                    <div
                        class="w-14 h-14 bg-white/10 backdrop-blur-xl rounded-xl flex items-center justify-center border border-white/20 shadow-xl">
                        <i data-lucide="building-2" class="w-8 h-8 text-white"></i>
                    </div>
                    <img src="{{ asset('img/assets/logo_esimba_whitebg.png') }}" alt="Logo ESIMBA" class="h-16 w-auto object-contain -ml-1">
                </div>

                <h2 class="text-3xl font-bold mb-4 leading-tight">
                    Sistem Informasi<br />
                    <span class="text-5xl bg-gradient-to-r from-white via-blue-100 to-white bg-clip-text text-transparent">
                        Barang Milik Negara
                    </span>
                </h2>

                <p class="text-blue-100/80 text-lg mb-8 leading-relaxed">
                    Platform terintegrasi untuk mengelola dan memantau aset negara dengan aman, efisien, dan transparan.
                </p>

                <div class="flex gap-6">
                    <div
                        class="flex items-center gap-3 bg-white/5 backdrop-blur-md rounded-lg p-4 border border-white/10">
                        <i data-lucide="shield-check" class="w-6 h-6 text-blue-300"></i>
                        <span class="text-sm">Aman & Terenkripsi</span>
                    </div>
                    <div
                        class="flex items-center gap-3 bg-white/5 backdrop-blur-md rounded-lg p-4 border border-white/10">
                        <i data-lucide="file-check" class="w-6 h-6 text-blue-300"></i>
                        <span class="text-sm">Terintegrasi</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-6 lg:p-12 relative">
            <div class="absolute inset-0 bg-white/95 backdrop-blur-2xl"></div>

            <div class="w-full max-w-md relative z-10">
                <div class="md:hidden flex items-center gap-3 mb-8 justify-center">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-[#1b365d] to-[#254677] rounded-xl flex items-center justify-center text-white">
                        <i data-lucide="building-2" class="w-7 h-7"></i>
                    </div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-[#1b365d] to-[#254677] bg-clip-text text-transparent">
                        ESIMBA</h1>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                    <p class="text-gray-600">Masuk ke akun ESIMBA Anda</p>
                </div>

                <div class="bg-white rounded-2xl border-2 border-gray-100 shadow-2xl shadow-blue-900/10 p-2">
                    <div class="grid grid-cols-2 p-1 bg-gray-100 rounded-xl mb-6">
                        <button onclick="switchTab('scan')" id="tab-scan-btn"
                            class="flex items-center justify-center gap-2 py-2.5 text-sm font-medium rounded-lg transition-all tab-active">
                            <i data-lucide="scan" class="w-4 h-4"></i> Scan ID Card
                        </button>
                        <button onclick="switchTab('manual')" id="tab-manual-btn"
                            class="flex items-center justify-center gap-2 py-2.5 text-sm font-medium rounded-lg transition-all text-gray-500">
                            <i data-lucide="user" class="w-4 h-4"></i> Input Manual
                        </button>
                    </div>

                    <div class="p-4">
                        <div id="content-scan" class="space-y-6">
                            <div class="text-center space-y-4">
                                <div id="scanner-visual"
                                    class="mx-auto w-32 h-32 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl flex items-center justify-center relative overflow-hidden">
                                    <i id="scan-icon" data-lucide="scan"
                                        class="w-16 h-16 text-[#1b365d] transition-all"></i>
                                    <div id="scan-line"
                                        class="absolute inset-0 bg-gradient-to-b from-transparent via-blue-500/30 to-transparent hidden">
                                    </div>
                                </div>
                                <div id="reader-container"
                                    class="hidden overflow-hidden rounded-xl border-2 border-[#1b365d] mx-auto">
                                    <div id="reader"></div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-900 mb-2">Scan Kartu ID Anda</h3>
                                    <p class="text-sm text-gray-600">Arahkan QR Code pada kartu ke kamera untuk login
                                        otomatis</p>
                                </div>
                                <button id="btnStartScan"
                                    class="w-full bg-[#1b365d] hover:bg-[#254677] text-white h-12 rounded-xl font-semibold shadow-lg shadow-blue-900/20 flex items-center justify-center gap-2 transition-all active:scale-95">
                                    <i data-lucide="camera" class="w-5 h-5"></i>
                                    <span id="scan-text">Mulai Scan</span>
                                </button>
                            </div>
                        </div>

                        <div id="content-manual" class="hidden">
                            <form action="{{ route('login.process') }}" method="POST" class="space-y-4" id="loginForm">
                                @csrf
                                <input type="hidden" name="gambar" id="gambar_base64">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">USR Pengguna</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#1b365d] transition-colors">
                                            <i data-lucide="user" class="w-5 h-5"></i>
                                        </div>
                                        <input type="text" name="kode_user" id="kode_user" required
                                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:bg-white focus:border-[#1b365d] focus:outline-none transition-all"
                                            placeholder="Masukkan USR Anda">
                                    </div>
                                </div>
                                <button type="submit"
                                    class="w-full bg-[#1b365d] hover:bg-[#254677] text-white h-12 rounded-xl font-semibold shadow-lg shadow-blue-900/20 flex items-center justify-center gap-2 transition-all active:scale-95">
                                    Masuk
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function switchTab(tab) {
            const scanBtn = document.getElementById('tab-scan-btn');
            const manualBtn = document.getElementById('tab-manual-btn');
            const scanContent = document.getElementById('content-scan');
            const manualContent = document.getElementById('content-manual');
            if (tab === 'scan') {
                scanBtn.classList.add('tab-active');
                manualBtn.classList.remove('tab-active');
                scanContent.classList.remove('hidden');
                manualContent.classList.add('hidden');
            } else {
                stopScanner();
                manualBtn.classList.add('tab-active');
                scanBtn.classList.remove('tab-active');
                manualContent.classList.remove('hidden');
                scanContent.classList.add('hidden');
                document.getElementById('kode_user').focus();
            }
        }

        const html5QrCode = new Html5Qrcode("reader");
        const btnStartScan = document.getElementById('btnStartScan');

        function startScanner() {
            document.getElementById('reader-container').classList.remove('hidden');
            document.getElementById('scanner-visual').classList.add('hidden');
            document.getElementById('scan-line').classList.remove('hidden');
            document.getElementById('scan-text').innerText = "Berhenti";
            html5QrCode.start({
                facingMode: "environment"
            }, {
                fps: 10,
                qrbox: 250
            }, (decodedText) => {
                document.getElementById('kode_user').value = decodedText;
                stopScanner();
                document.getElementById('loginForm').submit();
            });
        }

        function stopScanner() {
            if (html5QrCode.isScanning) {
                html5QrCode.stop().then(() => {
                    document.getElementById('reader-container').classList.add('hidden');
                    document.getElementById('scanner-visual').classList.remove('hidden');
                    document.getElementById('scan-line').classList.add('hidden');
                    document.getElementById('scan-text').innerText = "Mulai Scan";
                });
            }
        }
        btnStartScan.addEventListener('click', () => html5QrCode.isScanning ? stopScanner() : startScanner());

        function init3D() {
            const container = document.getElementById('three-canvas-container');
            if (!container || container.offsetParent === null) return;

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({
                antialias: true,
                alpha: true
            });
            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            container.appendChild(renderer.domElement);

            const controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enableZoom = false;
            controls.enablePan = false;
            controls.autoRotate = true;
            controls.autoRotateSpeed = 0.5;
            controls.enableDamping = true;
            controls.dampingFactor = 0.05;

            scene.add(new THREE.AmbientLight(0xffffff, 0.6));
            const directionalLight = new THREE.DirectionalLight(0xffffff, 1.2);
            directionalLight.position.set(5, 5, 5);
            scene.add(directionalLight);

            // Warna lampu disesuaikan dengan tema Biru Elegant
            const p1 = new THREE.PointLight(0x60a5fa, 1.5);
            p1.position.set(-5, 5, -5);
            scene.add(p1);
            const p2 = new THREE.PointLight(0x1e3a8a, 1);
            p2.position.set(5, -5, 5);
            scene.add(p2);

            const buildingGroup = new THREE.Group();
            const base = new THREE.Mesh(new THREE.BoxGeometry(1.5, 2, 1), new THREE.MeshStandardMaterial({
                color: 0x254677,
                metalness: 0.8,
                roughness: 0.2
            }));
            base.position.y = -0.5;
            buildingGroup.add(base);
            const dome = new THREE.Mesh(new THREE.SphereGeometry(0.6, 32, 16, 0, Math.PI * 2, 0, Math.PI / 2), new THREE
                .MeshStandardMaterial({
                    color: 0x3b82f6,
                    metalness: 0.9,
                    roughness: 0.1
                }));
            dome.position.y = 0.8;
            buildingGroup.add(dome);

            [-0.5, -0.15, 0.15, 0.5].forEach(x => {
                const col = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.08, 1.5, 16), new THREE
                    .MeshStandardMaterial({
                        color: 0xf8fafc,
                        metalness: 0.5,
                        roughness: 0.1
                    }));
                col.position.set(x, -0.2, 0.55);
                buildingGroup.add(col);
            });
            const pole = new THREE.Mesh(new THREE.CylinderGeometry(0.03, 0.03, 0.8, 8), new THREE.MeshStandardMaterial({
                color: 0xfbbf24,
                metalness: 0.9,
                roughness: 0.1
            }));
            pole.position.y = 1.5;
            buildingGroup.add(pole);
            const flag = new THREE.Mesh(new THREE.BoxGeometry(0.3, 0.2, 0.05), new THREE.MeshStandardMaterial({
                color: 0xef4444,
                metalness: 0.5,
                roughness: 0.4
            }));
            flag.position.set(0.15, 1.7, 0);
            flag.rotation.z = 0.2;
            buildingGroup.add(flag);

            buildingGroup.scale.set(1.2, 1.2, 1.2);
            scene.add(buildingGroup);

            const docGroup = new THREE.Group();
            docGroup.add(new THREE.Mesh(new THREE.BoxGeometry(1, 1.4, 0.1), new THREE.MeshStandardMaterial({
                color: 0xffffff,
                metalness: 0.3,
                roughness: 0.5
            })));
            [0.3, 0.1, -0.1, -0.3].forEach(y => {
                const line = new THREE.Mesh(new THREE.BoxGeometry(0.7, 0.08, 0.02), new THREE.MeshStandardMaterial({
                    color: 0x1b365d
                }));
                line.position.set(0, y, 0.06);
                docGroup.add(line);
            });
            docGroup.position.set(-2.5, 1.5, -1);
            docGroup.scale.set(0.8, 0.8, 0.8);
            scene.add(docGroup);

            const shieldGroup = new THREE.Group();
            shieldGroup.add(new THREE.Mesh(new THREE.BoxGeometry(1, 1.2, 0.2), new THREE.MeshStandardMaterial({
                color: 0x3b82f6,
                metalness: 0.8,
                roughness: 0.2
            })));
            const inner = new THREE.Mesh(new THREE.BoxGeometry(0.5, 0.6, 0.05), new THREE.MeshStandardMaterial({
                color: 0xeff6ff,
                metalness: 0.4,
                roughness: 0.3
            }));
            inner.position.z = 0.15;
            shieldGroup.add(inner);
            shieldGroup.position.set(2.5, -0.8, -1);
            shieldGroup.scale.set(0.9, 0.9, 0.9);
            scene.add(shieldGroup);

            const s1 = new THREE.Mesh(new THREE.SphereGeometry(0.3, 32, 32), new THREE.MeshStandardMaterial({
                color: 0x60a5fa,
                metalness: 0.8,
                roughness: 0.2
            }));
            s1.position.set(-3, -1.8, -2);
            scene.add(s1);

            camera.position.z = 9;

            function animate() {
                requestAnimationFrame(animate);
                const time = Date.now() * 0.001;
                controls.update();
                buildingGroup.position.y = Math.sin(time * 2) * 0.15;
                docGroup.position.y = 1.5 + Math.sin(time * 1.5) * 0.12;
                shieldGroup.position.y = -0.8 + Math.sin(time * 2.5) * 0.18;
                s1.position.y = -1.8 + Math.sin(time * 3) * 0.2;
                renderer.render(scene, camera);
            }
            animate();

            window.addEventListener('resize', () => {
                camera.aspect = container.clientWidth / container.clientHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(container.clientWidth, container.clientHeight);
            });
        }

        document.addEventListener('DOMContentLoaded', init3D);
    </script>
</body>

</html>
