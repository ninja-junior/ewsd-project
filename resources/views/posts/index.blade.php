<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="absolute z-20 top-0 inset-x-0 flex justify-center overflow-hidden pointer-events-none">
            <div class="w-[108rem] flex-none flex justify-end">
                <picture>
                    <img src="{{ URL::asset('storage/bg/docs.png') }}" alt=""
                        class="w-[71.75rem] flex-none max-w-none dark:hidden" decoding="async">
                </picture>
                <picture>
                    <img src="{{ URL::asset('storage/bg/docs-dark.png') }}" alt="" class=" w-[90rem] flex-none max-w-none hidden
                        dark:block" decoding="async">
                </picture>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900 dark:text-white">
                @livewire('posts.index')
            </div>

        </div>
    </div>
</x-app-layout>