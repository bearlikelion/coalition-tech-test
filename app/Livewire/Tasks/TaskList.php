<?php

namespace App\Livewire\Tasks;

use App\Models\Project;
use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class TaskList extends Component
{
    #[Url]
    public $selectedProjectId = '';

    public $newTaskName = '';

    public $newTaskPriority = null;

    public $editingTaskId = null;

    public $editingTaskName = '';

    protected $rules = [
        'newTaskName' => 'required|string|max:255',
        'newTaskPriority' => 'nullable|integer|min:1',
        'selectedProjectId' => 'required|exists:projects,id'        
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
        $this->validate();

        $priority = $this->newTaskPriority ?? (Task::max('priority') + 1);

        // If a specific priority is set, shift all tasks at or after that priority down
        if ($this->newTaskPriority) {
            Task::where('priority', '>=', $this->newTaskPriority)->increment('priority');
        }

        Task::create([
            'name' => $this->newTaskName,
            'project_id' => $this->selectedProjectId,
            'priority' => $priority,
        ]);

        $this->newTaskName = '';
        $this->newTaskPriority = null;
        $this->selectedProjectId = '';
        $this->dispatch('taskUpdated');
        $this->dispatch('projectChanged', projectId: '');
    }

    public function editTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $this->editingTaskId = $task->id;
        $this->editingTaskName = $task->name;
    }

    public function updateTask()
    {
        $this->validate([
            'editingTaskName' => 'required|string|min:1|max:255',            
        ]);

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
        $this->reorderTasks();
        $this->dispatch('taskUpdated');
    }

    protected function reorderTasks()
    {
        $tasks = Task::orderBy('priority')->get();
        foreach ($tasks as $index => $task) {
            $task->priority = $index + 1;
            $task->save();
        }
    }

    public function updateTaskOrder($items)
    {
        foreach ($items as $index => $item) {
            $task = Task::find($item['value']);
            if ($task) {
                $task->priority = $index + 1;
                $task->save();
            }
        }
        $this->dispatch('taskUpdated');
    }

    #[On('projectChanged')]
    public function updateSelectedProjectId($projectId)
    {
        $this->selectedProjectId = $projectId;
    }

    public function render()
    {
        return view('livewire.tasks.task-list', [
            'tasks' => $this->tasks,
            'projects' => Project::all(),
        ]);
    }
}
