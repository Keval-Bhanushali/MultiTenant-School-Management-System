    <section id="academic-structure" class="module-card module-classes glass p-3 p-lg-4 mb-4 fade-up" style="animation-delay: 0.31s;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 section-title mb-0">Academic Structure Modules</h2>
            <span class="soft">Standards, Subjects, Courses, Staff, Timetable, Results</span>
        </div>

        <div class="row g-3">
            <div class="col-lg-6">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">Create Standard</h3>
                    <form class="row g-2" method="POST" action="{{ route('portal.standards.store') }}">
                        @csrf
                        <div class="col-8"><input class="form-control" name="name" placeholder="Standard name (e.g. Grade 8)" required></div>
                        <div class="col-2"><input class="form-control" name="order" type="number" min="1" max="20" placeholder="#" required></div>
                        <div class="col-2 d-grid"><button class="btn btn-brand js-submit-btn" type="submit"><span class="btn-label">Add</span><span class="btn-spinner"></span></button></div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm mb-0 align-middle">
                            <thead><tr><th>Standard</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
                            <tbody>
                            @forelse($standards as $standard)
                                <tr>
                                    <td>{{ $standard->name }}</td>
                                    <td>{{ $standard->order }}</td>
                                    <td>{{ $standard->status }}</td>
                                    <td>
                                        <form method="DELETE" action="{{ route('portal.standards.delete', $standard->_id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="soft">No standards yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">Create Subject</h3>
                    <form class="row g-2" method="POST" action="{{ route('portal.subjects.store') }}">
                        @csrf
                        <div class="col-5">
                            <select name="standard_id" class="form-select" required>
                                <option value="">Standard</option>
                                @foreach($standards as $standard)
                                    <option value="{{ $standard->_id }}">{{ $standard->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4"><input class="form-control" name="name" placeholder="Subject name" required></div>
                        <div class="col-2"><input class="form-control" name="code" placeholder="Code" required></div>
                        <div class="col-1 d-grid"><button class="btn btn-brand js-submit-btn" type="submit"><span class="btn-label">+</span><span class="btn-spinner"></span></button></div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm mb-0 align-middle">
                            <thead><tr><th>Subject</th><th>Code</th><th>Actions</th></tr></thead>
                            <tbody>
                            @forelse($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->code }}</td>
                                    <td>
                                        <form method="DELETE" action="{{ route('portal.subjects.delete', $subject->_id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="soft">No subjects yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">Create Course</h3>
                    <form class="row g-2" method="POST" action="{{ route('portal.courses.store') }}">
                        @csrf
                        <div class="col-4">
                            <select name="standard_id" class="form-select" required>
                                <option value="">Standard</option>
                                @foreach($standards as $standard)
                                    <option value="{{ $standard->_id }}">{{ $standard->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4"><input class="form-control" name="name" placeholder="Course name" required></div>
                        <div class="col-3"><input class="form-control" name="description" placeholder="Description"></div>
                        <div class="col-1 d-grid"><button class="btn btn-brand js-submit-btn" type="submit"><span class="btn-label">+</span><span class="btn-spinner"></span></button></div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm mb-0 align-middle">
                            <thead><tr><th>Course</th><th>Description</th><th>Actions</th></tr></thead>
                            <tbody>
                            @forelse($courses as $course)
                                <tr>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->description ?: '-' }}</td>
                                    <td>
                                        <form method="DELETE" action="{{ route('portal.courses.delete', $course->_id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="soft">No courses yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">Create Staff User</h3>
                    <form class="row g-2" method="POST" action="{{ route('portal.staff.store') }}">
                        @csrf
                        <div class="col-4"><input class="form-control" name="name" placeholder="Name" required></div>
                        <div class="col-4"><input class="form-control" name="email" type="email" placeholder="Email" required></div>
                        <div class="col-4"><input class="form-control" name="phone" placeholder="Phone"></div>
                        <div class="col-4"><input class="form-control" name="department" placeholder="Department" required></div>
                        <div class="col-4"><input class="form-control" name="designation" placeholder="Designation" required></div>
                        <div class="col-3"><input class="form-control" name="user_role" placeholder="Role (cashier, food manager...)" required></div>
                        <div class="col-1 d-grid"><button class="btn btn-brand js-submit-btn" type="submit"><span class="btn-label">+</span><span class="btn-spinner"></span></button></div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm mb-0 align-middle">
                            <thead><tr><th>Name</th><th>Department</th><th>Role</th><th>Actions</th></tr></thead>
                            <tbody>
                            @forelse($staffMembers as $staff)
                                <tr>
                                    <td>{{ $staff->name }}</td>
                                    <td>{{ $staff->department }}</td>
                                    <td>{{ $staff->user_role }}</td>
                                    <td>
                                        <form method="DELETE" action="{{ route('portal.staff.delete', $staff->_id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="soft">No staff members yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
