<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProjectSelector extends Component
{
    #[Url]
    public $selectedProjectId = '';

    public function updateSelectedProjectId($value)
    {
        $this->dispatch('projectChanged', projectId: $value);
    }

    public function render()
    {
        return view('livewire.projects.project-selector', [
            'projects' => Project::all(),
        ]);
    }
}
