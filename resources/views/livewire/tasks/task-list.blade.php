<div>
    <label for="addTaskForm" class="block mb-2 font-medium text-gray-700">Add New Task:</label>

    <!-- Create Task Form -->
    <div>
        <form name="addTaskForm" wire:submit.prevent="addTask" class="mb-4">
            <input type="text" wire:model="newTaskName" placeholder="New Task Name" class="border p-2 rounded w-full" />
            @error('newTaskName')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
            <input type="number" wire:model="newTaskPriority" placeholder="Task Priority" class="border p-2 rounded w-full mt-2" min="1" />
            @error('newTaskPriority')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
            <select wire:model="selectedProjectId" class="border p-2 rounded w-full mt-2">
                <option value="">Select a Project</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded mt-2">Create Task</button>
            @error('selectedProjectId')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </form>
    </div>

    <!-- Project Filter Selector -->
    <livewire:projects.project-selector />

    <!-- Task List with Drag-and-Drop -->
    <div wire:sortable="updateTaskOrder">
        <h2 class="text-xl font-bold mb-4">Tasks</h2>
        @foreach ($tasks as $task)
            <div wire:sortable.item="{{ $task->id }}"
                class="border p-4 mb-2 rounded bg-white flex justify-between items-center">
                <span class="content-left flex items-center">
                    <button wire:sortable.handle class="cursor-move text-gray-500 mr-4">::</button>
                    <span class="mr-2">{{ $task->priority }}.</span>
                    @if ($editingTaskId === $task->id)
                        <input type="text" wire:model="editingTaskName" class="border p-2 rounded mr-2" />
                        @error('editingTaskName')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <button wire:click="updateTask" class="bg-green-700 text-white p-2 rounded mr-2">Save</button>
                        <button wire:click="cancelEdit" class="bg-gray-500 text-white p-2 rounded mr-2">Cancel</button>
                    @else
                        <span class="mr-2">{{ $task->name }}</span>
                    @endif
                    <span class="text-sm text-gray-400">({{ $task->project->name }})</span>
                    <span class="text-xs text-gray-400 ml-2"> {{ $task->updated_at->diffForHumans() }}</span>
                </span>
                <span class="content-right">
                    <button wire:click="editTask({{ $task->id }})"
                        class="text-blue-500 hover:text-blue-800 mr-4">Edit</button>
                    <button wire:click="deleteTask({{ $task->id }})"
                        wire:confirm="Are you sure you want to delete this task?"
                        class="text-red-500 hover:text-red-800">Delete</button>
                </span>
            </div>
        @endforeach
    </div>
</div>
