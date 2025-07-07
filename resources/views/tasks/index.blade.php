@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Quick Add Form -->
        <div class="quick-add-form">
            <h5 class="mb-3">Add New Task</h5>
            <form id="quickAddForm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="taskName" placeholder="What needs to be done?" required>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="taskProject">
                            <option value="">No Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle"></i> Add
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Filter Controls -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-2 align-items-center">
                <label class="form-label mb-0">View:</label>
                <select class="form-select form-select-sm" id="projectFilter" style="width: auto;">
                    <option value="">All Tasks</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ $selectedProject == $project->id ? 'selected' : '' }}>
                            {{ $project->name }} ({{ $project->tasks->count() }})
                        </option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newProjectModal">
                <i class="bi bi-folder-plus"></i> New Project
            </button>
        </div>

        <!-- Task List -->
        <div id="taskList">
            @include('tasks.partials.task-list')
        </div>
    </div>
</div>

<!-- New Project Modal -->
<div class="modal fade" id="newProjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="newProjectForm">
                <div class="modal-body">
                    <input type="text" class="form-control" id="projectName" placeholder="Project name" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editTaskForm">
                <input type="hidden" id="editTaskId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Task Name</label>
                        <input type="text" class="form-control" id="editTaskName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Project</label>
                        <select class="form-select" id="editTaskProject">
                            <option value="">No Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize sortable
    initSortable();

    // Quick add task
    $('#quickAddForm').on('submit', function(e) {
        e.preventDefault();

        const name = $('#taskName').val();
        const projectId = $('#taskProject').val();

        $.post('{{ route("tasks.store") }}', {
            name: name,
            project_id: projectId || null
        })
        .done(function(response) {
            $('#taskName').val('');

            // Remove empty state if it exists
            $('.empty-state').remove();

            // Prepend the new task
            $('#sortableTaskList').prepend(response.html);

            // Update all priority badges
            updatePriorityBadges();

            // Reinitialize sortable
            initSortable();
        })
        .fail(function(xhr) {
            alert('Error creating task. Please try again.');
        });
    });

    // Project filter
    $('#projectFilter').on('change', function() {
        const projectId = $(this).val();
        window.location.href = projectId ? `?project=${projectId}` : '{{ route("tasks.index") }}';
    });

    // New project
    $('#newProjectForm').on('submit', function(e) {
        e.preventDefault();

        const name = $('#projectName').val();

        $.post('{{ route("projects.store") }}', { name: name })
        .done(function(response) {
            $('#newProjectModal').modal('hide');
            $('#projectName').val('');
            location.reload();
        })
        .fail(function(xhr) {
            alert('Error creating project. Please try again.');
        });
    });

    // Edit task
    $(document).on('click', '.edit-task', function() {
        const taskId = $(this).data('task-id');
        const taskName = $(this).data('task-name');
        const projectId = $(this).data('project-id');

        $('#editTaskId').val(taskId);
        $('#editTaskName').val(taskName);
        $('#editTaskProject').val(projectId || '');
        $('#editTaskModal').modal('show');
    });

    $('#editTaskForm').on('submit', function(e) {
        e.preventDefault();

        const taskId = $('#editTaskId').val();
        const name = $('#editTaskName').val();
        const projectId = $('#editTaskProject').val();

        $.ajax({
            url: `/tasks/${taskId}`,
            method: 'PUT',
            data: {
                name: name,
                project_id: projectId || null
            }
        })
        .done(function(response) {
            $('#editTaskModal').modal('hide');
            location.reload();
        })
        .fail(function(xhr) {
            alert('Error updating task. Please try again.');
        });
    });

    // Delete task
    $(document).on('click', '.delete-task', function() {
        if (!confirm('Delete this task?')) return;

        const taskId = $(this).data('task-id');

        $.ajax({
            url: `/tasks/${taskId}`,
            method: 'DELETE'
        })
        .done(function() {
            $(`#task-${taskId}`).fadeOut(300, function() {
                $(this).remove();
                updateEmptyState();
            });
        })
        .fail(function() {
            alert('Error deleting task. Please try again.');
        });
    });

    function initSortable() {
        $('#sortableTaskList').sortable({
            handle: '.drag-handle',
            update: function(event, ui) {
                const taskIds = $(this).sortable('toArray', { attribute: 'data-task-id' });

                $.post('{{ route("tasks.reorder") }}', { task_ids: taskIds })
                .done(function() {
                    updatePriorityBadges();
                })
                .fail(function() {
                    alert('Error reordering tasks. Please refresh the page.');
                });
            }
        });
    }

    function updatePriorityBadges() {
        $('#sortableTaskList .task-item').each(function(index) {
            $(this).find('.priority-badge').text(`#${index + 1}`);
        });
    }

    function updateEmptyState() {
        const taskCount = $('#sortableTaskList .task-item').length;
        if (taskCount === 0) {
            $('#sortableTaskList').html('<div class="empty-state"><i class="bi bi-check-circle" style="font-size: 48px; color: #e5e7eb;"></i><p class="mt-3">No tasks yet. Add one above to get started!</p></div>');
        }
    }
});
</script>
@endpush