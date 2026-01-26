<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Ckeditor extends Component
{
    public string $name;
    public ?string $value;
    public string $id;

    public function __construct(
        string $name = 'content',
        ?string $value = '',
        string $id = 'editor'
    ) {
        $this->name = $name;
        $this->value = $value ?? '';
        $this->id = $id;
    }

    public function render()
    {
        return view('components.ckeditor');
    }
}
