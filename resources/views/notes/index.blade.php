<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Notes') }}
            </h2>
            <a href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Note
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Form -->
            <form method="GET" action="{{ route('notes.index') }}" class="mb-6">
                <div class="flex gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="pl-10 flex-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm w-full"
                            placeholder="Search notes...">
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition duration-150">
                        Search
                    </button>
                </div>
            </form>

            <!-- Tabs -->
            <div x-data="{ activeTab: 'my-notes' }" class="mb-6">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button
                            @click="activeTab = 'my-notes'"
                            :class="{ 'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === 'my-notes',
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400': activeTab !== 'my-notes' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150">
                            My Notes ({{ $notes->total() }})
                        </button>
                        <button
                            @click="activeTab = 'shared-notes'"
                            :class="{ 'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === 'shared-notes',
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400': activeTab !== 'shared-notes' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150">
                            Shared With Me ({{ $shared->total() }})
                        </button>
                    </nav>
                </div>

                <!-- My Notes Tab -->
                <div x-show="activeTab === 'my-notes'" class="mt-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse ($notes as $note)
                                <div onclick="window.location.href='{{ route('notes.show', $note) }}'" 
                                     class="group bg-white dark:bg-gray-700 rounded-lg shadow p-6 
                                            hover:shadow-xl hover:scale-[1.02] 
                                            hover:bg-gray-50 dark:hover:bg-gray-800
                                            dark:shadow-gray-900
                                            cursor- transform transition-all duration-200 ease-in-out
                                            ring-1 ring-gray-200 dark:ring-gray-700     
                                            hover:ring-yellow-500 dark:hover:ring-yellow-500
                                            flex flex-col min-h-[200px]">
                                    <div class="flex-grow">
                                        <h4 class="text-lg font-semibold mb-3 text-gray-900 dark:text-gray-100 
                                                 group-hover:text-gray-900 dark:group-hover:text-white truncate">{{ $note->title }}</h4>
                                        <p class="text-gray-600 dark:text-gray-300 
                                                 group-hover:text-gray-700 dark:group-hover:text-gray-200 
                                                 mb-4 line-clamp-3 break-words">{{ $note->content }}</p>
                                    </div>
                                    <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-600">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 
                                                     group-hover:text-gray-600 dark:group-hover:text-gray-300">
                                            {{ $note->created_at->diffForHumans() }}
                                        </span>
                                        <span class="text-sm text-blue-600 dark:text-blue-400 
                                                    group-hover:text-blue-700 dark:group-hover:text-blue-300
                                                    flex items-center">
                                            <span>View details</span>
                                            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" 
                                                 fill="none" 
                                                 stroke="currentColor" 
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" 
                                                      stroke-linejoin="round" 
                                                      stroke-width="2" 
                                                      d="M9 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-12">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">No notes</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new note.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md shadow-sm transition duration-150">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            New Note
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-6">
                            {{ $notes->links() }}
                        </div>
                    </div>
                </div>

                <!-- Shared Notes Tab -->
                <div x-show="activeTab === 'shared-notes'" class="mt-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse ($shared as $note)
                                <div onclick="window.location.href='{{ route('notes.show', $note) }}'" 
                                     class="group bg-white dark:bg-gray-700 rounded-lg shadow p-6 
                                            hover:shadow-xl hover:scale-[1.02] 
                                            hover:bg-gray-50 dark:hover:bg-gray-800
                                            dark:shadow-gray-900
                                            cursor-pointer transform transition-all duration-200 ease-in-out
                                            ring-1 ring-gray-200 dark:ring-gray-700
                                            hover:ring-red-500 dark:hover:ring-red-500">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 
                                                   group-hover:text-gray-900 dark:group-hover:text-white">{{ $note->title }}</h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                     {{ $note->pivot->permission === 'edit' ? 
                                                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                                        'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' }}">
                                            @if($note->pivot->permission === 'edit')
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            @endif
                                            {{ ucfirst($note->pivot->permission) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 
                                             group-hover:text-gray-700 dark:group-hover:text-gray-200 
                                             mb-4 line-clamp-3">{{ $note->content }}</p>
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-500 dark:text-gray-400 
                                                    group-hover:text-gray-600 dark:group-hover:text-gray-200">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span>{{ $note->user->name }}</span>
                                            </div>
                                            <div class="flex items-center mt-1">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>{{ $note->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <span class="text-sm text-blue-600 dark:text-blue-400 
                                                    group-hover:text-blue-700 dark:group-hover:text-blue-300">
                                            Click to view details →
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No shared notes</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No notes have been shared with you yet.</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-6">
                            {{ $shared->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 