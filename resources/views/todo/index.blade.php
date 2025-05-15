<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                {{-- Bagian tombol create dan notifikasi --}}
                <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <x-create-button href="{{ route('todo.create') }}" />
                        </div>
                    </div>

                    @if (session('success'))
                        <p x-data="{ show: true }" x-show="show" x-transition
                            x-init="setTimeout(() => show = false, 5000)"
                            class="text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </p>
                    @endif

                    @if (session('danger'))
                        <p x-data="{ show: true }" x-show="show" x-transition
                            x-init="setTimeout(() => show = false, 5000)"
                            class="text-sm text-red-600 dark:text-red-400">
                            {{ session('danger') }}
                        </p>
                    @endif
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 table-fixed">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 w-1/4">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3 w-1/4 text-center">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3 w-1/4 text-center"> 
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 w-1/4 text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($todos as $todo)
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100 w-1/4">
                                        <a href="{{ route('todo.edit', $todo) }}" class="hover:underline">
                                            {{ $todo->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 w-1/4 text-center">
                                        @if ($todo->category)
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                                {{ $todo->category->title }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                No Category
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 w-1/4 text-center"> 
                                        @if ($todo->is_done==false)
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                                Ongoing
                                            </span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                Completed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 w-1/4 text-center">
                                        <div class="flex justify-center space-x-3">
                                            {{-- Action Here --}}
                                            @if ($todo->is_done == false)
                                                <form action="{{ route('todo.complete', $todo) }}" method="Post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 dark:text-green-400">
                                                        Complete
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('todo.uncomplete', $todo) }}" method="Post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-blue-600 dark:text-blue-400">
                                                        Uncomplete
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('todo.destroy', $todo) }}" method="Post">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white dark:bg-gray-900">
                                    <td colspan="4" class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100 text-center">
                                        No tasks available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($todosCompleted > 0)
    <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
        <form action="{{ route('todo.deleteallcomplete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete all completed tasks?')">
            @csrf 
            @method('DELETE')
            <button type="submit" 
                class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded">
                Delete All Completed Task
            </button>
        </form>
    </div>
@endif

            </div>
        </div>
    </div>
</x-app-layout>