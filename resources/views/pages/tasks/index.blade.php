<x-layout>
    <div class="container mx-auto p-4">
        @volt('tasks.index')        
    
    <div class="text-2xl font-bold mb-6">Task Management</div>

    <!-- Project Filter -->
    <div class="mb-4">
        <label for="project" class="block text-sm font-medium text-gray-700">Filter by Project:</label>
        <select id="project" wire:model="selectedProject" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray">
            <option value="">All Projects</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
    </div> 
    
    <!-- Add Task Form -->
    <form wire:submit.prevent="addTask" class="mb-6">
        <div class="mb-4">
            <label for="taskName" class="block text-sm font-medium text-gray-700">Task Name:</label>
            <input type="text" id="taskName" wire:model="taskName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md">Add Task</button>
        </div>
        @error('newTaskName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </form>

    <!-- Tasks List -->
    @if($tasks->isEmpty())
        <p class="text-gray-500">No tasks available.</p>
    @else
        <ul wire:sortable="updateTaskOrder" class="space-y-4">
            @foreach($tasks as $task)
                <li wire:sortable.item="{{ $task->id }}" class="p-4 bg-white rounded shadow flex items-center justify-between">
                    <span wire:sortable.handle class="cursor-move mr-4">☰</span>
                    <span>{{ $task->name }} (Project: {{ $task->project->name }})</span>
                    <span class="text-sm text-gray-500">Priority: {{ $task->priority }}</span>                                    
                </li>
            @endforeach
        </ul>
    @endif

</x-layout>