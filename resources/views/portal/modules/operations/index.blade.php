    <section id="operations" class="module-card module-students glass p-3 p-lg-4 mb-4 fade-up" style="animation-delay: 0.33s;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 section-title mb-0">Operations Modules</h2>
            <span class="soft">Timetable, Results, Notices, Holidays, Attendance</span>
        </div>

        <div class="row g-3">
            <div class="col-lg-6">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">Timetable Entry</h3>
                    <form class="row g-2" method="POST" action="{{ route('portal.timetable.store') }}">
                        @csrf
                        <div class="col-4">
                            <select name="standard_id" class="form-select" required>
                                <option value="">Standard</option>
                                @foreach($standards as $standard)
                                    <option value="{{ $standard->_id }}">{{ $standard->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <select name="subject_id" class="form-select" required>
                                <option value="">Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->_id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <select name="teacher_id" class="form-select">
                                <option value="">Teacher (optional)</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->_id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3"><input class="form-control" name="day" placeholder="Day" required></div>
                        <div class="col-3"><input class="form-control" name="start_time" placeholder="Start" required></div>
                        <div class="col-3"><input class="form-control" name="end_time" placeholder="End" required></div>
                        <div class="col-2 d-grid"><button class="btn btn-brand js-submit-btn" type="submit"><span class="btn-label">Save</span><span class="btn-spinner"></span></button></div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm mb-0 align-middle">
                            <thead><tr><th>Day</th><th>Time</th><th>Teacher</th><th>Actions</th></tr></thead>
                            <tbody>
                            @forelse($timetableEntries as $entry)
                                <tr>
                                    <td>{{ $entry->day }}</td>
                                    <td>{{ $entry->start_time }} - {{ $entry->end_time }}</td>
                                    <td>{{ $entry->teacher_id ?: '-' }}</td>
                                    <td>
                                        <form method="DELETE" action="{{ route('portal.timetable.delete', $entry->_id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="soft">No timetable entries yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">Results Upload</h3>
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
                        <div class="col-4">
                            <select name="standard_id" class="form-select" required>
                                <option value="">Standard</option>
                                @foreach($standards as $standard)
                                    <option value="{{ $standard->_id }}">{{ $standard->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <select name="subject_id" class="form-select" required>
                                <option value="">Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->_id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4"><input class="form-control" name="exam_name" placeholder="Exam name" required></div>
                        <div class="col-3"><input class="form-control" name="marks" type="number" min="0" max="100" placeholder="Marks" required></div>
                        <div class="col-3"><input class="form-control" name="grade" placeholder="Grade" required></div>
                        <div class="col-2 d-grid"><button class="btn btn-brand js-submit-btn" type="submit"><span class="btn-label">Save</span><span class="btn-spinner"></span></button></div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm mb-0 align-middle">
                            <thead><tr><th>Exam</th><th>Marks</th><th>Grade</th><th>Actions</th></tr></thead>
                            <tbody>
                            @forelse($results as $result)
                                <tr>
                                    <td>{{ $result->exam_name }}</td>
                                    <td>{{ $result->marks }}</td>
                                    <td>{{ $result->grade }}</td>
                                    <td>
                                        <form method="DELETE" action="{{ route('portal.results.delete', $result->_id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="soft">No results yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">Publish Notice</h3>
                    <form class="row g-2" method="POST" action="{{ route('portal.notices.store') }}">
                        @csrf
                        <div class="col-5"><input class="form-control" name="title" placeholder="Notice title" required></div>
                        <div class="col-3"><input class="form-control" name="target_role" placeholder="Target role" required></div>
                        <div class="col-2">
                            <select class="form-select" name="scope" required>
                                <option value="school">School</option>
                                @if($currentUser->role === 'superadmin')
                                    <option value="all">All Schools</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-2 d-grid"><button class="btn btn-brand js-submit-btn" type="submit"><span class="btn-label">Send</span><span class="btn-spinner"></span></button></div>
                        <div class="col-12"><textarea class="form-control" name="message" placeholder="Notice message" rows="2" required></textarea></div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm mb-0 align-middle">
                            <thead><tr><th>Title</th><th>Scope</th><th>Role</th><th>Actions</th></tr></thead>
                            <tbody>
                            @forelse($notices as $notice)
                                <tr>
                                    <td>{{ $notice->title }}</td>
                                    <td>{{ $notice->scope }}</td>
                                    <td>{{ $notice->target_role }}</td>
                                    <td>
                                        <form method="DELETE" action="{{ route('portal.notices.delete', $notice->_id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="soft">No notices yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">Holiday & Attendance</h3>
                    <form class="row g-2 mb-2" method="POST" action="{{ route('portal.holidays.store') }}">
                        @csrf
                        <div class="col-4"><input class="form-control" name="title" placeholder="Holiday title" required></div>
                        <div class="col-3"><input class="form-control" type="date" name="date" required></div>
                        <div class="col-3"><input class="form-control" name="type" placeholder="Festival/Weekend" required></div>
                        <div class="col-2 d-grid"><button class="btn btn-brand js-submit-btn" type="submit"><span class="btn-label">Add</span><span class="btn-spinner"></span></button></div>
                    </form>
                    <form class="row g-2" method="POST" action="{{ route('portal.attendance.store') }}" id="attendanceForm">
                        @csrf
                        <div class="col-3">
                            <select class="form-select" name="entity_type" id="attendanceEntityType" required onchange="updateAttendanceDropdown()">
                                <option value="">Select Type</option>
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-select" name="entity_id" id="attendanceEntityId" required style="display:none;">
                                <option value="">-- Select Entity --</option>
                            </select>
                        </div>
                        <div class="col-2"><input class="form-control" type="date" name="date" required></div>
                        <div class="col-2">
                            <select class="form-select" name="status" required>
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="leave">Leave</option>
                            </select>
                        </div>
                        <div class="col-1 d-grid"><button class="btn btn-brand js-submit-btn" type="submit"><span class="btn-label">+</span><span class="btn-spinner"></span></button></div>
                    </form>
                    <script>
                        const attendanceData = {
                            student: [
                                @foreach($students as $student)
                                    {id: '{{ $student->_id }}', name: '{{ $student->name }}'},
                                @endforeach
                            ],
                            teacher: [
                                @foreach($teachers as $teacher)
                                    {id: '{{ $teacher->_id }}', name: '{{ $teacher->name }}'},
                                @endforeach
                            ],
                            staff: [
                                @foreach($staffMembers as $staff)
                                    {id: '{{ $staff->_id }}', name: '{{ $staff->name }}'},
                                @endforeach
                            ]
                        };
                        function updateAttendanceDropdown() {
                            const type = document.getElementById('attendanceEntityType').value;
                            const select = document.getElementById('attendanceEntityId');
                            select.innerHTML = '<option value="">-- Select Entity --</option>';
                            if (type && attendanceData[type]) {
                                attendanceData[type].forEach(entity => {
                                    const opt = document.createElement('option');
                                    opt.value = entity.id;
                                    opt.textContent = entity.name;
                                    select.appendChild(opt);
                                });
                                select.style.display = '';
                            } else {
                                select.style.display = 'none';
                            }
                        }
                    </script>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm mb-0 align-middle">
                            <thead><tr><th>Holiday</th><th>Date</th><th>Type</th><th>Actions</th></tr></thead>
                            <tbody>
                            @forelse($holidays as $holiday)
                                <tr>
                                    <td>{{ $holiday->title }}</td>
                                    <td>{{ $holiday->date }}</td>
                                    <td>{{ $holiday->type }}</td>
                                    <td>
                                        <form method="DELETE" action="{{ route('portal.holidays.delete', $holiday->_id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="soft">No holidays yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
