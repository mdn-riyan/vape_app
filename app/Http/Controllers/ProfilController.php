<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = Auth::user()->load(['roles', 'siswa']);

        return view('profil', [
            'profil'  => $profil,
            'siswa'   => $profil->siswa,   // null untuk Admin/Peneliti/Guest yang belum mengisi
            'isGuest' => $profil->roles->contains('nama_role', 'Guest'),
            'namaRole' => $profil->roles->pluck('nama_role')->join(', ') ?: 'Guest',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $siswa = Auth::user()->siswa;   

        return view('lengkapi_profil', compact('siswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
        'jenis_kelamin'      => 'required|in:Laki-Laki,Perempuan',
        'tanggal_lahir'      => 'required|date|before:today',
        'tingkat_pendidikan' => 'required|in:SD/SMP,SMA/SMK',
        'kelas'              => 'required|string|max:50',
        'whatsapp'           => 'required|string|max:20',
        'foto_profil'        => 'nullable|image|max:5048',
        ]);

        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        Siswa::updateOrCreate(['user_id' => Auth::id()], $data);

        $siswaId = Role::where('nama_role', 'Siswa')->value('id');
        Auth::user()->roles()->sync([$siswaId]);

       return redirect()->route('profil')->with('success', 'Profil berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
