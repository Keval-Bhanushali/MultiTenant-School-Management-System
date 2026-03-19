    <section id="user-module" class="module-card module-teachers glass p-3 p-lg-4 mb-4 fade-up" style="animation-delay: 0.3s;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 section-title mb-0">User Module</h2>
            <span class="soft">Quick directory view by role</span>
        </div>

        <div class="row g-3">
            <div class="col-lg-4">
                <div class="p-3 rounded-3 border h-100">
                    <p class="soft mb-1">Total Teachers</p>
                    <h3 class="mb-0">{{ $teachers->count() }}</h3>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-3 rounded-3 border h-100">
                    <p class="soft mb-1">Total Students</p>
                    <h3 class="mb-0">{{ $students->count() }}</h3>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-3 rounded-3 border h-100">
                    <p class="soft mb-1">Total Staff</p>
                    <h3 class="mb-0">{{ $staffMembers->count() }}</h3>
                </div>
            </div>
        </div>
    </section>

