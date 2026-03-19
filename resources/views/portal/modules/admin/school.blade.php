    <section id="school-module" class="module-card module-classes glass p-3 p-lg-4 mb-4 fade-up" style="animation-delay: 0.29s;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 section-title mb-0">School Module</h2>
            <span class="soft">School identity and tenant scope</span>
        </div>

        <div class="row g-3">
            <div class="col-lg-6">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">Current Access Scope</h3>
                    @if($currentUser->role === 'superadmin')
                        <p class="mb-2">You are in global scope and can manage all schools.</p>
                    @else
                        <p class="mb-2">You are currently scoped to school ID:</p>
                        <p class="mb-0 fw-semibold">{{ $currentUser->school_id }}</p>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">School KPI Snapshot</h3>
                    <div class="d-flex justify-content-between mb-1"><span class="soft">Teachers</span><strong>{{ $stats['teachers'] }}</strong></div>
                    <div class="d-flex justify-content-between mb-1"><span class="soft">Classes</span><strong>{{ $stats['classes'] }}</strong></div>
                    <div class="d-flex justify-content-between"><span class="soft">Students</span><strong>{{ $stats['students'] }}</strong></div>
                </div>
            </div>
        </div>
    </section>
