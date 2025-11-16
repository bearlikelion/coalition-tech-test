<div>
    <label for="project-select" class="block mb-2 font-medium text-gray-700">Filter Tasks by Project:</label>
    <select id="project-select" wire:model="selectedProjectId" wire:change="updateSelectedProjectId($event.target.value)"
        class="border p-2 rounded w-full">
        <option value="">All Projects</option>
        @foreach ($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </select>
</div>
