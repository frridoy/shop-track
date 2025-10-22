<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusToggle extends Component
{
    public $id;
    public $status;
    public $route;

    public function __construct($id, $status, $route)
    {
        $this->id = $id;
        $this->status = $status;
        $this->route = $route;
    }

    public function render()
    {
        return view('components.status-toggle');
    }
}
