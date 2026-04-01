<section id="reports-module" class="glass-card p-4 mb-4 fade-up" style="animation-delay: 0.38s;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h2 class="h4 section-title mb-1">Advanced Reports & Exports</h2>
            <span class="soft">Generate CSV exports for results and attendance</span>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-lg-3 col-sm-6">
            <div class="p-3 rounded-4 border report-kpi h-100">
                <p class="soft small mb-1">Total Results</p>
                <p id="reportTotalResults" class="h4 mb-0">0</p>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="p-3 rounded-4 border report-kpi h-100">
                <p class="soft small mb-1">Pass Rate</p>
                <p id="reportPassRate" class="h4 mb-0">0%</p>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="p-3 rounded-4 border report-kpi h-100">
                <p class="soft small mb-1">Average Marks</p>
                <p id="reportAverageMarks" class="h4 mb-0">0</p>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="p-3 rounded-4 border report-kpi h-100">
                <p class="soft small mb-1">Attendance Rate</p>
                <p id="reportAttendanceRate" class="h4 mb-0">0%</p>
            </div>
        </div>
    </div>

    <div class="row g-2 align-items-end mb-3">
        <div class="col-lg-3 col-md-6">
            <label for="reportFromDate" class="form-label small soft mb-1">From date</label>
            <input type="date" id="reportFromDate" class="form-control">
        </div>
        <div class="col-lg-3 col-md-6">
            <label for="reportToDate" class="form-label small soft mb-1">To date</label>
            <input type="date" id="reportToDate" class="form-control">
        </div>
        <div class="col-lg-3 col-md-6">
            <label for="reportStandardFilter" class="form-label small soft mb-1">Standard</label>
            <select id="reportStandardFilter" class="form-select">
                <option value="">All standards</option>
                @foreach($standards as $standard)
                    <option value="{{ $standard->_id }}">{{ $standard->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-6">
            <label for="reportEntityTypeFilter" class="form-label small soft mb-1">Attendance type</label>
            <select id="reportEntityTypeFilter" class="form-select">
                <option value="">All</option>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
                <option value="staff">Staff</option>
            </select>
        </div>
        <div class="col-lg-1 col-md-6 d-grid">
            <button id="refreshReportSummary" type="button" class="btn btn-brand">
                <span class="btn-label">Refresh Summary</span>
                <span class="btn-spinner"></span>
            </button>
        </div>
    </div>

    <div id="reportAlert" class="d-none" role="alert"></div>

    <div class="p-3 rounded-4 border mt-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="h6 mb-0">Monthly Results Trend</h3>
            <span class="soft small">Count of results by month</span>
        </div>
        <div id="resultsTrendBars" class="report-trend-bars"></div>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="p-3 rounded-4 border h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h3 class="h6 mb-0">Results Export</h3>
                    <a id="resultsExportLink" class="btn btn-sm btn-outline-primary" href="{{ route('dashboard.reports.results.export') }}">Download CSV</a>
                </div>
                <p class="soft small mb-0">Includes student, standard, exam, marks, grade, and published timestamp.</p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="p-3 rounded-4 border h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h3 class="h6 mb-0">Attendance Export</h3>
                    <a id="attendanceExportLink" class="btn btn-sm btn-outline-primary" href="{{ route('dashboard.reports.attendance.export') }}">Download CSV</a>
                </div>
                <p class="soft small mb-0">Includes date, entity type, entity id, status, and remarks.</p>
            </div>
        </div>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-sm mb-0 align-middle">
            <thead>
            <tr>
                <th>Top Student</th>
                <th>Exam</th>
                <th>Marks</th>
                <th>Grade</th>
            </tr>
            </thead>
            <tbody id="topPerformersBody">
            <tr>
                <td colspan="4" class="soft">No summary loaded yet.</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-lg-6">
            <div class="table-responsive">
                <table class="table table-sm mb-0 align-middle">
                    <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Results</th>
                        <th>Avg</th>
                        <th>Pass %</th>
                    </tr>
                    </thead>
                    <tbody id="subjectPerformanceBody">
                    <tr>
                        <td colspan="4" class="soft">No data loaded yet.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="table-responsive">
                <table class="table table-sm mb-0 align-middle">
                    <thead>
                    <tr>
                        <th>Standard</th>
                        <th>Results</th>
                        <th>Avg</th>
                        <th>Pass %</th>
                    </tr>
                    </thead>
                    <tbody id="standardPerformanceBody">
                    <tr>
                        <td colspan="4" class="soft">No data loaded yet.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
