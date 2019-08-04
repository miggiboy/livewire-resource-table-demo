<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class ResourceTable extends Component
{
    public $resource;
    public $resources;
    public $columns;
    public $offset = 0;
    public $limit = 10;

    public function mount($options)
    {
        $this->resource = 'App\\' . Str::studly(Str::singular($options['resource']));

        $this->columns = $options['columns'];
    }

    public function next()
    {
        $this->offset += $this->limit;
    }

    public function render()
    {
        $this->resources = $this->resource::offset($this->offset)->limit($this->limit)->get();

        return view('livewire.resource-table');
    }
}
