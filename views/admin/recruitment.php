<?php
// views/admin/recruitment.php
$title = "Recruitment Applications";
require_once __DIR__ . '/layouts/header.php';

// Group applicants by status for tab counters and easy processing
$pending = [];
$approved = [];
$rejected = [];

foreach ($applicants as $app) {
    if ($app['status'] === 'approved') {
        $approved[] = $app;
    } elseif ($app['status'] === 'rejected') {
        $rejected[] = $app;
    } else {
        $pending[] = $app;
    }
}
?>

<!-- Header Actions -->
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
    <!-- Search Bar -->
    <div class="relative w-full lg:max-w-xs">
        <input type="text" id="applicant-search" placeholder="Search applicants..." 
               class="w-full pl-10 pr-4 py-2.5 bg-black/60 border border-white/10 rounded text-sm text-white placeholder-gray-600 focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed transition-all duration-300">
        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Tab Buttons -->
    <div class="flex flex-wrap items-center gap-2 bg-black/45 p-1 rounded border border-white/5">
        <button onclick="switchTab('all')" id="tab-all" class="tab-btn active px-4 py-2 text-[10px] font-semibold uppercase tracking-widest rounded transition-all duration-300 bg-brandRed text-white">
            All (<?= count($applicants) ?>)
        </button>
        <button onclick="switchTab('pending')" id="tab-pending" class="tab-btn px-4 py-2 text-[10px] font-semibold uppercase tracking-widest rounded transition-all duration-300 text-gray-400 hover:text-white">
            Pending (<?= count($pending) ?>)
        </button>
        <button onclick="switchTab('approved')" id="tab-approved" class="tab-btn px-4 py-2 text-[10px] font-semibold uppercase tracking-widest rounded transition-all duration-300 text-gray-400 hover:text-white">
            Approved (<?= count($approved) ?>)
        </button>
        <button onclick="switchTab('rejected')" id="tab-rejected" class="tab-btn px-4 py-2 text-[10px] font-semibold uppercase tracking-widest rounded transition-all duration-300 text-gray-400 hover:text-white">
            Rejected (<?= count($rejected) ?>)
        </button>
    </div>
</div>

<!-- Applicants Table Panel -->
<div class="glass-panel rounded overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="applicants-table">
            <thead>
                <tr class="border-b border-white/5 bg-black/35 text-[10px] uppercase tracking-widest text-gray-400">
                    <th class="py-4 px-6 font-semibold">Name & Dept</th>
                    <th class="py-4 px-6 font-semibold">Roll & Year</th>
                    <th class="py-4 px-6 font-semibold">Contact Info</th>
                    <th class="py-4 px-6 font-semibold">Applied At</th>
                    <th class="py-4 px-6 font-semibold">Status</th>
                    <th class="py-4 px-6 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-xs text-gray-300">
                <?php if (!empty($applicants)): ?>
                    <?php foreach ($applicants as $app): ?>
                        <tr class="applicant-row hover:bg-white/[0.01] transition-colors cursor-pointer" 
                            data-status="<?= e($app['status']) ?>"
                            data-name="<?= e(strtolower($app['name'])) ?>"
                            data-dept="<?= e(strtolower($app['department'])) ?>"
                            data-roll="<?= e(strtolower($app['roll_no'])) ?>"
                            data-email="<?= e(strtolower($app['email'])) ?>"
                            onclick="openDrawer(<?= e(json_encode($app)) ?>)">
                            
                            <!-- Name & Dept -->
                            <td class="py-4 px-6">
                                <div class="font-semibold text-white text-sm"><?= e($app['name']) ?></div>
                                <div class="text-[10px] text-gray-500 font-mono mt-0.5"><?= e($app['department']) ?></div>
                            </td>

                            <!-- Roll & Year -->
                            <td class="py-4 px-6">
                                <div class="font-medium text-gray-200"><?= e($app['roll_no']) ?></div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5"><?= e($app['academic_year']) ?></div>
                            </td>

                            <!-- Contact Info -->
                            <td class="py-4 px-6">
                                <div><?= e($app['email']) ?></div>
                                <div class="text-[10px] text-gray-500 mt-0.5 font-mono"><?= e($app['phone']) ?></div>
                            </td>

                            <!-- Applied At -->
                            <td class="py-4 px-6 font-mono text-gray-500">
                                <?= date('Y-m-d H:i', strtotime($app['applied_at'])) ?>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-6">
                                <?php if ($app['status'] === 'approved'): ?>
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] uppercase tracking-wider font-semibold bg-brandGreen/10 text-brandGreen border border-brandGreen/20">Approved</span>
                                <?php elseif ($app['status'] === 'rejected'): ?>
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] uppercase tracking-wider font-semibold bg-brandRed/10 text-brandRed border border-brandRed/20">Rejected</span>
                                <?php else: ?>
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] uppercase tracking-wider font-semibold bg-amber-500/10 text-amber-500 border border-amber-500/20">Pending</span>
                                <?php endif; ?>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right space-x-1" onclick="event.stopPropagation();">
                                <?php if ($app['status'] === 'pending'): ?>
                                    <button onclick="updateApplicantStatus(<?= $app['id'] ?>, 'approved')" class="px-2.5 py-1.5 bg-brandGreen/20 hover:bg-brandGreen hover:text-white border border-brandGreen/30 text-brandGreen text-[10px] uppercase tracking-widest font-semibold rounded transition-all duration-300">
                                        Approve
                                    </button>
                                    <button onclick="updateApplicantStatus(<?= $app['id'] ?>, 'rejected')" class="px-2.5 py-1.5 bg-brandRed/20 hover:bg-brandRed hover:text-white border border-brandRed/30 text-brandRed text-[10px] uppercase tracking-widest font-semibold rounded transition-all duration-300">
                                        Reject
                                    </button>
                                <?php else: ?>
                                    <button onclick="updateApplicantStatus(<?= $app['id'] ?>, 'pending')" class="px-2.5 py-1.5 bg-white/5 border border-white/10 hover:border-brandRed hover:text-brandRed text-[10px] uppercase tracking-widest font-semibold rounded transition-all duration-300">
                                        Revert to Pending
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-500 italic">No recruitment submissions registered.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ==========================================
     RECRUITMENT DETAIL SLIDEOUT DRAWER
     ========================================== -->
