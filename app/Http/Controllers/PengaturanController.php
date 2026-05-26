<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = \App\Models\Pengaturan::first();
        return view('pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'persen_core' => 'required|numeric|min:0|max:100',
            'persen_secondary' => 'required|numeric|min:0|max:100',
        ]);

        if ($request->persen_core + $request->persen_secondary != 100) {
            return back()->with('error', 'Total Core dan Secondary Factor harus berjumlah 100%.');
        }

        $pengaturan = \App\Models\Pengaturan::first();
        if (!$pengaturan) {
            $pengaturan = new \App\Models\Pengaturan();
        }

        $pengaturan->persen_core = $request->persen_core;
        $pengaturan->persen_secondary = $request->persen_secondary;
        $pengaturan->save();

        return back()->with('success', 'Pengaturan bobot NCF & NSF berhasil diperbarui.');
    }
}
