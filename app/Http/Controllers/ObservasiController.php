<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Observasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObservasiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::with('observasi')->get();
        return view('observasi.index', compact('pegawais'));
    }

    public function edit(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $observasi = Observasi::where('id_pegawai', $id)->first();
        
        return view('observasi.edit', compact('pegawai', 'observasi'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nilai_inisiatif' => 'required|numeric|min:1|max:5',
            'nilai_kerjasama' => 'required|numeric|min:1|max:5',
        ]);

        Observasi::updateOrCreate(
            ['id_pegawai' => $id],
            [
                'id_penilai' => Auth::id() ?? 1, // Fallback ke 1 jika Auth belum berjalan
                'nilai_inisiatif' => $request->nilai_inisiatif,
                'nilai_kerjasama' => $request->nilai_kerjasama,
            ]
        );

        return redirect()->route('observasi.index')->with('success', 'Data Observasi pegawai berhasil diperbarui.');
    }
}