<div id="detail-drawer" class="fixed inset-y-0 right-0 w-full max-w-lg bg-darkGrey/95 backdrop-blur-md border-l border-white/10 z-50 shadow-2xl translate-x-full transition-transform duration-500 ease-out flex flex-col">
    <!-- Drawer Header -->
    <div class="px-6 py-6 border-b border-white/5 flex items-center justify-between bg-black/30">
        <div>
            <h2 class="font-serif text-lg font-bold text-white" id="drawer-name">Applicant Name</h2>
            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold font-sans mt-0.5" id="drawer-meta-title">Roll, Year & Dept</p>
        </div>
        <button onclick="closeDrawer()" class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:text-brandRed hover:border-brandRed/30 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Drawer Content -->
    <div class="flex-grow overflow-y-auto p-6 space-y-6">
        <!-- Contact Info Cards -->
        <div class="grid grid-cols-2 gap-4">
            <div class="glass-panel p-4 rounded bg-black/40">
                <span class="text-[9px] uppercase tracking-wider text-gray-500 block mb-1">Email Address</span>
                <span class="text-xs font-semibold text-white break-all" id="drawer-email">email@domain.com</span>
            </div>
            <div class="glass-panel p-4 rounded bg-black/40">
                <span class="text-[9px] uppercase tracking-wider text-gray-500 block mb-1">Phone Number</span>
                <span class="text-xs font-semibold text-white font-mono" id="drawer-phone">017XXXXXXXX</span>
            </div>
        </div>

        <!-- Academic Info -->
        <div class="glass-panel p-4 rounded bg-black/40 space-y-3">
            <h3 class="text-[10px] uppercase tracking-widest text-brandRed font-semibold border-b border-white/5 pb-1">Academic Status</h3>
            <div class="grid grid-cols-3 gap-2 text-xs">
                <div>
                    <span class="text-[9px] text-gray-500 block">Department</span>
                    <span class="font-medium text-white" id="drawer-dept">CSE</span>
                </div>
                <div>
                    <span class="text-[9px] text-gray-500 block">Roll No</span>
                    <span class="font-medium text-white font-mono" id="drawer-roll">1807001</span>
                </div>
                <div>
                    <span class="text-[9px] text-gray-500 block">Academic Year</span>
                    <span class="font-medium text-white" id="drawer-year">1st Year</span>
                </div>
            </div>
        </div>

        <!-- Debating Experience -->
        <div class="space-y-2">
            <h3 class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Debating Experience</h3>
            <div class="bg-black/60 border border-white/10 p-4 rounded text-xs text-gray-300 font-light leading-relaxed" id="drawer-experience">
                No experience logged.
            </div>
        </div>

        <!-- Motivation (Statement of Purpose) -->
        <div class="space-y-2">
            <h3 class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Motivation Statement</h3>
            <div class="bg-brandRed/5 border border-brandRed/10 p-4 rounded text-xs text-gray-300 font-light leading-relaxed italic relative overflow-hidden" id="drawer-motivation">
                "Statement of purpose values."
            </div>
        </div>
    </div>

    <!-- Drawer Footer Actions -->
    <div class="p-6 border-t border-white/5 bg-black/40 flex gap-3" id="drawer-actions">
        <!-- Buttons injected dynamically or form submission handler -->
    </div>
