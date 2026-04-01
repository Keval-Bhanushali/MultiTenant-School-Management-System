<section id="teachers" class="glass-card p-4 mb-4 fade-up" style="animation-delay: 0.2s;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h2 class="h4 section-title mb-1">Teacher Module</h2>
            <span class="soft">Relationship parent of classes</span>
        </div>
    </div>

    <form class="row g-2 mb-3" action="{{ route('portal.teachers.store') }}" method="POST">
        @csrf
        <div class="col-md-4"><input name="name" class="form-control" placeholder="Teacher name" required></div>
        <div class="col-md-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <div class="col-md-2"><input name="phone" class="form-control" placeholder="Phone"></div>
        <div class="col-md-2"><input name="subject_specialization" class="form-control" placeholder="Subject" required></div>
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
                    <th>Phone</th>
                    <th>Specialization</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->email }}</td>
                        <td>{{ $teacher->phone ?: '-' }}</td>
                        <td>{{ $teacher->subject_specialization }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="soft">No teachers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
