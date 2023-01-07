<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    public function render()
    {
        return view('admin.layouts.app');
    }
}