</div>

<!-- ==========================================
     UPDATE STATUS FORM (Hidden)
     ========================================== -->
<form action="<?= $base_path ?>/admin/recruitment/status" method="POST" id="status-form" class="hidden">
    <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
    <input type="hidden" name="id" id="status-id">
    <input type="hidden" name="status" id="status-value">
</form>

<script>
    // Tab switching logic
    let activeTab = 'all';
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tableRows = document.querySelectorAll('.applicant-row');
    const searchInput = document.getElementById('applicant-search');

    function filterTable() {
        const query = searchInput.value.toLowerCase().trim();

        tableRows.forEach(row => {
            const status = row.getAttribute('data-status');
            const name = row.getAttribute('data-name');
            const dept = row.getAttribute('data-dept');
            const roll = row.getAttribute('data-roll');
            const email = row.getAttribute('data-email');

            const matchesSearch = name.includes(query) || dept.includes(query) || roll.includes(query) || email.includes(query);
            const matchesTab = activeTab === 'all' || status === activeTab;

            if (matchesSearch && matchesTab) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }

    function switchTab(tab) {
        activeTab = tab;

        // Reset active style on buttons
        tabButtons.forEach(btn => {
            btn.classList.remove('bg-brandRed', 'text-white', 'active');
            btn.classList.add('text-gray-400', 'hover:text-white');
        });

        // Set active class
        const activeBtn = document.getElementById(`tab-${tab}`);
        activeBtn.classList.add('bg-brandRed', 'text-white', 'active');
        activeBtn.classList.remove('text-gray-400', 'hover:text-white');

        filterTable();
    }

    searchInput.addEventListener('input', filterTable);

    // Side Drawer Logic
    const drawer = document.getElementById('detail-drawer');

    function openDrawer(app) {
        document.getElementById('drawer-name').innerText = app.name;
        document.getElementById('drawer-meta-title').innerText = `${app.academic_year} • ${app.department} • Roll ${app.roll_no}`;
        
        document.getElementById('drawer-email').innerText = app.email;
        document.getElementById('drawer-phone').innerText = app.phone;
        document.getElementById('drawer-dept').innerText = app.department;
        document.getElementById('drawer-roll').innerText = app.roll_no;
        document.getElementById('drawer-year').innerText = app.academic_year;

        document.getElementById('drawer-experience').innerText = app.debating_experience || 'No previous debating experience reported.';
        document.getElementById('drawer-motivation').innerText = `"${app.motivation}"`;

        // Update actions based on current status
        const actionContainer = document.getElementById('drawer-actions');
        actionContainer.innerHTML = ''; // Clear

        if (app.status === 'pending') {
            actionContainer.innerHTML = `
                <button onclick="updateApplicantStatus(${app.id}, 'approved')" class="flex-1 py-3 bg-brandGreen hover:bg-brandGreen/90 text-white text-xs font-semibold uppercase tracking-widest rounded transition-all duration-300 shadow-md">
                    Approve Applicant
                </button>
                <button onclick="updateApplicantStatus(${app.id}, 'rejected')" class="flex-1 py-3 bg-brandRed hover:bg-brandRed/90 text-white text-xs font-semibold uppercase tracking-widest rounded transition-all duration-300 shadow-md">
                    Reject Applicant
                </button>
            `;
        } else {
            actionContainer.innerHTML = `
                <button onclick="updateApplicantStatus(${app.id}, 'pending')" class="flex-1 py-3 bg-white/5 border border-white/10 hover:bg-brandRed hover:border-brandRed/30 hover:text-white text-white text-xs font-semibold uppercase tracking-widest rounded transition-all duration-300">
                    Revert Application to Pending
                </button>
            `;
        }

        // Open animation with GSAP or css class
        drawer.classList.remove('translate-x-full');
    }

    function closeDrawer() {
        drawer.classList.add('translate-x-full');
    }

    // Update applicant status submitter
    function updateApplicantStatus(id, newStatus) {
        let msg = '';
        if (newStatus === 'approved') {
            msg = "Are you sure you want to approve this applicant?";
        } else if (newStatus === 'rejected') {
            msg = "Are you sure you want to reject this applicant?";
        } else {
            msg = "Revert this application back to pending status?";
        }

        if (confirm(msg)) {
            document.getElementById('status-id').value = id;
            document.getElementById('status-value').value = newStatus;
            document.getElementById('status-form').submit();
        }
    }
</script>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>
