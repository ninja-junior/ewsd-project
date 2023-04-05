<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-200">

            <div class="p-4 text-gray-900 dark:text-white">
                @livewire('dashboard.update',['post'=>$post])
            </div>

        </div>
    </div>
</x-app-layout>