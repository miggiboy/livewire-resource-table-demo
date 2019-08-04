<div class="table">
    @foreach ($resources as $resource)
        <div class="table-row">
            {{ $resource->name }}
        </div>
    @endforeach
</div>
