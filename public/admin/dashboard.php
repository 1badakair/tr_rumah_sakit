<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Admin Dashboard - Dokter</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet" />
    <style>
        /* simple modal animation */
        .modal-enter {
            transform: translateY(-6px);
            opacity: 0;
        }

        .modal-show {
            transform: translateY(0);
            opacity: 1;
            transition: all .18s ease;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <!-- HEADER -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="https://via.placeholder.com/48" alt="logo" class="w-12 h-12 rounded-full bg-white p-1 shadow" />
                <h1 class="text-xl font-semibold">Admin Dashboard — Dokter</h1>
            </div>
            <div>
                <button id="addDoctorBtn" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">+ Tambah Dokter</button>
            </div>
        </div>
    </header>

    <!-- MAIN -->
    <main class="container mx-auto p-6">
        <!-- Filter / Search -->
        <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div class="flex items-center gap-3">
                <input id="searchInput" type="text" placeholder="Cari nama/spesialisasi/rumah sakit..." class="px-3 py-2 border rounded w-80" />
                <select id="filterHospital" class="px-3 py-2 border rounded">
                    <option value="">Semua Rumah Sakit</option>
                </select>
            </div>
            <div class="text-sm text-gray-600">Data tersimpan di localStorage (demo). Ganti `saveData()` untuk backend.</div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded shadow overflow-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="p-3 border-b">#</th>
                        <th class="p-3 border-b">Nama</th>
                        <th class="p-3 border-b">Spesialisasi</th>
                        <th class="p-3 border-b">Praktek</th>
                        <th class="p-3 border-b">Jadwal</th>
                        <th class="p-3 border-b">Pendidikan</th>
                        <th class="p-3 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody id="doctorsTbody" class="text-sm">
                    <!-- rows populated by JS -->
                </tbody>
            </table>
        </div>
    </main>

    <!-- Edit / Add Modal -->
    <div id="modalBackdrop" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-40">
        <div id="modalCard" class="bg-white rounded-lg shadow-lg w-full max-w-3xl mx-4 transform modal-enter">
            <div class="p-4 border-b flex items-center justify-between">
                <h2 id="modalTitle" class="text-lg font-semibold">Edit Dokter</h2>
                <button id="closeModal" class="text-gray-500 hover:text-gray-800"><i class="ri-close-line text-2xl"></i></button>
            </div>

            <form id="doctorForm" class="p-6 space-y-4">
                <input type="hidden" id="doctorId" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input id="name" required class="mt-1 block w-full border rounded px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Spesialisasi</label>
                        <input id="specialty" class="mt-1 block w-full border rounded px-3 py-2" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Tempat Praktek (Rumah Sakit)</label>
                        <input id="hospital" class="mt-1 block w-full border rounded px-3 py-2" placeholder="Nama Rumah Sakit" />
                    </div>
                </div>

                <!-- Jadwal (dynamic list) -->
                <div>
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-medium text-gray-700">Jadwal Praktek</label>
                        <button id="addScheduleRow" type="button" class="text-sm text-green-600 hover:underline">+ Tambah Hari</button>
                    </div>

                    <div id="schedulesList" class="mt-3 space-y-2">
                        <!-- rows inserted here -->
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Tambahkan hari + rentang jam. Contoh: Senin 09:00 - 12:00</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Pendidikan</label>
                    <textarea id="education" rows="3" class="mt-1 block w-full border rounded px-3 py-2" placeholder="Contoh: S1 Kedokteran - Universitas X; Spesialis ..."></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" id="deleteDoctorBtn" class="bg-red-100 text-red-700 px-3 py-2 rounded hidden">Hapus</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- TEMPLATE for schedule row -->
    <template id="scheduleRowTpl">
        <div class="flex gap-2 items-center">
            <select class="day border rounded px-2 py-1">
                <option>Senin</option>
                <option>Selasa</option>
                <option>Rabu</option>
                <option>Kamis</option>
                <option>Jumat</option>
                <option>Sabtu</option>
                <option>Minggu</option>
            </select>
            <input type="time" class="start border rounded px-2 py-1" />
            <span class="text-xs text-gray-500">s/d</span>
            <input type="time" class="end border rounded px-2 py-1" />
            <button type="button" class="removeRow text-red-500 hover:text-red-700"><i class="ri-delete-bin-line"></i></button>
        </div>
    </template>

    <script>
        // ---------- Sample data ----------
        const SAMPLE = [{
                id: 'd1',
                name: 'dr. Anita S.',
                specialty: 'Spesialis Penyakit Dalam',
                hospital: 'RS Anahita Utama',
                schedules: [{
                        day: 'Senin',
                        start: '09:00',
                        end: '12:00'
                    },
                    {
                        day: 'Rabu',
                        start: '14:00',
                        end: '17:00'
                    }
                ],
                education: 'S1 FK Universitas A; SpPD - Fakultas B'
            },
            {
                id: 'd2',
                name: 'dr. Budi H.',
                specialty: 'Dokter Anak',
                hospital: 'RS Sehat Sentosa',
                schedules: [{
                        day: 'Selasa',
                        start: '10:00',
                        end: '13:00'
                    },
                    {
                        day: 'Jumat',
                        start: '09:00',
                        end: '12:00'
                    }
                ],
                education: 'S1 FK Universitas X; SpA - Universitas Y'
            }
        ];

        // ---------- Utilities ----------
        const $ = s => document.querySelector(s);
        const $$ = s => Array.from(document.querySelectorAll(s));

        const LS_KEY = 'admin_doctors_v1';

        function loadData() {
            const raw = localStorage.getItem(LS_KEY);
            if (!raw) {
                localStorage.setItem(LS_KEY, JSON.stringify(SAMPLE));
                return SAMPLE.slice();
            }
            try {
                return JSON.parse(raw);
            } catch (e) {
                localStorage.setItem(LS_KEY, JSON.stringify(SAMPLE));
                return SAMPLE.slice();
            }
        }

        // If you want to save to backend, replace implementation here:
        function saveData(arr) {
            // ---------- Option A: localStorage (default demo) ----------
            localStorage.setItem(LS_KEY, JSON.stringify(arr));

            // ---------- Option B: send to backend (example) ----------
            // fetch('/api/doctors/save', {
            //   method: 'POST',
            //   headers: { 'Content-Type': 'application/json' },
            //   body: JSON.stringify(arr)
            // }).then(r => r.json()).then(res => console.log('saved', res));
        }

        // ---------- Rendering ----------
        let doctors = loadData();

        const doctorsTbody = $('#doctorsTbody');
        const filterHospital = $('#filterHospital');
        const searchInput = $('#searchInput');

        function renderTable() {
            const q = searchInput.value.trim().toLowerCase();
            doctorsTbody.innerHTML = '';
            const filtered = doctors.filter(d => {
                return !q ||
                    d.name.toLowerCase().includes(q) ||
                    (d.specialty || '').toLowerCase().includes(q) ||
                    (d.hospital || '').toLowerCase().includes(q);
            });

            filtered.forEach((d, i) => {
                const tr = document.createElement('tr');
                tr.className = i % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                tr.innerHTML = `
          <td class="p-3 border-b align-top">${i+1}</td>
          <td class="p-3 border-b align-top"><div class="font-medium">${escapeHtml(d.name)}</div></td>
          <td class="p-3 border-b align-top">${escapeHtml(d.specialty || '')}</td>
          <td class="p-3 border-b align-top">${escapeHtml(d.hospital || '')}</td>
          <td class="p-3 border-b align-top">${renderSchedulesInline(d.schedules)}</td>
          <td class="p-3 border-b align-top">${escapeHtml(d.education || '')}</td>
          <td class="p-3 border-b align-top">
            <div class="flex gap-2">
              <button class="editBtn bg-yellow-100 text-yellow-800 px-3 py-1 rounded text-sm" data-id="${d.id}"><i class="ri-edit-line"></i> Edit</button>
              <button class="deleteBtn bg-red-100 text-red-700 px-3 py-1 rounded text-sm" data-id="${d.id}"><i class="ri-delete-bin-line"></i> Hapus</button>
            </div>
          </td>
        `;
                doctorsTbody.appendChild(tr);
            });

            populateHospitalFilter();
            attachRowButtons();
        }

        function escapeHtml(text) {
            return String(text || '').replace(/[&<>"']/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            } [m]));
        }

        function renderSchedulesInline(schedules) {
            if (!schedules || schedules.length === 0) return '<span class="text-xs text-gray-500">-</span>';
            return schedules.map(s => `<div class="text-xs text-gray-600">${escapeHtml(s.day)} ${s.start}–${s.end}</div>`).join('');
        }

        function populateHospitalFilter() {
            const hospitals = Array.from(new Set(doctors.map(d => d.hospital).filter(Boolean)));
            filterHospital.innerHTML = '<option value="">Semua Rumah Sakit</option>';
            hospitals.forEach(h => {
                const opt = document.createElement('option');
                opt.value = h;
                opt.textContent = h;
                filterHospital.appendChild(opt);
            });
        }

        function attachRowButtons() {
            $$('.editBtn').forEach(b => b.onclick = e => openEditModal(e.currentTarget.dataset.id));
            $$('.deleteBtn').forEach(b => b.onclick = e => {
                if (!confirm('Hapus dokter ini?')) return;
                const id = e.currentTarget.dataset.id;
                doctors = doctors.filter(x => x.id !== id);
                saveData(doctors);
                renderTable();
            });
        }

        // ---------- Modal & Form ----------
        const modalBackdrop = $('#modalBackdrop');
        const modalCard = $('#modalCard');
        const doctorForm = $('#doctorForm');
        const addDoctorBtn = $('#addDoctorBtn');
        const closeModal = $('#closeModal');
        const modalTitle = $('#modalTitle');
        const deleteDoctorBtn = $('#deleteDoctorBtn');

        addDoctorBtn.onclick = () => openEditModal(null);

        closeModal.onclick = () => toggleModal(false);
        modalBackdrop.onclick = (e) => {
            if (e.target === modalBackdrop) toggleModal(false);
        };

        function toggleModal(show) {
            modalBackdrop.classList.toggle('hidden', !show);
            if (show) {
                modalCard.classList.remove('modal-enter');
                modalCard.classList.add('modal-show');
            } else {
                modalCard.classList.remove('modal-show');
                modalCard.classList.add('modal-enter');
            }
        }

        function openEditModal(id) {
            const isNew = !id;
            modalTitle.textContent = isNew ? 'Tambah Dokter' : 'Edit Dokter';
            deleteDoctorBtn.classList.toggle('hidden', isNew);
            $('#doctorId').value = id || '';
            if (isNew) {
                $('#name').value = '';
                $('#specialty').value = '';
                $('#hospital').value = '';
                $('#education').value = '';
                $('#schedulesList').innerHTML = '';
                addScheduleRow();
            } else {
                const d = doctors.find(x => x.id === id);
                if (!d) return alert('Data tidak ditemukan');
                $('#name').value = d.name || '';
                $('#specialty').value = d.specialty || '';
                $('#hospital').value = d.hospital || '';
                $('#education').value = d.education || '';
                $('#schedulesList').innerHTML = '';
                (d.schedules || []).forEach(s => addScheduleRow(s));
            }
            toggleModal(true);
        }

        deleteDoctorBtn.onclick = () => {
            const id = $('#doctorId').value;
            if (!id) return;
            if (!confirm('Yakin ingin menghapus dokter ini?')) return;
            doctors = doctors.filter(x => x.id !== id);
            saveData(doctors);
            renderTable();
            toggleModal(false);
        };

        doctorForm.onsubmit = (ev) => {
            ev.preventDefault();
            const id = $('#doctorId').value || ('d' + Date.now());
            const updated = {
                id,
                name: $('#name').value.trim(),
                specialty: $('#specialty').value.trim(),
                hospital: $('#hospital').value.trim(),
                education: $('#education').value.trim(),
                schedules: readSchedulesFromUI()
            };

            const idx = doctors.findIndex(x => x.id === id);
            if (idx >= 0) doctors[idx] = updated;
            else doctors.unshift(updated);

            saveData(doctors);
            renderTable();
            toggleModal(false);
        };

        // ---------- Schedule UI ----------
        const scheduleTpl = $('#scheduleRowTpl');

        function addScheduleRow(data = {
            day: 'Senin',
            start: '09:00',
            end: '12:00'
        }) {
            const clone = scheduleTpl.content.firstElementChild.cloneNode(true);
            const day = clone.querySelector('.day');
            const start = clone.querySelector('.start');
            const end = clone.querySelector('.end');
            const removeBtn = clone.querySelector('.removeRow');

            day.value = data.day || 'Senin';
            start.value = data.start || '09:00';
            end.value = data.end || '12:00';

            removeBtn.onclick = () => clone.remove();
            $('#schedulesList').appendChild(clone);
        }

        function readSchedulesFromUI() {
            const rows = $$('#schedulesList > div');
            return rows.map(r => {
                return {
                    day: r.querySelector('.day').value,
                    start: r.querySelector('.start').value,
                    end: r.querySelector('.end').value
                };
            }).filter(s => s.day && s.start && s.end);
        }

        $('#addScheduleRow').onclick = () => addScheduleRow();

        // ---------- Search / filter ----------
        searchInput.oninput = () => renderTable();
        filterHospital.onchange = () => {
            const v = filterHospital.value;
            if (!v) {
                renderTable();
                return;
            }
            const q = searchInput.value.trim().toLowerCase();
            doctorsTbody.innerHTML = '';
            const filtered = doctors.filter(d => d.hospital === v && (!q || d.name.toLowerCase().includes(q) || (d.specialty || '').toLowerCase().includes(q)));
            filtered.forEach((d, i) => {
                const tr = document.createElement('tr');
                tr.className = i % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                tr.innerHTML = `
          <td class="p-3 border-b align-top">${i+1}</td>
          <td class="p-3 border-b align-top"><div class="font-medium">${escapeHtml(d.name)}</div></td>
          <td class="p-3 border-b align-top">${escapeHtml(d.specialty || '')}</td>
          <td class="p-3 border-b align-top">${escapeHtml(d.hospital || '')}</td>
          <td class="p-3 border-b align-top">${renderSchedulesInline(d.schedules)}</td>
          <td class="p-3 border-b align-top">${escapeHtml(d.education || '')}</td>
          <td class="p-3 border-b align-top">
            <div class="flex gap-2">
              <button class="editBtn bg-yellow-100 text-yellow-800 px-3 py-1 rounded text-sm" data-id="${d.id}"><i class="ri-edit-line"></i> Edit</button>
              <button class="deleteBtn bg-red-100 text-red-700 px-3 py-1 rounded text-sm" data-id="${d.id}"><i class="ri-delete-bin-line"></i> Hapus</button>
            </div>
          </td>
        `;
                doctorsTbody.appendChild(tr);
            });
            attachRowButtons();
        };

        // ---------- Init ----------
        function init() {
            renderTable();
            populateHospitalFilter();
        }

        init();
    </script>
</body>

</html>