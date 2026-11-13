<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAturanRequest;
use App\Http\Requests\UpdateAturanRequest;
use App\Support\ContohData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AturanController extends Controller
{
    public function index(): View
    {
        return view('admin.aturan.index', [
            'aturan' => ContohData::halaman(ContohData::aturan()),
        ]);
    }

    public function store(StoreAturanRequest $request): RedirectResponse
    {
        return redirect()->route('admin.aturan.index');
    }

    public function update(UpdateAturanRequest $request, int $aturan): RedirectResponse
    {
        return redirect()->route('admin.aturan.index');
    }

    public function destroy(int $aturan): RedirectResponse
    {
        return redirect()->route('admin.aturan.index');
    }
}
