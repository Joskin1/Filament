<div class="bg-white rounded-xl p-6 shadow">
    <h1 class="text-2xl font-semibold text-blue-700 mb-4">
        Post Table
        <x-filament::badge size="xl" color="blue" icon="heroicon-m-sparkles">
            POST TABLE
        </x-filament::badge>
    </h1>

    <div class="overflow-x-auto">
        {{ $this->table }}
    </div>

    <p class="mt-4 text-gray-600">
        This is my Filament Table in Livewire.
    </p>

    @livewire(\App\Livewire\Postwidget::class)
</div>