    (function () {
        const dashboardCanvas = document.getElementById('dashboardCanvas');
        const canvasCtx = dashboardCanvas ? dashboardCanvas.getContext('2d') : null;
        const preloader = document.getElementById('pagePreloader');
        const root = document.documentElement;
        const toggle = document.getElementById('themeToggle');
        const settingsThemeToggle = document.getElementById('settingsThemeToggle');
        const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
        const sidebar = document.getElementById('dashboardSidebar');
        const sidebarLinks = document.querySelectorAll('.sidebar-nav a[href^="#"]');
        const icon = toggle ? toggle.querySelector('i') : null;
        const text = toggle ? toggle.querySelector('span') : null;
        const hero = document.querySelector('.hero');
        const tiltCards = document.querySelectorAll('.metric, .module-card');
        const statNodes = document.querySelectorAll('.metric-number');
        const ring = document.getElementById('attendanceRing');
        const ringValue = document.getElementById('attendanceRingValue');
        const forms = document.querySelectorAll('form');
        const formFields = document.querySelectorAll('.form-control, .form-select');
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');

        const fileState = {
            all: [],
            filtered: []
        };

        const formatBytes = function (bytes) {
            const val = Number(bytes || 0);
            if (val <= 0) return '0 B';
            const units = ['B', 'KB', 'MB', 'GB'];
            const exponent = Math.min(Math.floor(Math.log(val) / Math.log(1024)), units.length - 1);
            const size = val / Math.pow(1024, exponent);
            return (exponent === 0 ? size.toFixed(0) : size.toFixed(1)) + ' ' + units[exponent];
        };

        const formatDate = function (value) {
            if (!value) return '-';
            const parsed = new Date(value);
            if (Number.isNaN(parsed.getTime())) return '-';
            return parsed.toLocaleString();
        };

        const escapeHtml = function (value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        };

        const renderFileTable = function () {
            const body = document.getElementById('fileTableBody');
            if (!body) return;

            if (!fileState.filtered.length) {
                body.innerHTML = '<tr><td colspan="6" class="soft">No files found for this filter.</td></tr>';
                return;
            }

            body.innerHTML = fileState.filtered.map(function (file) {
                const roles = (file.shared_with_roles && file.shared_with_roles.length)
                    ? file.shared_with_roles.map(function (role) {
                        return '<span class="role-chip">' + escapeHtml(role) + '</span>';
                    }).join(' ')
                    : '<span class="soft">Private</span>';

                return '' +
                    '<tr>' +
                    '<td><div class="fw-semibold text-break">' + escapeHtml(file.file_name || 'Untitled') + '</div><div class="soft small">' + escapeHtml(file.description || '') + '</div></td>' +
                    '<td><span class="badge text-bg-info text-uppercase">' + escapeHtml(file.document_type || file.category || 'other') + '</span></td>' +
                    '<td>' + formatBytes(file.file_size) + '</td>' +
                    '<td class="role-wrap">' + roles + '</td>' +
                    '<td>' + formatDate(file.created_at) + '</td>' +
                    '<td class="text-end file-actions-cell">' +
                    '<a href="/portal/files/' + encodeURIComponent(file._id) + '/download" class="btn btn-sm btn-outline-primary me-1">Download</a>' +
                    '<button type="button" class="btn btn-sm btn-outline-danger js-file-delete" data-id="' + escapeHtml(file._id) + '">Delete</button>' +
                    '</td>' +
                    '</tr>';
            }).join('');
        };

        const applyFileFilter = function () {
            const filter = document.getElementById('fileTypeFilter');
            const selected = filter ? filter.value : '';
            if (!selected) {
                fileState.filtered = fileState.all.slice();
            } else {
                fileState.filtered = fileState.all.filter(function (item) {
                    return (item.document_type || item.category || '').toLowerCase() === selected.toLowerCase();
                });
            }
            renderFileTable();
        };

        const showFileAlert = function (message, type) {
            const alertBox = document.getElementById('fileUploadAlert');
            if (!alertBox) return;
            alertBox.className = 'mt-3 alert alert-' + (type || 'info');
            alertBox.textContent = message;
            setTimeout(function () {
                alertBox.classList.add('d-none');
            }, 3500);
        };

        const loadFiles = function () {
            const body = document.getElementById('fileTableBody');
            if (body) {
                body.innerHTML = '<tr><td colspan="6" class="soft">Loading files...</td></tr>';
            }

            return fetch('/portal/files', {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Unable to load files right now.');
                    }
                    return response.json();
                })
                .then(function (data) {
                    fileState.all = Array.isArray(data) ? data : [];
                    applyFileFilter();
                })
                .catch(function (error) {
                    if (body) {
                        body.innerHTML = '<tr><td colspan="6" class="text-danger">' + error.message + '</td></tr>';
                    }
                });
        };

        const initFileManagement = function () {
            const uploadForm = document.getElementById('fileUploadForm');
            const typeFilter = document.getElementById('fileTypeFilter');
            const refreshBtn = document.getElementById('refreshFilesBtn');
            const tableBody = document.getElementById('fileTableBody');
            const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

            if (!uploadForm || !typeFilter || !refreshBtn || !tableBody) return;

            loadFiles();

            typeFilter.addEventListener('change', applyFileFilter);

            refreshBtn.addEventListener('click', function () {
                loadFiles();
            });

            uploadForm.addEventListener('submit', function (event) {
                event.preventDefault();
                const formData = new FormData(uploadForm);

                fetch('/portal/files/upload', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(function (response) {
                        return response.json().then(function (payload) {
                            return { ok: response.ok, payload: payload };
                        });
                    })
                    .then(function (result) {
                        if (!result.ok) {
                            const errorMessage = result.payload && result.payload.message
                                ? result.payload.message
                                : 'Upload failed.';
                            throw new Error(errorMessage);
                        }

                        uploadForm.reset();
                        showFileAlert('File uploaded successfully.', 'success');
                        return loadFiles();
                    })
                    .catch(function (error) {
                        showFileAlert(error.message || 'Upload failed.', 'danger');
                    });
            });

            tableBody.addEventListener('click', function (event) {
                const target = event.target.closest('.js-file-delete');
                if (!target) return;

                const id = target.getAttribute('data-id');
                if (!id) return;

                if (!window.confirm('Delete this file permanently?')) return;

                fetch('/portal/files/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                    .then(function (response) {
                        return response.json().then(function (payload) {
                            return { ok: response.ok, payload: payload };
                        });
                    })
                    .then(function (result) {
                        if (!result.ok) {
                            const errorMessage = result.payload && result.payload.error
                                ? result.payload.error
                                : 'Delete failed.';
                            throw new Error(errorMessage);
                        }
                        showFileAlert('File deleted successfully.', 'success');
                        return loadFiles();
                    })
                    .catch(function (error) {
                        showFileAlert(error.message || 'Delete failed.', 'danger');
                    });
            });
        };

        const initAdvancedReports = function () {
            const fromInput = document.getElementById('reportFromDate');
            const toInput = document.getElementById('reportToDate');
            const standardFilter = document.getElementById('reportStandardFilter');
            const entityTypeFilter = document.getElementById('reportEntityTypeFilter');
            const refreshBtn = document.getElementById('refreshReportSummary');
            const reportAlert = document.getElementById('reportAlert');
            const resultsExportLink = document.getElementById('resultsExportLink');
            const attendanceExportLink = document.getElementById('attendanceExportLink');
            const totalResults = document.getElementById('reportTotalResults');
            const passRate = document.getElementById('reportPassRate');
            const averageMarks = document.getElementById('reportAverageMarks');
            const attendanceRate = document.getElementById('reportAttendanceRate');
            const topPerformersBody = document.getElementById('topPerformersBody');
            const subjectPerformanceBody = document.getElementById('subjectPerformanceBody');
            const standardPerformanceBody = document.getElementById('standardPerformanceBody');
            const trendBars = document.getElementById('resultsTrendBars');

            if (!fromInput || !toInput || !standardFilter || !entityTypeFilter || !refreshBtn || !resultsExportLink || !attendanceExportLink || !topPerformersBody || !subjectPerformanceBody || !standardPerformanceBody || !trendBars) {
                return;
            }

            const showReportAlert = function (message, type) {
                if (!reportAlert) return;
                reportAlert.className = 'mt-2 alert alert-' + (type || 'info');
                reportAlert.textContent = message;
                setTimeout(function () {
                    reportAlert.classList.add('d-none');
                }, 3000);
            };

            const buildQueryString = function (forAttendance) {
                const params = new URLSearchParams();
                if (fromInput.value) params.set('from', fromInput.value);
                if (toInput.value) params.set('to', toInput.value);
                if (!forAttendance && standardFilter.value) params.set('standard_id', standardFilter.value);
                if (forAttendance && entityTypeFilter.value) params.set('entity_type', entityTypeFilter.value);
                return params.toString();
            };

            const syncExportLinks = function () {
                const resultQuery = buildQueryString(false);
                const attendanceQuery = buildQueryString(true);
                const resultBase = '/portal/reports/results/export';
                const attendanceBase = '/portal/reports/attendance/export';

                resultsExportLink.href = resultQuery ? (resultBase + '?' + resultQuery) : resultBase;
                attendanceExportLink.href = attendanceQuery ? (attendanceBase + '?' + attendanceQuery) : attendanceBase;
            };

            const renderTopPerformers = function (performers) {
                if (!Array.isArray(performers) || performers.length === 0) {
                    topPerformersBody.innerHTML = '<tr><td colspan="4" class="soft">No performers found for selected filters.</td></tr>';
                    return;
                }

                topPerformersBody.innerHTML = performers.map(function (row) {
                    return '' +
                        '<tr>' +
                        '<td>' + escapeHtml(row.student || '-') + '</td>' +
                        '<td>' + escapeHtml(row.exam || '-') + '</td>' +
                        '<td>' + escapeHtml(row.marks || '-') + '</td>' +
                        '<td>' + escapeHtml(row.grade || '-') + '</td>' +
                        '</tr>';
                }).join('');
            };

            const renderSubjectPerformance = function (rows) {
                if (!Array.isArray(rows) || rows.length === 0) {
                    subjectPerformanceBody.innerHTML = '<tr><td colspan="4" class="soft">No subject data found.</td></tr>';
                    return;
                }

                subjectPerformanceBody.innerHTML = rows.map(function (row) {
                    return '' +
                        '<tr>' +
                        '<td>' + escapeHtml(row.subject || '-') + '</td>' +
                        '<td>' + escapeHtml((row.total_results || 0).toString()) + '</td>' +
                        '<td>' + escapeHtml((row.average_marks || 0).toString()) + '</td>' +
                        '<td>' + escapeHtml((row.pass_rate || 0).toString()) + '%</td>' +
                        '</tr>';
                }).join('');
            };

            const renderStandardPerformance = function (rows) {
                if (!Array.isArray(rows) || rows.length === 0) {
                    standardPerformanceBody.innerHTML = '<tr><td colspan="4" class="soft">No standard data found.</td></tr>';
                    return;
                }

                standardPerformanceBody.innerHTML = rows.map(function (row) {
                    return '' +
                        '<tr>' +
                        '<td>' + escapeHtml(row.standard || '-') + '</td>' +
                        '<td>' + escapeHtml((row.total_results || 0).toString()) + '</td>' +
                        '<td>' + escapeHtml((row.average_marks || 0).toString()) + '</td>' +
                        '<td>' + escapeHtml((row.pass_rate || 0).toString()) + '%</td>' +
                        '</tr>';
                }).join('');
            };

            const renderMonthlyTrend = function (rows) {
                if (!Array.isArray(rows) || rows.length === 0) {
                    trendBars.innerHTML = '<p class="soft small mb-0">No monthly trend data found.</p>';
                    return;
                }

                const lastSix = rows.slice(-6);
                const maxCount = Math.max.apply(null, lastSix.map(function (row) {
                    return row.total_results || 0;
                })) || 1;

                trendBars.innerHTML = lastSix.map(function (row) {
                    const monthLabel = row.month && row.month !== 'Unknown' ? row.month : 'N/A';
                    const count = row.total_results || 0;
                    const height = Math.max(8, Math.round((count / maxCount) * 90));

                    return '' +
                        '<div class="report-trend-item">' +
                        '<div class="report-trend-value">' + escapeHtml(count.toString()) + '</div>' +
                        '<div class="report-trend-bar" style="height:' + height + 'px"></div>' +
                        '<div class="report-trend-label">' + escapeHtml(monthLabel) + '</div>' +
                        '</div>';
                }).join('');
            };

            const loadSummary = function () {
                syncExportLinks();
                refreshBtn.classList.add('loading');

                const query = buildQueryString(false);
                const endpoint = query ? ('/portal/reports/summary?' + query) : '/portal/reports/summary';

                fetch(endpoint, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error('Unable to load report summary.');
                        }
                        return response.json();
                    })
                    .then(function (data) {
                        if (totalResults) totalResults.textContent = (data.total_results || 0).toLocaleString();
                        if (passRate) passRate.textContent = (data.pass_rate || 0) + '%';
                        if (averageMarks) averageMarks.textContent = data.average_marks || 0;
                        if (attendanceRate) attendanceRate.textContent = (data.attendance_rate || 0) + '%';
                        renderTopPerformers(data.top_performers || []);
                        renderSubjectPerformance(data.subject_performance || []);
                        renderStandardPerformance(data.standard_performance || []);
                        renderMonthlyTrend(data.monthly_trend || []);
                    })
                    .catch(function (error) {
                        showReportAlert(error.message || 'Failed to load summary.', 'danger');
                    })
                    .finally(function () {
                        refreshBtn.classList.remove('loading');
                    });
            };

            fromInput.addEventListener('change', syncExportLinks);
            toInput.addEventListener('change', syncExportLinks);
            standardFilter.addEventListener('change', syncExportLinks);
            entityTypeFilter.addEventListener('change', syncExportLinks);

            refreshBtn.addEventListener('click', function () {
                loadSummary();
            });

            syncExportLinks();
            loadSummary();
        };

        const resizeCanvas = function () {
            if (!dashboardCanvas || !canvasCtx) return;
            dashboardCanvas.width = window.innerWidth;
            dashboardCanvas.height = window.innerHeight;
        };

        const initCanvasAnimation = function () {
            if (!dashboardCanvas || !canvasCtx) return;
            resizeCanvas();

            const particleCount = window.innerWidth > 1200 ? 110 : 70;
            const particles = [];

            for (let i = 0; i < particleCount; i++) {
                particles.push({
                    x: Math.random() * dashboardCanvas.width,
                    y: Math.random() * dashboardCanvas.height,
                    vx: (Math.random() - 0.5) * 0.45,
                    vy: (Math.random() - 0.5) * 0.45,
                    radius: Math.random() * 1.7 + 0.5,
                    alpha: Math.random() * 0.48 + 0.14
                });
            }

            const drawFrame = function () {
                canvasCtx.clearRect(0, 0, dashboardCanvas.width, dashboardCanvas.height);

                particles.forEach(function (p, i) {
                    p.x += p.vx;
                    p.y += p.vy;

                    if (p.x < 0 || p.x > dashboardCanvas.width) p.vx *= -1;
                    if (p.y < 0 || p.y > dashboardCanvas.height) p.vy *= -1;

                    canvasCtx.beginPath();
                    canvasCtx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                    canvasCtx.fillStyle = 'rgba(96,165,250,' + p.alpha + ')';
                    canvasCtx.fill();

                    for (let j = i + 1; j < particles.length; j++) {
                        const other = particles[j];
                        const dx = p.x - other.x;
                        const dy = p.y - other.y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < 135) {
                            canvasCtx.strokeStyle = 'rgba(34,211,238,' + (0.16 * (1 - dist / 135)) + ')';
                            canvasCtx.lineWidth = 0.7;
                            canvasCtx.beginPath();
                            canvasCtx.moveTo(p.x, p.y);
                            canvasCtx.lineTo(other.x, other.y);
                            canvasCtx.stroke();
                        }
                    }
                });

                requestAnimationFrame(drawFrame);
            };

            drawFrame();
            window.addEventListener('resize', resizeCanvas);
        };

        const initSmartTables = function () {
            const tables = document.querySelectorAll('.table-responsive table');
            tables.forEach(function (table, index) {
                const tbody = table.querySelector('tbody');
                if (!tbody) return;

                const allRows = Array.from(tbody.querySelectorAll('tr'));
                const dataRows = allRows.filter(function (row) {
                    return !row.querySelector('td[colspan]');
                });
                const emptyRows = allRows.filter(function (row) {
                    return !!row.querySelector('td[colspan]');
                });

                if (dataRows.length === 0) return;

                const wrapper = table.closest('.table-responsive');
                if (!wrapper || wrapper.previousElementSibling?.classList.contains('table-tools')) return;

                const tools = document.createElement('div');
                tools.className = 'table-tools';
                tools.innerHTML = '' +
                    '<input type="text" class="form-control form-control-sm table-search" placeholder="Search in table..." aria-label="Search table">' +
                    '<select class="form-select form-select-sm table-page-size" aria-label="Rows per page">' +
                    '<option value="5">5 rows</option>' +
                    '<option value="10" selected>10 rows</option>' +
                    '<option value="15">15 rows</option>' +
                    '<option value="25">25 rows</option>' +
                    '</select>';

                const pager = document.createElement('div');
                pager.className = 'table-pagination';
                pager.innerHTML = '' +
                    '<span class="page-status">Page 1</span>' +
                    '<div class="pager-actions">' +
                    '<button type="button" class="btn btn-sm btn-outline-secondary prev-page">Prev</button>' +
                    '<button type="button" class="btn btn-sm btn-outline-secondary next-page">Next</button>' +
                    '</div>';

                wrapper.parentNode.insertBefore(tools, wrapper);
                wrapper.parentNode.insertBefore(pager, wrapper.nextSibling);

                const searchInput = tools.querySelector('.table-search');
                const pageSizeSelect = tools.querySelector('.table-page-size');
                const prevBtn = pager.querySelector('.prev-page');
                const nextBtn = pager.querySelector('.next-page');
                const status = pager.querySelector('.page-status');

                let currentPage = 1;
                let pageSize = parseInt(pageSizeSelect.value, 10);
                let filtered = dataRows.slice();

                const render = function () {
                    const totalPages = Math.max(1, Math.ceil(filtered.length / pageSize));
                    if (currentPage > totalPages) currentPage = totalPages;
                    const start = (currentPage - 1) * pageSize;
                    const end = start + pageSize;

                    dataRows.forEach(function (row) {
                        row.style.display = 'none';
                    });

                    if (filtered.length === 0) {
                        emptyRows.forEach(function (row) {
                            row.style.display = '';
                            const cell = row.querySelector('td[colspan]');
                            if (cell) cell.textContent = 'No matching records found.';
                        });
                    } else {
                        emptyRows.forEach(function (row) {
                            row.style.display = 'none';
                        });
                        filtered.slice(start, end).forEach(function (row) {
                            row.style.display = '';
                        });
                    }

                    status.textContent = 'Page ' + currentPage + ' of ' + totalPages + ' • ' + filtered.length + ' records';
                    prevBtn.disabled = currentPage <= 1;
                    nextBtn.disabled = currentPage >= totalPages;
                };

                searchInput.addEventListener('input', function () {
                    const term = searchInput.value.trim().toLowerCase();
                    filtered = dataRows.filter(function (row) {
                        return row.textContent.toLowerCase().indexOf(term) !== -1;
                    });
                    currentPage = 1;
                    render();
                });

                pageSizeSelect.addEventListener('change', function () {
                    pageSize = parseInt(pageSizeSelect.value, 10);
                    currentPage = 1;
                    render();
                });

                prevBtn.addEventListener('click', function () {
                    if (currentPage > 1) {
                        currentPage -= 1;
                        render();
                    }
                });

                nextBtn.addEventListener('click', function () {
                    const totalPages = Math.max(1, Math.ceil(filtered.length / pageSize));
                    if (currentPage < totalPages) {
                        currentPage += 1;
                        render();
                    }
                });

                render();
            });
        };

        const apply = (theme) => {
            root.setAttribute('data-theme', theme);
            if (!icon || !text) return;
            if (theme === 'dark') {
                icon.className = 'fa-solid fa-sun me-1';
                text.textContent = 'Light';
            } else {
                icon.className = 'fa-solid fa-moon me-1';
                text.textContent = 'Dark';
            }
        };

        const saved = localStorage.getItem('theme') || 'light';
        apply(saved);

        window.addEventListener('load', function () {
            setTimeout(function () {
                preloader.classList.add('hide');
            }, 350);
        });

        const toggleTheme = function () {
            const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', next);
            apply(next);
        };

        if (toggle) {
            toggle.addEventListener('click', toggleTheme);
        }

        if (settingsThemeToggle) {
            settingsThemeToggle.addEventListener('click', toggleTheme);
        }

        if (mobileSidebarToggle && sidebar) {
            mobileSidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('show-mobile');
            });
        }

        sidebarLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                sidebarLinks.forEach(function (node) { node.classList.remove('active'); });
                link.classList.add('active');
                if (window.innerWidth <= 992 && sidebar) {
                    sidebar.classList.remove('show-mobile');
                }
            });
        });

        const animateCount = function (el) {
            const target = parseInt(el.getAttribute('data-count') || '0', 10);
            const duration = 1200;
            const start = performance.now();

            const tick = function (now) {
                const p = Math.min((now - start) / duration, 1);
                const val = Math.floor(target * (1 - Math.pow(1 - p, 3)));
                el.textContent = val.toLocaleString();
                if (p < 1) {
                    requestAnimationFrame(tick);
                }
            };

            requestAnimationFrame(tick);
        };

        statNodes.forEach(animateCount);

        const ringTarget = 92;
        let ringCurrent = 0;
        const ringTimer = setInterval(function () {
            ringCurrent += 2;
            if (ringCurrent > ringTarget) {
                ringCurrent = ringTarget;
                clearInterval(ringTimer);
            }
            if (ring && ringValue) {
                ring.style.setProperty('--deg', (ringCurrent * 3.6) + 'deg');
                ringValue.textContent = ringCurrent + '%';
            }
        }, 22);

        forms.forEach(function (form) {
            form.addEventListener('submit', function () {
                const btn = form.querySelector('.js-submit-btn');
                if (!btn) return;
                btn.classList.add('loading');
                setTimeout(function () {
                    btn.classList.remove('loading');
                }, 1800);
            });
        });

        formFields.forEach(function (field) {
            field.addEventListener('focus', function () {
                field.classList.add('focus-3d');
            });
            field.addEventListener('blur', function () {
                field.classList.remove('focus-3d');
            });
        });

        const tilt = function (el, e) {
            const rect = el.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const midX = rect.width / 2;
            const midY = rect.height / 2;
            const rotateY = ((x - midX) / midX) * 4;
            const rotateX = -((y - midY) / midY) * 4;
            el.style.transform = 'perspective(900px) rotateX(' + rotateX.toFixed(2) + 'deg) rotateY(' + rotateY.toFixed(2) + 'deg) translateY(-2px)';
        };

        const resetTilt = function (el) {
            el.style.transform = '';
        };

        if (window.innerWidth > 992) {
            if (hero) {
                hero.addEventListener('mousemove', function (e) {
                    tilt(hero, e);
                });
                hero.addEventListener('mouseleave', function () {
                    resetTilt(hero);
                });
            }

            tiltCards.forEach(function (card) {
                card.addEventListener('mousemove', function (e) {
                    tilt(card, e);
                });
                card.addEventListener('mouseleave', function () {
                    resetTilt(card);
                });
            });
        }

        initCanvasAnimation();
        initSmartTables();
        initFileManagement();
        initAdvancedReports();
    })();
