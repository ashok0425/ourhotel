<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SEO extends Component
{
    public $seo;
    public $route;

    /**
     * Create a new component instance.
     */
    public function __construct($seo=null,$route=null)
    {
        $this->seo=$seo;
        $this->route=$route;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.s-e-o');
    }
}
