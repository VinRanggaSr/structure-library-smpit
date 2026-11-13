<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public function __construct(
        public array $nav = [],
        public ?string $title = null,
        /** Halaman tanpa header & pembungkus konten, dipakai pilih peran dan login. */
        public bool $polos = false,
    ) {}

    public function render(): View
    {
        return view('layouts.app');
    }
}
