<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Posts') }}
        </h2>
        @if ($department->name)
        <div class="flex items-center space-x-4">
            <h3 class="dark:text-white text-gray-800">Department : <span
                    class="dark:text-sky-500 text-sky-700 font-medium"> {{ $department->name }} </span> |
            </h3>
            @else
            <div>
                <h3 class="dark:text-white text-gray-800 text-lg"> You are not yet assigned to a department. please
                    contact
                    to the Admin</h3>
            </div>
            @endif
            @if ($department->qaCoordinator)
            <h4 class="dark:text-gray-300 text-sm"> QAC : <span class="dark:text-sky-500 text-sky-700 font-medium"> {{
                    $department->qaCoordinator->name }} </span></h4>
            @else
            <div>
                <h3 class="dark:text-white text-gray-800 text-lg"> Your department has no QAC yet, please contact to the
                    Admin</h3>
            </div>
            @endif
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-gray-900 dark:text-white">
                @livewire('dashboard.index')
            </div>

        </div>
    </div>
</x-app-layout>