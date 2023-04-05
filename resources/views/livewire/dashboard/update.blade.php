<div>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <div class="flex items-center justify-end mt-4 ">
            <x-primary-button>
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>
</div>