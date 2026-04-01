<section id="file-management" class="glass-card p-4 mb-4 fade-up" style="animation-delay: 0.36s;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h2 class="h4 section-title mb-1">File Management</h2>
            <span class="soft">Upload, filter, and share school files by role</span>
        </div>
    </div>

    <form id="fileUploadForm" class="row g-2 align-items-end" enctype="multipart/form-data" autocomplete="off">
        <div class="col-lg-3 col-md-6">
            <label for="uploadFileInput" class="form-label small soft mb-1">Select file</label>
            <input id="uploadFileInput" type="file" name="file" class="form-control" required>
        </div>
        <div class="col-lg-2 col-md-6">
            <label for="uploadDocumentType" class="form-label small soft mb-1">Document type</label>
            <select id="uploadDocumentType" name="document_type" class="form-select" required>
                <option value="assignment">Assignment</option>
                <option value="exam">Exam</option>
                <option value="notice">Notice</option>
                <option value="syllabus">Syllabus</option>
                <option value="resource" selected>Resource</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="col-lg-3 col-md-6">
            <label for="uploadDescription" class="form-label small soft mb-1">Description</label>
            <input id="uploadDescription" type="text" name="description" class="form-control" maxlength="500" placeholder="Optional notes">
        </div>
        <div class="col-lg-3 col-md-6">
            <label for="uploadSharedRoles" class="form-label small soft mb-1">Share with roles</label>
            <select id="uploadSharedRoles" name="shared_with_roles[]" class="form-select" multiple size="2">
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
                <option value="teacher">Teacher</option>
                <option value="student">Student</option>
            </select>
        </div>
        <div class="col-lg-1 col-md-12 d-grid">
            <button type="submit" class="btn btn-brand js-submit-btn">
                <span class="btn-label">Upload</span>
                <span class="btn-spinner"></span>
            </button>
        </div>
    </form>

    <div id="fileUploadAlert" class="mt-3 d-none" role="alert"></div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3 mb-2">
        <div class="d-flex align-items-center gap-2">
            <label for="fileTypeFilter" class="soft small mb-0">Filter</label>
            <select id="fileTypeFilter" class="form-select form-select-sm" style="min-width: 180px;">
                <option value="">All types</option>
                <option value="assignment">Assignment</option>
                <option value="exam">Exam</option>
                <option value="notice">Notice</option>
                <option value="syllabus">Syllabus</option>
                <option value="resource">Resource</option>
                <option value="other">Other</option>
            </select>
        </div>
        <button id="refreshFilesBtn" type="button" class="btn btn-sm btn-outline-secondary">
            <i class="fa-solid fa-rotate-right me-1"></i>Refresh
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0" id="fileTable">
            <thead>
            <tr>
                <th>File</th>
                <th>Type</th>
                <th>Size</th>
                <th>Shared With</th>
                <th>Uploaded</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody id="fileTableBody">
            <tr>
                <td colspan="6" class="soft">Loading files...</td>
            </tr>
            </tbody>
        </table>
    </div>
</section>
