<div>
    <!-- Create Task Form -->
    <form wire:submit.prevent="addTask" class="mb-4">
        <input type="text" wire:model="newTaskName" placeholder="New Task Name" class="border p-2 rounded w-full" />
        @error('newTaskName') <span class="text-red-500">{{ $message }}</span> @enderror
        <select wire:model="selectedProjectId" class="border p-2 rounded w-full mt-2">
            <option value="">Select Project</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
        @error('selectedProjectId') <span class="text-red-500">{{ $message }}</span> @enderror  
        <button type="submit" class="bg-blue-500 text-white p-2 rounded mt-2">Add Task</button>        
    </form>

    <!-- Task List with Drag-and-Drop -->
    <div wire:sortable="updateTaskOrder">
        @foreach($tasks as $task)
            <div wire:sortable.item="{{ $task->id }}" class="border p-4 mb-2 rounded bg-white flex justify-between items-center"> 
                <span class="content-left flex items-center">                                     
                    <button wire:sortable.handle class="cursor-move text-gray-500 mr-4">::</button>
                    <span>{{ $task->name }}</span>
                    <span class="text-sm text-gray-400 pl-2">({{ $task->project->name }})</span>
                </span>
                <span class="content-right">
                    <button wire:click="editTask({{ $task->id }})" class="text-blue-500 mr-4">Edit</button>
                    <button wire:click="deleteTask({{ $task->id }})" class="text-red-500">Delete</button>
                </span>                
            </div>
        @endforeach
    </div>
</div>