<div id="sortableTaskList">
    @forelse($tasks as $task)
        @include('tasks.partials.task-item')
    @empty
        <div class="empty-state">
            <i class="bi bi-check-circle" style="font-size: 48px; color: #e5e7eb;"></i>
            <p class="mt-3">No tasks yet. Add one above to get started!</p>
        </div>
    @endforelse
</div>