<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class ResourceTable extends Component
{
    public $resource;
    public $resources;
    public $columns;

    public function mount($options)
    {
        $this->resource = 'App\\' . Str::studly(Str::singular($options['resource']));

        $this->columns = $options['columns'];
    }

    public function render()
    {
        $this->resources = $this->resource::limit(10)->get();

        return view('livewire.resource-table');
    }
}
