<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemBukuRequest;
use App\Http\Requests\UpdateItemBukuRequest;
use Illuminate\Http\RedirectResponse;

/** Item buku adalah eksemplar fisik dari satu judul; dikelola dari halaman detail buku. */
class ItemBukuController extends Controller
{
    public function store(StoreItemBukuRequest $request, int $buku): RedirectResponse
    {
        return redirect()->route('admin.buku.show', $buku);
    }

    public function update(UpdateItemBukuRequest $request, int $buku, int $itemBuku): RedirectResponse
    {
        return redirect()->route('admin.buku.show', $buku);
    }

    public function destroy(int $buku, int $itemBuku): RedirectResponse
    {
        return redirect()->route('admin.buku.show', $buku);
    }
}
