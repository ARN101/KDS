<?php
// views/admin/achievements.php
$title = "Achievements Management";
require_once __DIR__ . '/layouts/header.php';
?>

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <!-- Search Bar -->
    <div class="relative w-full sm:max-w-xs">
        <input type="text" id="achievement-search" placeholder="Search achievements..." 
               class="w-full pl-10 pr-4 py-2.5 bg-black/60 border border-white/10 rounded text-sm text-white placeholder-gray-600 focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed transition-all duration-300">
        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Add Achievement Trigger -->
    <button onclick="toggleModal('add-modal')" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded shadow-lg shadow-brandRed/20 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Achievement
    </button>
</div>

<!-- Achievements Table Panel -->
<div class="glass-panel rounded overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="achievements-table">
            <thead>
                <tr class="border-b border-white/5 bg-black/35 text-[10px] uppercase tracking-widest text-gray-400">
                    <th class="py-4 px-6 font-semibold">Award Title</th>
                    <th class="py-4 px-6 font-semibold">Competition Name</th>
                    <th class="py-4 px-6 font-semibold">Winning Team / Members</th>
                    <th class="py-4 px-6 font-semibold">Year</th>
                    <th class="py-4 px-6 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-xs text-gray-300">
                <?php if (!empty($achievements)): ?>
                    <?php foreach ($achievements as $ach): ?>
                        <tr class="achievement-row hover:bg-white/[0.01] transition-colors" 
                            data-title="<?= e(strtolower($ach['title'])) ?>"
                            data-comp="<?= e(strtolower($ach['competition'])) ?>"
                            data-members="<?= e(strtolower($ach['team_members'])) ?>">
                            
                            <!-- Award Title -->
                            <td class="py-4 px-6">
                                <div class="font-bold text-white text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <?= e($ach['title']) ?>
                                </div>
                            </td>

                            <!-- Competition -->
                            <td class="py-4 px-6 font-medium text-gray-200">
                                <?= e($ach['competition']) ?>
                            </td>

                            <!-- Members -->
                            <td class="py-4 px-6 text-gray-400">
                                <?= e($ach['team_members']) ?>
                            </td>

                            <!-- Year -->
                            <td class="py-4 px-6 text-gray-500 font-mono">
                                <?= e($ach['year']) ?>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right space-x-2">
                                <button onclick='openEditModal(<?= json_encode($ach) ?>)' class="px-3 py-1.5 bg-white/5 border border-white/10 hover:border-brandRed hover:text-brandRed text-[10px] uppercase tracking-widest font-medium rounded transition-all duration-300">
                                    Edit
                                </button>
                                <button onclick="confirmDelete(<?= $ach['id'] ?>, '<?= e(addslashes($ach['title'])) ?>')" class="px-3 py-1.5 bg-brandRed/10 border border-brandRed/20 hover:bg-brandRed hover:text-white text-[10px] uppercase tracking-widest font-medium rounded transition-all duration-300">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-500 italic">No achievements logged.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ==========================================
     ADD ACHIEVEMENT MODAL
     ========================================== -->
<div id="add-modal" class="fixed inset-0 w-full h-full bg-black/80 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
    <div class="w-full max-w-xl glass-panel p-6 md:p-8 rounded-lg relative overflow-hidden spotlight-card">
        <div class="flex items-center justify-between mb-6 pb-2 border-b border-white/5">
            <h2 class="font-serif text-lg font-bold text-white">Log Achievement</h2>
            <button onclick="toggleModal('add-modal')" class="text-gray-400 hover:text-brandRed transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="<?= $base_path ?>/admin/achievements/create" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Title -->
                <div class="flex flex-col">
                    <label for="add-title" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Award Title *</label>
                    <input type="text" id="add-title" name="title" required placeholder="e.g. Champion, Best Speaker" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <!-- Year -->
                <div class="flex flex-col">
                    <label for="add-year" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Competition Year *</label>
                    <input type="number" id="add-year" name="year" required value="<?= date('Y') ?>" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>
            </div>

            <!-- Competition -->
            <div class="flex flex-col">
                <label for="add-comp" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Competition Name *</label>
                <input type="text" id="add-comp" name="competition" required placeholder="e.g. 14th DUDS National Debate Championship" 
                       class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
            </div>

            <!-- Team Members -->
            <div class="flex flex-col">
                <label for="add-members" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Winning Members *</label>
                <input type="text" id="add-members" name="team_members" required placeholder="e.g. Adnan Rahman, Tasnim Alam, Nihad Hossain" 
                       class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
            </div>

            <!-- Description -->
            <div class="flex flex-col">
                <label for="add-desc" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Description / Remarks</label>
                <textarea id="add-desc" name="description" rows="3" placeholder="Brief outline of debate score, tournament scale, or topics argued in final..." 
                          class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all"></textarea>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="toggleModal('add-modal')" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Save Record
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================
     EDIT ACHIEVEMENT MODAL
     ========================================== -->
