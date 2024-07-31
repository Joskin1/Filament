<div class="container mx-auto p-4">
    @livewire(\App\Livewire\MyWidget::class)
    @livewire(\App\Livewire\PostWidget::class)


    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Create New Post</h2>
        <form wire:submit.prevent="create" class="space-y-6">
            {{ $this->form }}

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Submit
                </button>
            </div>
        </form>
        <x-filament-actions::modals />

    </div>

</div>
