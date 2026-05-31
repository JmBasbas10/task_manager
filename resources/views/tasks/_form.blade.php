<form action="{{ isset($task) ? route('tasks.update', $task) : route('tasks.store') }}" method="POST">
    @csrf
    @if(isset($task)) @method('PUT') @endif

    <div class="mb-3">
        <label for="title" class="form-label">Task Title <span class="text-danger">*</span></label>
        <input type="text" name="title" id="title"
               class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $task->title ?? '') }}" required>
        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="4"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="Optional details about the task">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="todo"        {{ old('status', $task->status ?? 'todo') == 'todo'        ? 'selected' : '' }}>To Do</option>
                <option value="in_progress" {{ old('status', $task->status ?? '') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="done"        {{ old('status', $task->status ?? '') == 'done'        ? 'selected' : '' }}>Done</option>
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
            <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                <option value="low"    {{ old('priority', $task->priority ?? '') == 'low'    ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('priority', $task->priority ?? 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high"   {{ old('priority', $task->priority ?? '') == 'high'   ? 'selected' : '' }}>High</option>
            </select>
            @error('priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" name="due_date" id="due_date"
                   class="form-control @error('due_date') is-invalid @enderror"
                   value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}">
            @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <hr>
    <button type="submit" class="btn btn-primary">
        {{ isset($task) ? 'Update Task' : 'Create Task' }}
    </button>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
</form>
