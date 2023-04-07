<div>
    <form wire:submit.prevent="submit">
        <div class="flex items-center mb-4 space-x-2">
            <input id="default-checkbox" type="checkbox" wire:model="isAnnonyous"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Post as
                Annonyous ?</label>

            <div class="">
                <input id="default-checkbox" type="checkbox" wire:model="agree" required
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">

                    I agree to <a target="_blank" href="{{ route('terms.show') }}"" class=" underline text-sm
                        text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500
                        dark:focus:ring-offset-gray-800"> the
                        Terms of Service</a>
                    and

                    <a target="_blank" href="{{ route('policy.show') }}"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-gray-800">
                        Privacy Policy</a>


                </label>
            </div>
        </div>
        {{ $this->form }}
        <div class="flex items-center justify-end mt-4 ">
            <x-primary-button>
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</div>