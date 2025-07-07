<div class="task-item" id="task-{{ $task->id }}" data-task-id="{{ $task->id }}">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3 flex-grow-1">
            <i class="bi bi-grip-vertical drag-handle text-muted"></i>
            <span class="priority-badge">#{{ isset($loop) ? $loop->index + 1 : $task->priority }}</span>
            <div class="flex-grow-1">
                <div class="fw-medium">{{ $task->name }}</div>
                <div class="small text-muted mt-1">
                    @if($task->project)
                        <span class="project-badge">
                            <i class="bi bi-folder"></i> {{ $task->project->name }}
                        </span>
                    @endif
                    <span class="ms-2">{{ $task->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
        <div class="task-actions">
            <button class="btn btn-sm btn-outline-secondary edit-task"
                    data-task-id="{{ $task->id }}"
                    data-task-name="{{ $task->name }}"
                    data-project-id="{{ $task->project_id }}">
                <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger delete-task"
                    data-task-id="{{ $task->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>
</div>