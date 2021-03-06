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

    public $limits = [ 10, 25, 50, 100 ];
    public $limit = 10;

    public $query;

    public function mount($options)
    {
        $this->resource = 'App\\' . Str::studly(Str::singular($options['resource']));

        $this->columns = $options['columns'];
    }

    public function next()
    {
        if ($this->resource::count() > $this->offset) {
            $this->offset += $this->limit;
        }
    }

    public function previous()
    {
        $this->offset -= $this->limit;

        $this->offset = max(0, $this->offset);
    }

    protected function fetch()
    {
        return $this->resource::when($this->query, function ($query) {
                $query->resourceSearch($this->query);
            })
            ->offset($this->offset)
            ->limit($this->limit)
            ->get();
    }

    public function render()
    {
        $this->resources = $this->fetch();

        return view('livewire.resource-table');
    }
}
