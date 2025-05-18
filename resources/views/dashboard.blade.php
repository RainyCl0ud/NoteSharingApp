<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Total Notes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Total Notes
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                            {{ Auth::user()->notes()->count() }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shared Notes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Shared With Me
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                            {{ Auth::user()->sharedNotes()->count() }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('notes.create') }}" 
                               class="flex items-center text-sm text-gray-700 dark:text-gray-200 p-2 rounded-lg
                                      hover:bg-blue-50 dark:hover:bg-blue-900/30 
                                      hover:text-blue-600 dark:hover:text-blue-300 
                                      transition-all duration-150 ease-in-out
                                      group">
                                <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-150" 
                                     fill="none" 
                                     stroke="currentColor" 
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" 
                                          stroke-linejoin="round" 
                                          stroke-width="2" 
                                          d="M12 4v16m8-8H4" />
                                </svg>
                                Create New Note
                            </a>
                            <a href="{{ route('notes.index') }}" 
                               class="flex items-center text-sm text-gray-700 dark:text-gray-200 p-2 rounded-lg
                                      hover:bg-blue-50 dark:hover:bg-blue-900/30 
                                      hover:text-blue-600 dark:hover:text-blue-300 
                                      transition-all duration-150 ease-in-out
                                      group">
                                <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-150" 
                                     fill="none" 
                                     stroke="currentColor" 
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" 
                                          stroke-linejoin="round" 
                                          stroke-width="2" 
                                          d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                View All Notes
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Notes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Recent Notes</h3>
                        <a href="{{ route('notes.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">View all</a>
                    </div>
                    <div class="space-y-6">
                        @forelse(Auth::user()->notes()->latest()->take(5)->get() as $note)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="min-w-0 flex-1 mr-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ $note->title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 break-words overflow-hidden line-clamp-2">
                                        {{ Str::limit($note->content, 100) }}
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                                        Last updated {{ $note->updated_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 flex flex-col space-y-2">
                                    <a href="{{ route('notes.show', $note) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-md font-medium text-sm transition duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('notes.edit', $note) }}" class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 hover:bg-green-200 rounded-md font-medium text-sm transition duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">No notes yet.</p>
                                <a href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 mt-3">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Your First Note
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Shared Notes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Recently Shared With Me</h3>
                        <a href="{{ route('notes.index') }}?tab=shared" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">View all</a>
                    </div>
                    <div class="space-y-6">
                        @forelse(Auth::user()->sharedNotes()->latest()->take(3)->get() as $note)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="min-w-0 flex-1 mr-4">
                                    <div class="flex items-center">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ $note->title }}</h4>
                                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $note->pivot->permission === 'edit' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($note->pivot->permission) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 break-words">
                                        Shared by {{ $note->user->name }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('notes.show', $note) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-md font-medium text-sm transition duration-150">
                                        View
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No notes have been shared with you yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
