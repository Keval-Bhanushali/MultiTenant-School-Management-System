<section id="students" class="glass-card p-4 mb-4 fade-up" style="animation-delay: 0.3s;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h2 class="h4 section-title mb-1">Student Module</h2>
            <span class="soft">Belongs to class</span>
        </div>
    </div>

    <form class="row g-2 mb-3" action="{{ route('portal.students.store') }}" method="POST">
        @csrf
        <div class="col-md-3"><input name="name" class="form-control" placeholder="Student name" required></div>
        <div class="col-md-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <div class="col-md-2"><input name="roll_number" class="form-control" placeholder="Roll number" required></div>
        <div class="col-md-2">
            <select name="class_id" class="form-select" required>
                <option value="">Select class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->_id }}">{{ $class->name }} - {{ $class->section }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1"><input name="guardian_name" class="form-control" placeholder="Guardian"></div>
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roll</th>
                    <th>Class</th>
                    <th>Guardian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->roll_number }}</td>
                        <td>
                            @php($c = $student->schoolClass)
                            {{ $c ? $c->name . ' - ' . $c->section : 'Unknown' }}
                        </td>
                        <td>{{ $student->guardian_name ?: '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="soft">No students yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
