<?php

namespace App\Livewire\Tasks;

use App\Models\Project;
use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class TaskController extends Component
{
    #[Url]
    public $selectedProjectId = '';

    public $newTaskName = '';

    public $editingTaskId = null;

    public $editingTaskName = '';

    protected $rules = [
        'newTaskName' => 'required|string|max:255',
        'editingTaskName' => 'required|string|min:1|max:255',
    ];

    public function getTasksProperty()
    {
        $query = Task::with('project');

        if ($this->selectedProjectId) {
            $query->where('project_id', $this->selectedProjectId);
        }

        return $query->orderBy('priority')->get();
    }

    public function addTask()
    {
        $this->validateOnly('newTaskName');

        $projectId = $this->selectedProjectId ?: Project::first()?->id;

        if (! $projectId) {
            $this->addError('newTaskName', 'Please create a project before adding tasks.');

            return;
        }

        Task::create([
            'name' => $this->newTaskName,
            'project_id' => $projectId,
            'priority' => Task::max('priority') + 1,
        ]);

        $this->newTaskName = '';
        $this->dispatch('taskUpdated');
    }

    public function editTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $this->editingTaskId = $task->id;
        $this->editingTaskName = $task->name;
    }

    public function updateTask()
    {
        $this->validateOnly('editingTaskName');

        $task = Task::findOrFail($this->editingTaskId);
        $task->update(['name' => $this->editingTaskName]);

        $this->editingTaskId = null;
        $this->editingTaskName = '';
        $this->dispatch('taskUpdated');
    }

    public function cancelEdit()
    {
        $this->editingTaskId = null;
        $this->editingTaskName = '';
    }

    public function deleteTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->delete();
        $this->dispatch('taskUpdated');
    }

    public function updateTaskOrder($orderedIds)
    {        
        foreach ($orderedIds as $index => $id) {
            Task::where('id', $id)->update(['priority' => $index + 1]);
        }
        $this->dispatch('taskUpdated');
    }

    #[On('projectChanged')]
    public function handleProjectChanged($projectId)
    {
        $this->selectedProjectId = $projectId;
    }

    public function render()
    {
        return view('livewire.tasks.task-controller', [
            'tasks' => $this->tasks,
            'projects' => Project::all(),
        ]);
    }
}
