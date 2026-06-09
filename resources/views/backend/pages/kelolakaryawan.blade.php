@extends('backend.layouts.app')

@section('title', 'Kelola Karyawan')

@section('content')
    <div id="appBody">
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobile()"></div>
        <div class="main" id="mainContent">
            {{-- Toast Container --}}
            <div id="toast-container" class="fixed bottom-6 right-6 z-[99999] flex flex-col gap-2"></div>

            {{-- Page Header --}}
            <div class="topbar" style="margin-bottom: 24px;">
                <div class="topbar-left">
                    <div class="page-title">
                        <h2>@yield('page_title', 'Kelola Karyawan')</h2>
                        <p>Manajemen data seluruh karyawan perusahaan</p>
                    </div>
                </div>
                <div class="topbar-right">
                    <button
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-all active:scale-95 shadow-sm hover:shadow-md"
                        onclick="openModal('modal-form')">
                        <i class="fas fa-plus"></i> Tambah Karyawan
                    </button>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="flex flex-wrap gap-4 mb-6 mx-2">
                <div
                    class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div
                        class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-slate-900 leading-none">{{ $karyawans->total() ?? 0 }}</div>
                        <div class="text-xs text-slate-500 mt-1">Total Karyawan</div>
                    </div>
                </div>
                <div
                    class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div
                        class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-slate-900 leading-none">
                            {{ $karyawans->where('status', 'aktif')->count() ?? 0 }}
                        </div>
                        <div class="text-xs text-slate-500 mt-1">Aktif</div>
                    </div>
                </div>
                <div
                    class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div
                        class="w-11 h-11 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-slate-900 leading-none">{{ $totalDepartemen ?? 0 }}</div>
                        <div class="text-xs text-slate-500 mt-1">Departemen</div>
                    </div>
                </div>
                <div
                    class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div
                        class="w-11 h-11 rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-user-times"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-slate-900 leading-none">
                            {{ $karyawans->where('status', 'nonaktif')->count() ?? 0 }}
                        </div>
                        <div class="text-xs text-slate-500 mt-1">Nonaktif</div>
                    </div>
                </div>
            </div>

            {{-- Main Table Card --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden flex flex-col flex-1 mx-2">
                {{--Card Header --}}
                <div class="flex items-center justify-between flex-wrap gap-3 px-5 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-800 m-0">
                        <i class="fas fa-table text-blue-700 mr-1.5"></i>Daftar Karyawan
                    </h2>
                    <div class="flex flex-wrap gap-2 items-center">
                        {{-- Search --}}
                        <div class="relative">
                            <i
                                class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                            <input type="text" id="searchInput" placeholder="Cari nama / NIP…" oninput="filterTable()"
                                class="pl-8 pr-3 py-1.5 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none w-52 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                        </div>
                        {{-- Filter Departemen --}}
                        <select id="filterDept" onchange="filterTable()"
                            class="px-2.5 py-1.5 border border-slate-200 rounded-lg text-sm text-slate-700 bg-white outline-none focus:border-blue-600 cursor-pointer">
                            <option value="">Semua Departemen</option>
                            <option value="Baker">Baker</option>
                            <option value="Kasir">Kasir</option>
                            <option value="Driver">Driver</option>
                            @foreach($departements ?? [] as $d)
                                <option value="{{ $d->nama }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                        {{-- Filter Status --}}
                        <select id="filterStatus" onchange="filterTable()"
                            class="px-2.5 py-1.5 border border-slate-200 rounded-lg text-sm text-slate-700 bg-white outline-none focus:border-blue-600 cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                        <button onclick="exportData()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-all">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse" id="karyawanTable">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left w-12">
                                    #</th>
                                <th class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left cursor-pointer select-none hover:text-blue-700 whitespace-nowrap"
                                    onclick="sortTable(1)">Karyawan <i class="fas fa-sort opacity-40"></i></th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                    NIP</th>
                                <th class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left cursor-pointer select-none hover:text-blue-700 whitespace-nowrap"
                                    onclick="sortTable(3)">Departemen <i class="fas fa-sort opacity-40"></i></th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                    Jabatan</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                    Tanggal Masuk</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                    Status</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-center w-28">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($karyawans ?? [] as $i => $k)
                                <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors"
                                    data-dept="{{ $k->departemen }}" data-status="{{ $k->status }}">
                                    <td class="px-4 py-3 text-xs text-slate-400">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <div
                                                class="w-9 h-9 rounded-full bg-blue-50 text-blue-700 font-bold text-xs flex items-center justify-center shrink-0 overflow-hidden">
                                                @if($k->foto)
                                                    <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    {{ strtoupper(substr($k->nama, 0, 2)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-semibold text-slate-900 text-sm">{{ $k->nama }}</div>
                                                <div class="text-xs text-slate-400">{{ $k->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $k->nip }}</td>
                                    <td class="px-4 py-3"><span
                                            class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">{{ $k->departemen }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-700">{{ $k->jabatan }}</td>
                                    <td class="px-4 py-3 text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($k->tanggal_masuk)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($k->status === 'aktif')
                                            <span
                                                class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                <i class="fas fa-circle text-[6px] align-middle mr-1"></i>Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-600">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button title="Detail" onclick='viewKaryawan(@json($k))'
                                                class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-emerald-50 hover:border-emerald-300 hover:text-emerald-700 transition-all cursor-pointer">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button title="Edit" onclick='editKaryawan(@json($k))'
                                                class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 transition-all cursor-pointer">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button title="Hapus" onclick="confirmDelete({{ $k->id }},'{{ $k->nama }}')"
                                                class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-all cursor-pointer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyRow">
                                    <td colspan="8" class="h-96 text-center align-middle">
                                        <div class="flex flex-col items-center justify-center gap-2 text-slate-400">
                                            <i class="fas fa-user-slash text-4xl"></i>
                                            <p class="text-sm">Belum ada data karyawan.<br>Klik <strong>Tambah Karyawan</strong>
                                                untuk memulai.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div id="emptyFilter" class="hidden py-16 text-center text-slate-400">
                        <i class="fas fa-filter text-4xl block mb-3"></i>
                        <p class="text-sm">Tidak ada karyawan yang cocok dengan filter.</p>
                    </div>
                </div>

                {{-- Pagination --}}
                @if(isset($karyawans) && $karyawans->hasPages())
                    <div
                        class="flex items-center justify-between flex-wrap gap-2.5 px-5 py-3.5 border-t border-slate-100 text-xs text-slate-500">
                        <span>Menampilkan {{ $karyawans->firstItem() }}–{{ $karyawans->lastItem() }} dari
                            {{ $karyawans->total() }}
                            karyawan</span>
                        <div class="flex gap-1">
                            @if($karyawans->onFirstPage())
                                <button disabled
                                    class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-400 opacity-40 cursor-not-allowed"><i
                                        class="fas fa-chevron-left"></i></button>
                            @else
                                <a href="{{ $karyawans->previousPageUrl() }}"
                                    class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-slate-100 transition-colors"><i
                                        class="fas fa-chevron-left"></i></a>
                            @endif
                            @foreach($karyawans->getUrlRange(1, $karyawans->lastPage()) as $page => $url)
                                <a href="{{ $url }}"
                                    class="w-7 h-7 rounded-lg border flex items-center justify-center text-xs font-semibold transition-colors {{ $karyawans->currentPage() === $page ? 'bg-blue-700 text-white border-blue-700' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-100' }}">{{ $page }}</a>
                            @endforeach
                            @if($karyawans->hasMorePages())
                                <a href="{{ $karyawans->nextPageUrl() }}"
                                    class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-slate-100 transition-colors"><i
                                        class="fas fa-chevron-right"></i></a>
                            @else
                                <button disabled
                                    class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-400 opacity-40 cursor-not-allowed"><i
                                        class="fas fa-chevron-right"></i></button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>


            {{-- ══════════════════════════════════════════
            MODAL: TAMBAH / EDIT KARYAWAN
            ══════════════════════════════════════════ --}}
            <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-[9999] p-4 opacity-0 pointer-events-none transition-opacity duration-200"
                id="modal-form" onclick="closeOnBackdrop(event,'modal-form')">
                <div
                    class="bg-white rounded-2xl w-full max-w-lg shadow-2xl max-h-[90vh] overflow-y-auto translate-y-4 scale-[.98] transition-transform duration-200">
                    <div
                        class="flex items-center justify-between px-5 py-4 border-b border-slate-100 sticky top-0 bg-white z-10">
                        <span class="font-bold text-slate-900 text-base" id="formModalTitle">Tambah Karyawan</span>
                        <button onclick="closeModal('modal-form')"
                            class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-sm text-slate-500 hover:bg-slate-100 transition-colors"><i
                                class="fas fa-times"></i></button>
                    </div>

                    <form method="POST" id="karyawanForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        <input type="hidden" name="id" id="formId">

                        <div class="p-5 space-y-4">
                            {{-- Foto --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Foto Karyawan</label>
                                <div class="flex items-center gap-3.5">
                                    <div onclick="document.getElementById('fotoInput').click()"
                                        class="w-14 h-14 rounded-full border-2 border-dashed border-slate-300 bg-slate-50 flex items-center justify-center overflow-hidden shrink-0 cursor-pointer">
                                        <img id="fotoPreview" src="" alt="" class="w-full h-full object-cover hidden">
                                        <i class="fas fa-camera text-slate-300 text-xl" id="fotoIcon"></i>
                                    </div>
                                    <div>
                                        <button type="button" onclick="document.getElementById('fotoInput').click()"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-all">
                                            <i class="fas fa-upload"></i> Pilih Foto
                                        </button>
                                        <p class="text-xs text-slate-400 mt-1">JPG, PNG maks 2MB</p>
                                    </div>
                                    <input type="file" id="fotoInput" name="foto" accept="image/*" class="hidden"
                                        onchange="previewFoto(this)">
                                </div>
                            </div>

                            {{-- Grid Fields --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap <span
                                            class="text-red-600 ml-0.5">*</span></label>
                                    <input type="text" name="nama" id="fNama" placeholder="Nama lengkap karyawan" required
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all bg-white box-border">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">NIP <span
                                            class="text-red-600 ml-0.5">*</span></label>
                                    <input type="text" name="nip" id="fNip" placeholder="Nomor Induk Pegawai" required
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all bg-white box-border">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email <span
                                            class="text-red-600 ml-0.5">*</span></label>
                                    <input type="email" name="email" id="fEmail" placeholder="email@perusahaan.com" required
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all bg-white box-border">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">No. Telepon</label>
                                    <input type="text" name="telepon" id="fTelepon" placeholder="08xxxxxxxxxx"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all bg-white box-border">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Departemen <span
                                            class="text-red-600 ml-0.5">*</span></label>
                                    <select name="departemen" id="fDepartemen" required
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all bg-white box-border">
                                        <option value="">— Pilih Departemen —</option>
                                        <option value="Baker">Baker</option>
                                        <option value="Kasir">Kasir</option>
                                        <option value="Driver">Driver</option>
                                        @foreach($departements ?? [] as $d)
                                            <option value="{{ $d->nama }}">{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jabatan <span
                                            class="text-red-600 ml-0.5">*</span></label>
                                    <input type="text" name="jabatan" id="fJabatan" placeholder="Jabatan / posisi" required
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all bg-white box-border">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Masuk <span
                                            class="text-red-600 ml-0.5">*</span></label>
                                    <input type="date" name="tanggal_masuk" id="fTglMasuk" required
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all bg-white box-border">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status <span
                                            class="text-red-600 ml-0.5">*</span></label>
                                    <select name="status" id="fStatus" required
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all bg-white box-border">
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Password Login <span
                                            class="text-red-600 ml-0.5">*</span></label>
                                    <input type="password" name="password" id="fPassword" placeholder="Password untuk login"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all bg-white box-border">
                                    <p class="text-xs text-slate-400 mt-1">Kosongkan jika tidak ingin mengubah password
                                        (saat edit)</p>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat</label>
                                    <textarea name="alamat" id="fAlamat" rows="2" placeholder="Alamat lengkap"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all bg-white box-border"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2.5 px-5 py-4 border-t border-slate-100">
                            <button type="button" onclick="closeModal('modal-form')"
                                class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">Batal</button>
                            <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-all active:scale-95">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            {{-- ══════════════════════════════════════════
            MODAL: DETAIL KARYAWAN
            ══════════════════════════════════════════ --}}
            <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-[9999] p-4 opacity-0 pointer-events-none transition-opacity duration-200"
                id="modal-detail" onclick="closeOnBackdrop(event,'modal-detail')">
                <div
                    class="bg-white rounded-2xl w-full max-w-lg shadow-2xl max-h-[90vh] overflow-y-auto translate-y-4 scale-[.98] transition-transform duration-200">
                    <div
                        class="flex items-center justify-between px-5 py-4 border-b border-slate-100 sticky top-0 bg-white z-10">
                        <span class="font-bold text-slate-900 text-base">Detail Karyawan</span>
                        <button onclick="closeModal('modal-detail')"
                            class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-sm text-slate-500 hover:bg-slate-100"><i
                                class="fas fa-times"></i></button>
                    </div>
                    <div class="p-5">
                        <div class="text-center mb-5">
                            <div id="detailAvatar"
                                class="w-16 h-16 rounded-full bg-blue-50 text-blue-700 font-bold text-xl flex items-center justify-center mx-auto mb-2.5 overflow-hidden">
                            </div>
                            <div class="font-bold text-lg text-slate-900" id="detailNama"></div>
                            <div class="text-xs text-slate-400" id="detailJabatan"></div>
                        </div>
                        <div id="detailRows"></div>
                    </div>
                    <div class="flex justify-end gap-2.5 px-5 py-4 border-t border-slate-100">
                        <button onclick="closeModal('modal-detail')"
                            class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">Tutup</button>
                        <button id="btnEditFromDetail"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-all active:scale-95"><i
                                class="fas fa-pen"></i> Edit</button>
                    </div>
                </div>
            </div>


            {{-- ══════════════════════════════════════════
            MODAL: KONFIRMASI HAPUS
            ══════════════════════════════════════════ --}}
            <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-[9999] p-4 opacity-0 pointer-events-none transition-opacity duration-200"
                id="modal-delete" onclick="closeOnBackdrop(event,'modal-delete')">
                <div
                    class="bg-white rounded-2xl w-full max-w-sm shadow-2xl translate-y-4 scale-[.98] transition-transform duration-200">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                        <span class="font-bold text-slate-900 text-base">Konfirmasi Hapus</span>
                        <button onclick="closeModal('modal-delete')"
                            class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-sm text-slate-500 hover:bg-slate-100"><i
                                class="fas fa-times"></i></button>
                    </div>
                    <div class="text-center px-5 py-6">
                        <div
                            class="w-14 h-14 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-2xl mx-auto mb-3.5">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                        <strong id="deleteNama" class="text-base text-slate-900"></strong>
                        <p class="text-sm text-slate-600 mt-2">Data karyawan ini akan dihapus secara permanen dan tidak
                            dapat
                            dikembalikan.</p>
                    </div>
                    <div class="flex justify-end gap-2.5 px-5 py-4 border-t border-slate-100">
                        <button onclick="closeModal('modal-delete')"
                            class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">Batal</button>
                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-all active:scale-95"><i
                                    class="fas fa-trash"></i> Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        /* ── Modal helpers ── */
        function openModal(id) {
            const el = document.getElementById(id);
            el.classList.remove('opacity-0', 'pointer-events-none');
            el.querySelector('div')?.classList.remove('translate-y-4', 'scale-[.98]');
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            const el = document.getElementById(id);
            el.classList.add('opacity-0', 'pointer-events-none');
            el.querySelector('div')?.classList.add('translate-y-4', 'scale-[.98]');
            document.body.style.overflow = '';
        }
        function closeOnBackdrop(e, id) { if (e.target === document.getElementById(id)) closeModal(id); }

        /* ── Toast ── */
        function showToast(msg, type = 'success') {
            const tc = document.getElementById('toast-container');
            const ic = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            const border = type === 'success' ? 'border-l-4 border-teal-500' : 'border-l-4 border-red-500';
            const t = document.createElement('div');
            t.className = `flex items-center gap-3 bg-slate-900 text-white px-4 py-3 rounded-xl text-sm shadow-lg min-w-[240px] ${border} animate-[slideUp_.25s_ease]`;
            t.innerHTML = `<i class="fas ${ic} shrink-0"></i><span>${msg}</span>`;
            tc.appendChild(t);
            setTimeout(() => t.remove(), 3500);
        }
        @if(session('success')) showToast("{{ session('success') }}", 'success'); @endif
        @if(session('error'))   showToast("{{ session('error') }}", 'error'); @endif

        /* ── Tambah: reset form ── */
        document.querySelector('[onclick="openModal(\'modal-form\')"]').addEventListener('click', function () {
            resetForm();
            document.getElementById('formModalTitle').textContent = 'Tambah Karyawan';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('karyawanForm').action = '{{ route("karyawan.store") }}';
            openModal('modal-form');
        });

        function resetForm() {
            document.getElementById('karyawanForm').reset();
            document.getElementById('formId').value = '';
            document.getElementById('fotoPreview').classList.add('hidden');
            document.getElementById('fotoIcon').style.display = '';
        }

        /* ── Edit ── */
        function editKaryawan(k) {
            document.getElementById('formModalTitle').textContent = 'Edit Karyawan';
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('karyawanForm').action = `/kelola-karyawan/${k.id}`;
            document.getElementById('formId').value = k.id;
            document.getElementById('fNama').value = k.nama || '';
            document.getElementById('fNip').value = k.nip || '';
            document.getElementById('fEmail').value = k.email || '';
            document.getElementById('fTelepon').value = k.telepon || '';
            document.getElementById('fDepartemen').value = k.departemen || '';
            document.getElementById('fJabatan').value = k.jabatan || '';
            document.getElementById('fTglMasuk').value = k.tanggal_masuk ? k.tanggal_masuk.substring(0, 10) : '';
            document.getElementById('fStatus').value = k.status || 'aktif';
            document.getElementById('fAlamat').value = k.alamat || '';
            if (k.foto) {
                document.getElementById('fotoPreview').src = `/storage/${k.foto}`;
                document.getElementById('fotoPreview').classList.remove('hidden');
                document.getElementById('fotoIcon').style.display = 'none';
            } else {
                document.getElementById('fotoPreview').classList.add('hidden');
                document.getElementById('fotoIcon').style.display = '';
            }
            openModal('modal-form');
        }

        /* ── Foto preview ── */
        function previewFoto(input) {
            if (!input.files?.[0]) return;
            const r = new FileReader();
            r.onload = e => {
                document.getElementById('fotoPreview').src = e.target.result;
                document.getElementById('fotoPreview').classList.remove('hidden');
                document.getElementById('fotoIcon').style.display = 'none';
            };
            r.readAsDataURL(input.files[0]);
        }

        /* ── Detail ── */
        let _currentKaryawan = null;
        function viewKaryawan(k) {
            _currentKaryawan = k;
            const av = document.getElementById('detailAvatar');
            av.innerHTML = k.foto
                ? `<img src="/storage/${k.foto}" class="w-full h-full object-cover">`
                : k.nama.substring(0, 2).toUpperCase();
            document.getElementById('detailNama').textContent = k.nama;
            document.getElementById('detailJabatan').textContent = `${k.jabatan} · ${k.departemen}`;
            const fields = [
                ['NIP', k.nip], ['Email', k.email], ['Telepon', k.telepon || '—'],
                ['Departemen', k.departemen], ['Jabatan', k.jabatan],
                ['Tanggal Masuk', k.tanggal_masuk ? k.tanggal_masuk.substring(0, 10) : '—'],
                ['Alamat', k.alamat || '—'],
                ['Status', k.status === 'aktif'
                    ? '<span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Aktif</span>'
                    : '<span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-600">Nonaktif</span>'],
            ];
            document.getElementById('detailRows').innerHTML = fields.map(([l, v]) =>
                `<div class="flex gap-2.5 py-2.5 border-b border-slate-100 last:border-0 items-start">
                    <span class="w-32 text-xs font-semibold text-slate-500 shrink-0 pt-0.5">${l}</span>
                    <span class="text-sm text-slate-800 flex-1">${v}</span>
                </div>`
            ).join('');
            document.getElementById('btnEditFromDetail').onclick = () => { closeModal('modal-detail'); editKaryawan(k); };
            openModal('modal-detail');
        }

        /* ── Delete ── */
        function confirmDelete(id, nama) {
            document.getElementById('deleteNama').textContent = nama;
            document.getElementById('deleteForm').action = `/kelola-karyawan/${id}`;
            openModal('modal-delete');
        }

        /* ── Filter / Search ── */
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const dept = document.getElementById('filterDept').value.toLowerCase();
            const status = document.getElementById('filterStatus').value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');
            let visible = 0;
            rows.forEach(row => {
                if (!row.dataset.dept) return;
                const show = row.textContent.toLowerCase().includes(q)
                    && (dept === '' || row.dataset.dept.toLowerCase() === dept)
                    && (status === '' || row.dataset.status.toLowerCase() === status);
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            document.getElementById('emptyFilter').classList.toggle('hidden', visible !== 0);
        }

        /* ── Sort ── */
        function sortTable(col) {
            const tbody = document.getElementById('tableBody');
            const rows = Array.from(tbody.querySelectorAll('tr[data-dept]'));
            const asc = tbody.dataset.sortCol == col ? tbody.dataset.sortDir !== 'asc' : true;
            tbody.dataset.sortCol = col;
            tbody.dataset.sortDir = asc ? 'asc' : 'desc';
            rows.sort((a, b) => {
                const va = a.cells[col]?.textContent.trim() || '';
                const vb = b.cells[col]?.textContent.trim() || '';
                return asc ? va.localeCompare(vb) : vb.localeCompare(va);
            });
            rows.forEach(r => tbody.appendChild(r));
        }

        /* ── Export CSV ── */
        function exportData() {
            const headers = ['Nama', 'NIP', 'Departemen', 'Jabatan', 'Tanggal Masuk', 'Status'];
            const rows = document.querySelectorAll('#tableBody tr[data-dept]');
            let csv = headers.join(',') + '\n';
            rows.forEach(r => {
                if (r.style.display === 'none') return;
                const c = r.cells;
                csv += [
                    `"${c[1].querySelector('.font-semibold')?.textContent.trim() || ''}"`,
                    `"${c[2].textContent.trim()}"`,
                    `"${c[3].textContent.trim()}"`,
                    `"${c[4].textContent.trim()}"`,
                    `"${c[5].textContent.trim()}"`,
                    `"${c[6].textContent.trim()}"`,
                ].join(',') + '\n';
            });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv' }));
            a.download = 'karyawan.csv';
            a.click();
            showToast('Data berhasil diekspor ke CSV');
        }

        /* ── Esc close ── */
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') ['modal-form', 'modal-detail', 'modal-delete'].forEach(closeModal);
        });

        /* ── Keyframes for toast (tidak tersedia di Tailwind default) ── */
        const style = document.createElement('style');
        style.textContent = `@keyframes slideUp { from { transform:translateY(20px); opacity:0 } to { transform:translateY(0); opacity:1 } }`;
        document.head.appendChild(style);
    </script>

@endsection