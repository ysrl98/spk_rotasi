<?php

namespace App\Http\Controllers;

use App\Models\TargetProfil;
use App\Models\Jabatan;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class TargetProfilController extends Controller
{
    public function index()
    {
        // Untuk kemudahan, kita ambil semua data target profil
        // Nantinya kita bisa tambahkan relasi di model TargetProfil
        $targetProfils = TargetProfil::all();
        $jabatans = Jabatan::all();
        $kriterias = Kriteria::all();
        
        return view('target-profil.index', compact('targetProfils', 'jabatans', 'kriterias'));
    }

    public function create()
    {
        $jabatans = Jabatan::all();
        $kriterias = Kriteria::all();
        return view('target-profil.create', compact('jabatans', 'kriterias'));
    }

    public function store(Request $request)
    {
        TargetProfil::create($request->all());
        return redirect()->route('target-profil.index')->with('success', 'Target Profil berhasil ditambah.');
    }

    public function edit(TargetProfil $target_profil)
    {
        $jabatans = Jabatan::all();
        $kriterias = Kriteria::all();
        return view('target-profil.edit', compact('target_profil', 'jabatans', 'kriterias'));
    }

    public function update(Request $request, TargetProfil $target_profil)
    {
        $target_profil->update($request->all());
        return redirect()->route('target-profil.index')->with('success', 'Target Profil berhasil diupdate.');
    }

    public function destroy(TargetProfil $target_profil)
    {
        $target_profil->delete();
        return redirect()->route('target-profil.index')->with('success', 'Target Profil berhasil dihapus.');
    }
}
