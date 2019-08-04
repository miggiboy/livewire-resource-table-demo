<div class="table">
    @foreach ($resources as $resource)
        <div class="table-row">
            @foreach ($columns as $heading => $attribute)
                <div class="table-cell">
                    {{ data_get($resource, $attribute) }}
                </div>
            @endforeach
        </div>
    @endforeach
</div>
