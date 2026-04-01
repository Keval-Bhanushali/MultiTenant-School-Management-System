<section id="teacher-ops" class="glass-card p-4 mb-4 fade-up" style="animation-delay: 0.31s;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h2 class="h4 section-title mb-1">Teacher Operations</h2>
            <span class="soft">Manage timetables and student results</span>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="p-3 rounded-4 border h-100">
                <h3 class="h6 mb-2">My Timetable</h3>
                <div class="table-responsive">
                    <table class="table table-sm mb-0 align-middle">
                        <thead><tr><th>Day</th><th>Standard</th><th>Subject</th><th>Time</th></tr></thead>
                        <tbody>
                        @forelse($timetableEntries->where('teacher_id', $currentUser->_id) as $entry)
                            <tr>
                                <td>{{ $entry->day }}</td>
                                <td>{{ optional($entry->standard())->name ?? '-' }}</td>
                                <td>{{ optional($entry->subject())->name ?? '-' }}</td>
                                <td>{{ $entry->start_time }} - {{ $entry->end_time }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="soft">No timetable assigned.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="p-3 rounded-4 border h-100">
                <h3 class="h6 mb-2">Upload Student Results</h3>
                <form class="row g-2" method="POST" action="{{ route('portal.results.store') }}">
                    @csrf
                    <div class="col-4">
                        <select name="student_id" class="form-select" required>
                            <option value="">Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->_id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3"><input class="form-control" name="exam_name" placeholder="Exam" required></div>
                    <div class="col-2"><input class="form-control" name="marks" type="number" min="0" max="100" placeholder="Marks" required></div>
                    <div class="col-2"><input class="form-control" name="grade" placeholder="Grade" required></div>
                    <div class="col-1 d-grid"><button class="btn btn-brand js-submit-btn" type="submit"><span class="btn-label">+</span><span class="btn-spinner"></span></button></div>
                    <div class="col-4">
                        <select name="standard_id" class="form-select" required>
                            <option value="">Standard</option>
                            @foreach($standards as $standard)
                                <option value="{{ $standard->_id }}">{{ $standard->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-8">
                        <select name="subject_id" class="form-select" required>
                            <option value="">Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->_id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
