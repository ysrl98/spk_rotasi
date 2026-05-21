<?php

namespace App\Http\Controllers;

use App\Models\TargetProfil;
use App\Models\Jabatan;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use App\Models\BobotGap;

class BobotGapKontroller extends Controller
{
    public function index()
    {
        $bobotGaps = BobotGap::orderBy('selisih', 'desc')->get();
        return view('bobot-gap.index', compact('bobotGaps'));
    }

    public function create()
    {
        return view('bobot-gap.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'selisih' => 'required|numeric',
            'bobot' => 'required|numeric'
        ]);
        
        BobotGap::create($request->all());
        return redirect()->route('bobot-gap.index')->with('success', 'Bobot GAP berhasil ditambahkan.');
    }

    public function edit(BobotGap $bobot_gap)
    {
        return view('bobot-gap.edit', compact('bobot_gap'));
    }

    public function update(Request $request, BobotGap $bobot_gap)
    {
        $request->validate([
            'selisih' => 'required|numeric',
            'bobot' => 'required|numeric'
        ]);

        $bobot_gap->update($request->all());
        return redirect()->route('bobot-gap.index')->with('success', 'Bobot GAP berhasil diperbarui.');
    }

    public function destroy(BobotGap $bobot_gap)
    {
        $bobot_gap->delete();
        return redirect()->route('bobot-gap.index')->with('success', 'Bobot GAP berhasil dihapus.');
    }
}
