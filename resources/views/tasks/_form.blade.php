<form action="{{ isset($task) ? route('tasks.update', $task) : route('tasks.store') }}" method="POST">
    @csrf
    @if(isset($task))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="title" class="form-label fw-medium">Task Title <span class="text-danger">*</span></label>
        <input type="text" id="title" name="title"
               class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $task->title ?? '') }}"
               placeholder="What needs to be done?" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label fw-medium">Description</label>
        <textarea id="description" name="description" rows="4"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="Add more details about this task (optional)">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label for="status" class="form-label fw-medium">Status <span class="text-danger">*</span></label>
            <select id="status" name="status"
                    class="form-select @error('status') is-invalid @enderror" required>
                <option value="todo"        {{ old('status', $task->status ?? 'todo') === 'todo'        ? 'selected' : '' }}>To Do</option>
                <option value="in_progress" {{ old('status', $task->status ?? '') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="done"        {{ old('status', $task->status ?? '') === 'done'        ? 'selected' : '' }}>Done</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label for="priority" class="form-label fw-medium">Priority <span class="text-danger">*</span></label>
            <select id="priority" name="priority"
                    class="form-select @error('priority') is-invalid @enderror" required>
                <option value="low"    {{ old('priority', $task->priority ?? '') === 'low'    ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('priority', $task->priority ?? 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high"   {{ old('priority', $task->priority ?? '') === 'high'   ? 'selected' : '' }}>High</option>
            </select>
            @error('priority')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label for="due_date" class="form-label fw-medium">Due Date</label>
            <input type="date" id="due_date" name="due_date"
                   class="form-control @error('due_date') is-invalid @enderror"
                   value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}">
            @error('due_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <hr class="my-4">

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-{{ isset($task) ? 'save' : 'plus-lg' }} me-1"></i>
            {{ isset($task) ? 'Save Changes' : 'Create Task' }}
        </button>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-4">
            Cancel
        </a>
    </div>
</form>
