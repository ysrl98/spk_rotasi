<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Arsip;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::with('arsip')->get();
        return view('arsip.index', compact('pegawais'));
    }

    public function edit(string $id)
    {
        // Parameter $id di sini kita asumsikan sebagai id_pegawai untuk kemudahan
        $pegawai = Pegawai::findOrFail($id);
        $arsip = Arsip::where('id_pegawai', $id)->first();
        
        return view('arsip.edit', compact('pegawai', 'arsip'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nilai_pendidikan' => 'required|numeric|min:1|max:5',
            'nilai_masa_kerja' => 'required|numeric|min:1|max:5',
            'nilai_skp' => 'required|numeric|min:1|max:5',
            'nilai_disiplin' => 'required|numeric|min:1|max:5',
        ]);

        Arsip::updateOrCreate(
            ['id_pegawai' => $id],
            [
                'nilai_pendidikan' => $request->nilai_pendidikan,
                'nilai_masa_kerja' => $request->nilai_masa_kerja,
                'nilai_skp' => $request->nilai_skp,
                'nilai_disiplin' => $request->nilai_disiplin,
            ]
        );

        return redirect()->route('arsip.index')->with('success', 'Data Arsip pegawai berhasil diperbarui.');
    }
}
