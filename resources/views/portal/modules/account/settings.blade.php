    <section id="settings-module" class="module-card module-classes glass p-3 p-lg-4 mb-2 fade-up" style="animation-delay: 0.36s;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 section-title mb-0">Settings</h2>
            <span class="soft">Theme and session controls</span>
        </div>
        <div class="row g-3">
            <div class="col-lg-6">
                <div class="p-3 rounded-3 border h-100 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold">Theme Preference</p>
                        <p class="soft mb-0">Switch light or dark dashboard mode.</p>
                    </div>
                    <button id="settingsThemeToggle" class="btn btn-brand" type="button">Toggle Theme</button>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-3 rounded-3 border h-100 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold">Secure Logout</p>
                        <p class="soft mb-0">End current session from settings panel.</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button class="btn btn-outline-danger" type="submit"><i class="fa-solid fa-right-from-bracket me-1"></i>Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
