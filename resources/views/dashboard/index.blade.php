<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Posts') }} - Department ({{ $department }})
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-gray-900 dark:text-white">
                @livewire('dashboard.index')
            </div>

        </div>
    </div>
</x-app-layout>