<div id="edit-modal" class="fixed inset-0 w-full h-full bg-black/80 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
    <div class="w-full max-w-xl glass-panel p-6 md:p-8 rounded-lg relative overflow-hidden spotlight-card">
        <div class="flex items-center justify-between mb-6 pb-2 border-b border-white/5">
            <h2 class="font-serif text-lg font-bold text-white">Edit Achievement</h2>
            <button onclick="toggleModal('edit-modal')" class="text-gray-400 hover:text-brandRed transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="<?= $base_path ?>/admin/achievements/edit" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
            <input type="hidden" name="id" id="edit-id">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Title -->
                <div class="flex flex-col">
                    <label for="edit-title" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Award Title *</label>
                    <input type="text" id="edit-title" name="title" required 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <!-- Year -->
                <div class="flex flex-col">
                    <label for="edit-year" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Competition Year *</label>
                    <input type="number" id="edit-year" name="year" required 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>
            </div>

            <!-- Competition -->
            <div class="flex flex-col">
                <label for="edit-comp" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Competition Name *</label>
                <input type="text" id="edit-comp" name="competition" required 
                       class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
            </div>

            <!-- Team Members -->
            <div class="flex flex-col">
                <label for="edit-members" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Winning Members *</label>
                <input type="text" id="edit-members" name="team_members" required 
                       class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
            </div>

            <!-- Description -->
            <div class="flex flex-col">
                <label for="edit-desc" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Description / Remarks</label>
                <textarea id="edit-desc" name="description" rows="3" 
                          class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all"></textarea>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="toggleModal('edit-modal')" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Update Record
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================
     DELETE CONFIRMATION FORM (Hidden)
     ========================================== -->
<form action="<?= $base_path ?>/admin/achievements/delete" method="POST" id="delete-form" class="hidden">
    <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
    <input type="hidden" name="id" id="delete-id">
</form>

<script>
    // Search logic
    const searchInput = document.getElementById('achievement-search');
    const tableRows = document.querySelectorAll('.achievement-row');

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        tableRows.forEach(row => {
            const title = row.getAttribute('data-title');
            const comp = row.getAttribute('data-comp');
            const members = row.getAttribute('data-members');
            
            if (title.includes(query) || comp.includes(query) || members.includes(query)) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    });

    // Toggle Modal
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal.classList.contains('opacity-0')) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
        } else {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.classList.remove('opacity-100', 'pointer-events-auto');
        }
    }

    // Open Edit Modal
    function openEditModal(ach) {
        document.getElementById('edit-id').value = ach.id;
        document.getElementById('edit-title').value = ach.title || '';
        document.getElementById('edit-year').value = ach.year || '';
        document.getElementById('edit-comp').value = ach.competition || '';
        document.getElementById('edit-members').value = ach.team_members || '';
        document.getElementById('edit-desc').value = ach.description || '';
        
        toggleModal('edit-modal');
    }

    // Delete Trigger
    function confirmDelete(id, title) {
        if (confirm(`Are you sure you want to permanently delete the achievement record '${title}'?`)) {
            document.getElementById('delete-id').value = id;
            document.getElementById('delete-form').submit();
        }
    }
</script>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>
