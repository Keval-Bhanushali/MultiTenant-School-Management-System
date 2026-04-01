<section id="profile-module" class="glass-card p-4 mb-4 fade-up" style="animation-delay: 0.34s;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h2 class="h4 section-title mb-1">User Profile</h2>
            <span class="soft">Your account information in one place</span>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="p-3 rounded-4 border h-100">
                <p class="soft mb-1">Name</p>
                <p class="mb-0 fw-semibold">{{ $currentUser->name }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 rounded-4 border h-100">
                <p class="soft mb-1">Email</p>
                <p class="mb-0 fw-semibold">{{ $currentUser->email }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 rounded-4 border h-100">
                <p class="soft mb-1">Role</p>
                <p class="mb-0 fw-semibold text-capitalize">{{ $currentUser->role }}</p>
            </div>
        </div>
    </div>
</section>
