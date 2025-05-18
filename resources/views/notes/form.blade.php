<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($note) ? __('Edit Note') : __('Create Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ isset($note) ? route('notes.update', $note) : route('notes.store') }}" class="space-y-6">
                    @csrf
                    @if(isset($note))
                        @method('PUT')
                    @endif

                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $note->title ?? '')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <x-input-label for="content" :value="__('Content')" />
                        <textarea id="content" name="content" rows="10"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                            required>{{ old('content', $note->content ?? '') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ isset($note) ? __('Update Note') : __('Create Note') }}</x-primary-button>
                        <a href="{{ route('notes.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 