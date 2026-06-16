<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BudgetDropdown extends Component
{
    public $budget;
    public ?string $color;
    public ?string $hoverColor;

    /**
     * Create a new component instance.
     */
    public function __construct($budget, ?string $color = null, ?string $hoverColor = null)
    {
        $this->budget = $budget;
        $this->color = $color;
        $this->hoverColor = $hoverColor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.budget-dropdown');
    }
}
