<section id="classes" class="glass-card p-4 mb-4 fade-up" style="animation-delay: 0.25s;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h2 class="h4 section-title mb-1">Class Module</h2>
            <span class="soft">Belongs to teacher, has many students</span>
        </div>
    </div>

    <form class="row g-2 mb-3" action="{{ route('portal.classes.store') }}" method="POST">
        @csrf
        <div class="col-md-3"><input name="name" class="form-control" placeholder="Class name" required></div>
        <div class="col-md-2"><input name="section" class="form-control" placeholder="Section" required></div>
        <div class="col-md-2"><input type="number" min="1" name="capacity" class="form-control" placeholder="Capacity" required></div>
        <div class="col-md-3">
            <select name="teacher_id" class="form-select">
                <option value="">Assign teacher (optional)</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->_id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1"><input name="room_number" class="form-control" placeholder="Room"></div>
        <div class="col-md-1 d-grid">
            <button class="btn btn-brand js-submit-btn" type="submit">
                <span class="btn-label">Add</span>
                <span class="btn-spinner"></span>
            </button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Section</th>
                    <th>Capacity</th>
                    <th>Teacher</th>
                    <th>Room</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                    <tr>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->section }}</td>
                        <td>{{ $class->capacity }}</td>
                        <td>{{ optional($class->teacher)->name ?: 'Unassigned' }}</td>
                        <td>{{ $class->room_number ?: '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="soft">No classes yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
