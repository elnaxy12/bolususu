<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    /* ──────────────────────────────────────────────
     | INDEX — tampilkan daftar karyawan
    ─────────────────────────────────────────────── */
    public function index(Request $request)
    {
        $query = Karyawan::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter departemen
        if ($request->filled('departemen')) {
            $query->where('departemen', $request->departemen);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $karyawans    = $query->latest()->paginate(10)->withQueryString();
        $departements = Departemen::orderBy('nama')->get();
        $totalDepartemen = Karyawan::distinct('departemen')->count('departemen');

         return view('backend.pages.kelolakaryawan', compact('karyawans', 'departements', 'totalDepartemen'));   
    
    }

    /* ──────────────────────────────────────────────
     | STORE — simpan karyawan baru
    ─────────────────────────────────────────────── */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:100',
            'nip'           => 'required|string|max:30|unique:karyawans,nip',
            'email'         => 'required|email|max:100|unique:karyawans,email',
            'telepon'       => 'nullable|string|max:20',
            'departemen'    => 'required|string|max:100',
            'jabatan'       => 'required|string|max:100',
            'tanggal_masuk' => 'required|date',
            'status'        => 'required|in:aktif,nonaktif',
            'alamat'        => 'nullable|string|max:500',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'      => 'required|string|min:6',
        ], $this->messages());

        $password = $validated['password'];
        unset($validated['password']);

        // Upload foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('karyawan', 'public');
        }

        $karyawan = Karyawan::create($validated);

        User::create([
        'nama'     => $karyawan->nama,
        'username'      => $karyawan->nip,
        'email'    => $karyawan->email,
        'password' => Hash::make($request->password),
        'role'     => 'karyawan',

        ]);

        return redirect()->route('karyawan.index')
                         ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /* ──────────────────────────────────────────────
     | SHOW — detail karyawan (opsional, jika perlu halaman tersendiri)
    ─────────────────────────────────────────────── */
    public function show(Karyawan $karyawan)
    {
        return response()->json($karyawan);
    }

    /* ──────────────────────────────────────────────
     | UPDATE — perbarui data karyawan
    ─────────────────────────────────────────────── */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:100',
            'nip'           => ['required', 'string', 'max:30', Rule::unique('karyawans', 'nip')->ignore($karyawan->id)],
            'email'         => ['required', 'email', 'max:100', Rule::unique('karyawans', 'email')->ignore($karyawan->id)],
            'telepon'       => 'nullable|string|max:20',
            'departemen'    => 'required|string|max:100',
            'jabatan'       => 'required|string|max:100',
            'tanggal_masuk' => 'required|date',
            'status'        => 'required|in:aktif,nonaktif',
            'alamat'        => 'nullable|string|max:500',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:6',
        ], $this->messages());


        $user = User::where('email', $karyawan->email)->first();
        if ($user) {
            $user->nama  = $request->nama;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        }


        // Ganti foto jika ada upload baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($karyawan->foto) {
                Storage::disk('public')->delete($karyawan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('karyawan', 'public');
        } else {
            // Jangan overwrite path foto lama
            unset($validated['foto']);
        }


        $password = $validated['password'] ?? null;
        unset($validated['password']);


        $karyawan->update($validated);

        return redirect()->route('karyawan.index')
                         ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /* ──────────────────────────────────────────────
     | DESTROY — hapus karyawan
    ─────────────────────────────────────────────── */
    public function destroy(Karyawan $karyawan)
    {
        User::where('email', $karyawan->email)->delete();
        // Hapus foto dari storage
        if ($karyawan->foto) {
            Storage::disk('public')->delete($karyawan->foto);
        }

        $karyawan->delete();

        return redirect()->route('karyawan.index')
                         ->with('success', 'Karyawan berhasil dihapus.');
    }

    /* ──────────────────────────────────────────────
     | EXPORT CSV — unduh data karyawan
    ─────────────────────────────────────────────── */
    public function export()
    {
        $karyawans = Karyawan::orderBy('nama')->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="karyawan_' . now()->format('Ymd_His') . '.csv"',
        ];

        $callback = function () use ($karyawans) {
            $file = fopen('php://output', 'w');

            // BOM agar Excel baca UTF-8 dengan benar
            fputs($file, "\xEF\xBB\xBF");

            // Header kolom
            fputcsv($file, ['No', 'Nama', 'NIP', 'Email', 'Telepon', 'Departemen', 'Jabatan', 'Tanggal Masuk', 'Status', 'Alamat']);

            foreach ($karyawans as $i => $k) {
                fputcsv($file, [
                    $i + 1,
                    $k->nama,
                    $k->nip,
                    $k->email,
                    $k->telepon,
                    $k->departemen,
                    $k->jabatan,
                    $k->tanggal_masuk,
                    ucfirst($k->status),
                    $k->alamat,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /* ──────────────────────────────────────────────
     | PRIVATE — pesan validasi Bahasa Indonesia
    ─────────────────────────────────────────────── */
    private function messages(): array
    {
        return [
            'nama.required'          => 'Nama lengkap wajib diisi.',
            'nama.max'               => 'Nama maksimal 100 karakter.',
            'nip.required'           => 'NIP wajib diisi.',
            'nip.unique'             => 'NIP sudah digunakan oleh karyawan lain.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email sudah terdaftar.',
            'departemen.required'    => 'Departemen wajib dipilih.',
            'jabatan.required'       => 'Jabatan wajib diisi.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.date'     => 'Format tanggal tidak valid.',
            'status.required'        => 'Status wajib dipilih.',
            'status.in'              => 'Status harus aktif atau nonaktif.',
            'foto.image'             => 'File harus berupa gambar.',
            'foto.mimes'             => 'Format foto harus JPG atau PNG.',
            'foto.max'               => 'Ukuran foto maksimal 2MB.',
        ];
    }
}
