<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Barang/Index', [
            'semuaBarang' => Barang::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Barang/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $barang = Barang::create($request->all());

        return redirect(route('barang.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        return $barang;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        return inertia('Barang/Edit', [
            'barang' => $barang,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $barang->update($request->all());

        return redirect(route('barang.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        try {
            $barang->delete();
        } catch (QueryException $e) {
            return redirect(route('barang.index'))->withErrors(['barang' => 'Barang yang pernah dibeli tidak dapat dihapus!']);
        }

        return redirect(route('barang.index'));
    }
}
