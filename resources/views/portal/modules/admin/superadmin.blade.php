<section id="superadmin" class="glass-card p-4 mb-4 fade-up" style="animation-delay: 0.12s;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h2 class="h4 section-title mb-1">Superadmin Control Center</h2>
            <span class="soft">Create school and school admin users</span>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="p-3 rounded-4 border h-100">
                <h3 class="h6 mb-3">Create School</h3>
                <form class="row g-2" method="POST" action="{{ route('portal.schools.store') }}">
                    @csrf
                    <div class="col-md-6"><input name="name" class="form-control" placeholder="School name" required></div>
                    <div class="col-md-6"><input name="code" class="form-control" placeholder="School code" required></div>
                    <div class="col-md-6"><input name="owner_name" class="form-control" placeholder="Owner name" required></div>
                    <div class="col-md-6"><input name="email" type="email" class="form-control" placeholder="School email" required></div>
                    <div class="col-md-8"><input name="phone" class="form-control" placeholder="Phone"></div>
                    <div class="col-md-4 d-grid">
                        <button class="btn btn-brand js-submit-btn" type="submit">
                            <span class="btn-label">Create</span><span class="btn-spinner"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="p-3 rounded-4 border h-100">
                <h3 class="h6 mb-3">Create School Admin</h3>
                <form class="row g-2" method="POST" action="{{ route('portal.school-admins.store') }}">
                    @csrf
                    <div class="col-md-12">
                        <select name="school_id" class="form-select" required>
                            <option value="">Select school</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->_id }}">{{ $school->name }} ({{ $school->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6"><input name="name" class="form-control" placeholder="Admin name" required></div>
                    <div class="col-md-6"><input name="username" class="form-control" placeholder="Admin username" required></div>
                    <div class="col-md-7"><input name="email" type="email" class="form-control" placeholder="Admin email" required></div>
                    <div class="col-md-5"><input name="password" class="form-control" placeholder="Password" required></div>
                    <div class="col-md-12 d-grid">
                        <button class="btn btn-brand js-submit-btn" type="submit">
                            <span class="btn-label">Create Admin</span><span class="btn-spinner"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-lg-6">
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead><tr><th>School</th><th>Code</th><th>Owner</th></tr></thead>
                    <tbody>
                    @forelse($schools as $school)
                        <tr><td>{{ $school->name }}</td><td>{{ $school->code }}</td><td>{{ $school->owner_name }}</td></tr>
                    @empty
                        <tr><td colspan="3" class="soft">No schools yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead><tr><th>Admin</th><th>Username</th><th>Role</th></tr></thead>
                    <tbody>
                    @forelse($schoolAdmins as $admin)
                        <tr><td>{{ $admin->name }}</td><td>{{ $admin->username }}</td><td>{{ $admin->role }}</td></tr>
                    @empty
                        <tr><td colspan="3" class="soft">No school admins yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-4">
        <div class="col-lg-12">
            <div class="p-3 rounded-4 border h-100">
                <h3 class="h6 mb-3">Assign Module Permissions to User</h3>
                <form method="POST" action="{{ route('admin.assignPermissions', $selectedUser->_id ?? '') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="userSelect">Select User:</label>
                        <select id="userSelect" name="user_id" class="form-select" required>
                            <option value="">Choose user</option>
                            @foreach($allUsers as $user)
                                <option value="{{ $user->_id }}" {{ (isset($selectedUser) && $selectedUser->_id == $user->_id) ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->role }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Module Permissions:</label><br>
                        @foreach($allModules as $module)
                            <label class="me-3">
                                <input type="checkbox" name="permissions[]" value="{{ $module }}"
                                    {{ (isset($selectedUser) && in_array($module, $selectedUser->permissions ?? [])) ? 'checked' : '' }}>
                                {{ ucfirst($module) }}
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-brand">Save Permissions</button>
                </form>
            </div>
        </div>
    </div>
</section>
