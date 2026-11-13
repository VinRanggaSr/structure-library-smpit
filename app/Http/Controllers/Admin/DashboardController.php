<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\ContohDashboard;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $mulai = $request->date('start') ?? today()->subMonths(5)->startOfMonth();
        $sampai = $request->date('end') ?? today();

        return view('admin.dashboard', [
            'mulai' => $mulai,
            'sampai' => $sampai,
            'rentangCepat' => ContohDashboard::rentangCepat(),
            'aktivitas' => ContohDashboard::aktivitas(),
        ]);
    }
}
