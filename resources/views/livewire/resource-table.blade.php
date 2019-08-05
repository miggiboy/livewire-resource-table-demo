<div class="w-full">
    <input
        type="text"
        wire:model="query"
        class="w-64 px-3 py-2 border-2 rounded-lg text-gray-800 text-base leading-normal outline-none mb-6 search-input"
        placeholder="Search"
    >

    <div class="rounded overflow-hidden"  style="box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06)">
        <div class="flex items-center p-5 border-b bg-white rounded-t-lg">
            <select wire:model="limit" class="ml-auto">
                @foreach ($limits as $limit)
                    <option value="{{ $limit }}">
                        {{ $limit }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="table w-full">
            <div class="table-row">
                @foreach ($columns as $heading => $_)
                    <div class="table-cell border-b-2 border-gray-400 bg-gray-200 uppercase tracking-wide text-gray-600 text-sm font-semibold p-5">
                        {{ $heading }}
                    </div>
                @endforeach
            </div>

            @foreach ($resources as $resource)
                <div class="table-row">
                    @foreach ($columns as $heading => $attribute)
                        <div class="table-cell p-5 border-b bg-white">
                            {{ data_get($resource, $attribute) }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="bg-gray-100 flex justify-between p-5">
            <button wire:click="previous" type="button" class="block font-bold text-blue-500">Previous</button>
            <button wire:click="next" type="button" class="block font-bold text-gray-500 text-blue-500">Next</button>
        </div>
    </div>
</div>

<style>
    .table-row:hover .table-cell {
        background-color: #F7FAFC;
    }

    .search-input:focus {
        border: 2px solid #4099de;
    }
</style>
