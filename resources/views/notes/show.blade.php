<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ url()->previous() }}" 
                   class="inline-flex items-center justify-center p-2 rounded-md 
                          text-gray-600 dark:text-gray-400
                          hover:text-gray-900 dark:hover:text-gray-200 
                          hover:bg-gray-100 dark:hover:bg-gray-700
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500
                          transition duration-150 ease-in-out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $note->title }}
                </h2>
            </div>
            @if($note->user_id === Auth::id())
                <div class="flex items-center space-x-2">
                    <a href="{{ route('notes.edit', $note) }}" 
                       class="inline-flex items-center justify-center p-2 rounded-md 
                              text-gray-600 dark:text-gray-400
                              hover:text-gray-900 dark:hover:text-gray-200 
                              hover:bg-gray-100 dark:hover:bg-gray-700
                              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500
                              transition duration-150 ease-in-out">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>

                    <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this note?')"
                                class="inline-flex items-center justify-center p-2 rounded-md 
                                       text-red-600 dark:text-red-400
                                       hover:text-red-900 dark:hover:text-red-200 
                                       hover:bg-red-100 dark:hover:bg-red-900/50
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-red-500
                                       transition duration-150 ease-in-out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>

                    <button onclick="document.getElementById('shareModal').classList.remove('hidden')" 
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Share Note
                    </button>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="min-h-screen flex flex-col">
        <div class="flex-grow py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Parent Container -->
                <div class="bg-white dark:bg-gray-800 overflow-visible shadow-sm sm:rounded-lg">
                    <!-- Note Content -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="max-w-3xl mx-auto px-4">
                            <div class="h-[500px] overflow-y-auto overflow-x-hidden rounded-lg bg-gray-50 dark:bg-gray-900/50 p-4">
                                <pre class="text-gray-800 dark:text-gray-100 whitespace-pre-line break-all w-full" style="font-family: inherit; word-wrap: break-word; white-space: pre-wrap;">{{ $note->content }}</pre>
                            </div>
                        </div>
                    </div>

                    <!-- Note Details -->
                    <div class="p-6">
                        <div class="max-w-3xl mx-auto px-4">
                            <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-300">
                                <div>
                                    Created {{ $note->created_at->diffForHumans() }}
                                    @if($note->created_at != $note->updated_at)
                                        • Updated {{ $note->updated_at->diffForHumans() }}
                                    @endif
                                </div>
                            </div>

                            @if($note->user_id === Auth::id())
                                <!-- Shared With List -->
                                <div class="mt-8">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Shared With</h3>
                                    <div class="space-y-4">
                                        @forelse($note->sharedWith as $user)
                                            <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                                <div>
                                                    <span class="text-gray-800 dark:text-gray-100">{{ $user->name }}</span>
                                                    <span class="text-gray-600 dark:text-gray-300 ml-2">({{ $user->email }})</span>
                                                    <span class="ml-2 px-2 py-1 text-xs rounded {{ $user->pivot->permission === 'edit' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100' : 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100' }}">
                                                        {{ ucfirst($user->pivot->permission) }}
                                                    </span>
                                                </div>
                                                <form action="{{ route('notes.unshare', [$note, $user]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-400 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Remove sharing with this user?')">
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>
                                        @empty
                                            <p class="text-gray-600 dark:text-gray-300">This note hasn't been shared with anyone yet.</p>
                                        @endforelse
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($note->user_id === Auth::id())
        <!-- Share Modal -->
        <div id="shareModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Share Note</h3>
                    <button onclick="document.getElementById('shareModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('notes.share', $note) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="email" :value="__('User Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="permission" :value="__('Permission')" />
                        <select id="permission" name="permission" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                            <option value="view">View only</option>
                            <option value="edit">Can edit</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('permission')" />
                    </div>

                    <div class="flex justify-end gap-4">
                        <x-secondary-button type="button" onclick="document.getElementById('shareModal').classList.add('hidden')">
                            Cancel
                        </x-secondary-button>
                        <x-primary-button>
                            Share
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</x-app-layout> 