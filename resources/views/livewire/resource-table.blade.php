<div>
    <div class="flex items-center justify-between">
        <input type="text" wire:model="query">
        <select wire:model="limit">
            @foreach ($limits as $limit)
                <option value="{{ $limit }}">
                    {{ $limit }}
                </option>
            @endforeach
        </select>
    </div>

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

    <div>
        <button wire:click="previous" type="button">previous</button>
        <button wire:click="next" type="button">next</button>
    </div>
</div>
