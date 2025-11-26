<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Header Rumah Sakit</title>

    <style>
        /* rasio logo 16:17 */
        .logo-img {
            width: 36px;
            height: calc(36px * 17 / 16);
        }
    </style>
</head>

<body class="bg-gray-900">

    <header class="bg-white shadow p-4">
    <div class="container mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="../public/assets/img/logo_anahita.png" alt="Logo" class="logo-img object-cover">

            <span class="text-xl font-semibold text-gray-800">Anahita Hospital</span>
        </div>

        <div class="flex items-center gap-8">

            <nav class="flex items-center gap-6 text-gray-700 font-medium">
                <div class="relative group cursor-pointer">
                    <span class="hover:text-green-600">Layanan ▾</span>
                    <ul class="absolute hidden group-hover:block bg-white shadow-lg rounded p-2 text-sm mt-2 w-40">
                        <li class="px-3 py-1 hover:bg-gray-100 cursor-pointer">Rawat Inap</li>
                        <li class="px-3 py-1 hover:bg-gray-100 cursor-pointer">Rawat Jalan</li>
                        <li class="px-3 py-1 hover:bg-gray-100 cursor-pointer">IGD</li>
                    </ul>
                </div>

                <a href="#" class="hover:text-green-600">Dokter</a>
                <a href="#" class="hover:text-green-600">Jadwal</a>
                <a href="#" class="hover:text-green-600">Apotek</a>
                <a href="#" class="hover:text-green-600">Profil</a>
            </nav>
            <button class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg font-medium">Masuk</button>

        </div>
    </div>
</header>


</body>

</html>