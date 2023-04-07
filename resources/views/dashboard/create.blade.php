<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Creat post') }}
        </h2>
    </x-slot>

    <div class="py-2">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 overflow-hidden">

            <div class="p-6 text-gray-900 dark:text-white">
                @if($department->name && $department->qaCoordinator)
                @livewire('dashboard.create')
                @else
                <div>
                    <h3 class="dark:text-white text-gray-800 text-lg"> You are not yet assigned to a department or not
                        QAC please
                        contact
                        to the Admin</h3>
                </div>
                @endif

            </div>
        </div>
    </div>

</x-app-layout>