<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon library (Remix Icon) -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Footer Anahita Hospital</title>
</head>

<body>
    <footer class="bg-gradient-to-b from-gray-800 to-gray-900 text-gray-200 pt-14 pb-8">
        <div class="container mx-auto px-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

                <!-- Kolom 1 -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="../public/assets/img/logo_anahita.png"
                            alt="Logo"
                            class="object-cover bg-white rounded-lg p-1 shadow"
                            style="width:36px; height:calc(36px * 17 / 16);">
                        <span class="text-lg font-semibold">Anahita Hospital</span>
                    </div>

                    <p class="text-sm leading-relaxed mb-4">
                        Memberikan layanan kesehatan terbaik dengan teknologi modern dan
                        tenaga medis profesional untuk kesejahteraan Anda.
                    </p>

                    <div class="flex gap-3 mt-3 text-xl">
                        <a href="#" class="hover:text-white"><i class="ri-facebook-fill"></i></a>
                        <a href="#" class="hover:text-white"><i class="ri-twitter-fill"></i></a>
                        <a href="#" class="hover:text-white"><i class="ri-instagram-fill"></i></a>
                        <a href="#" class="hover:text-white"><i class="ri-youtube-fill"></i></a>
                        <a href="#" class="hover:text-white"><i class="ri-linkedin-box-fill"></i></a>
                    </div>
                </div>

                <!-- Kolom 2 -->
                <div>
                    <h3 class="font-semibold mb-4 text-lg">Layanan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Konsultasi Langsung</a></li>
                        <li><a href="#" class="hover:text-white">Apotek Online</a></li>
                        <li><a href="#" class="hover:text-white">Artikel Medis</a></li>
                        <li><a href="#" class="hover:text-white">Cek Laboratorium</a></li>
                        <li><a href="#" class="hover:text-white">Rawat Inap</a></li>
                    </ul>
                </div>

                <!-- Kolom 3 -->
                <div>
                    <h3 class="font-semibold mb-4 text-lg">Dukungan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Partnership</a></li>
                        <li><a href="#" class="hover:text-white">Dokumentasi</a></li>
                        <li><a href="#" class="hover:text-white">Panduan</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                        <li><a href="#" class="hover:text-white">Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Kolom 4 -->
                <div>
                    <h3 class="font-semibold mb-4 text-lg">Langganan</h3>
                    <p class="text-sm mb-3">
                        Dapatkan informasi kesehatan dan berita terbaru dari kami.
                    </p>

                    <div class="flex bg-gray-700 rounded-lg p-1 items-center mt-3">
                        <input
                            type="email"
                            placeholder="Alamat Email"
                            class="flex-1 bg-transparent outline-none px-3 py-2 text-sm text-gray-200 placeholder-gray-400">

                        <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-md">
                            <i class="ri-send-plane-fill"></i>
                        </button>
                    </div>
                </div>

            </div>

            <div class="border-t border-gray-700 mt-12 pt-5 flex flex-col md:flex-row justify-between text-sm text-gray-400">
                <span>© 2025 Anahita Hospital — All Rights Reserved</span>
                <span>Designed and Developed by <a href="#" class="text-blue-300 hover:underline">Anak Bunda</a></span>
            </div>

        </div>
    </footer>

</body>

</html>