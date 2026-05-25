<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::with('jabatan')->get();
        return view('pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        $jabatans = Jabatan::all();
        return view('pegawai.create', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:50|unique:tb_pegawai,nip',
            'nama' => 'required|string|max:100',
            'pangkat' => 'required|string|max:50',
            'golongan' => 'required|string|max:20',
            'id_jabatan' => 'required|exists:tb_jabatan,id'
        ]);

        Pegawai::create($validated);
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit(Pegawai $pegawai)
    {
        $jabatans = Jabatan::all();
        return view('pegawai.edit', compact('pegawai', 'jabatans'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:50|unique:tb_pegawai,nip,' . $pegawai->id,
            'nama' => 'required|string|max:100',
            'pangkat' => 'required|string|max:50',
            'golongan' => 'required|string|max:20',
            'id_jabatan' => 'required|exists:tb_jabatan,id'
        ]);

        $pegawai->update($validated);
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diupdate.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}