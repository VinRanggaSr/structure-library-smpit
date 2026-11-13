<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use App\Support\ContohData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BukuController extends Controller
{
    public function index(): View
    {
        ContohData::itemBuku();

        return view('admin.buku.index', [
            'buku' => ContohData::buku(),
            'kategori' => ContohData::kategori(),
        ]);
    }

    public function create(): View
    {
        return view('admin.buku.form', [
            'buku' => null,
            'kategori' => ContohData::kategori(),
        ]);
    }

    public function store(StoreBukuRequest $request): RedirectResponse
    {
        return redirect()->route('admin.buku.index');
    }

    public function show(int $buku): View
    {
        return view('admin.buku.show', [
            'buku' => $this->temukan($buku),
        ]);
    }

    public function edit(int $buku): View
    {
        return view('admin.buku.form', [
            'buku' => $this->temukan($buku),
            'kategori' => ContohData::kategori(),
        ]);
    }

    public function update(UpdateBukuRequest $request, int $buku): RedirectResponse
    {
        return redirect()->route('admin.buku.show', $buku);
    }

    public function destroy(int $buku): RedirectResponse
    {
        return redirect()->route('admin.buku.index');
    }

    private function temukan(int $id): Buku
    {
        ContohData::itemBuku();

        return ContohData::buku()->firstWhere('id_buku', $id) ?? abort(404);
    }
}
