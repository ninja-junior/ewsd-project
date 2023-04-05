<div class="p-2 mb-2">
    <div class="flex items-center justify-end ">
        @if ($this->isClosureDate)
        <x-secondary-button wire:click="createPage">
            {{ __('Create') }}
        </x-secondary-button>

        @endif
    </div>

    <div class="mt-2">
        {{ $this->table }}
    </div>
</div>