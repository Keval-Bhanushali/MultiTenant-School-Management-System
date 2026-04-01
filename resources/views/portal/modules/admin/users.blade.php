<section id="user-module" class="glass-card p-4 mb-4 fade-up" style="animation-delay: 0.3s;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h2 class="h4 section-title mb-1">User Module</h2>
            <span class="soft">Quick directory view by role</span>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="p-3 rounded-4 border h-100">
                <p class="soft mb-1">Total Teachers</p>
                <h3 class="mb-0">{{ $teachers->count() }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 rounded-4 border h-100">
                <p class="soft mb-1">Total Students</p>
                <h3 class="mb-0">{{ $students->count() }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 rounded-4 border h-100">
                <p class="soft mb-1">Total Staff</p>
                <h3 class="mb-0">{{ $staffMembers->count() }}</h3>
            </div>
        </div>
    </div>
</section>

