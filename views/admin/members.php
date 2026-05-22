<?php
// views/admin/members.php
$title = "Members Registry";
require_once __DIR__ . '/layouts/header.php';
?>

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <!-- Search Bar -->
    <div class="relative w-full sm:max-w-xs">
        <input type="text" id="member-search" placeholder="Search members..." 
               class="w-full pl-10 pr-4 py-2.5 bg-black/60 border border-white/10 rounded text-sm text-white placeholder-gray-600 focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed transition-all duration-300">
        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Add Member Trigger -->
    <button onclick="toggleModal('add-modal')" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded shadow-lg shadow-brandRed/20 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Member
    </button>
</div>

<!-- Members Table Panel -->
<div class="glass-panel rounded overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="members-table">
            <thead>
                <tr class="border-b border-white/5 bg-black/35 text-[10px] uppercase tracking-widest text-gray-400">
                    <th class="py-4 px-6 font-semibold">Avatar</th>
                    <th class="py-4 px-6 font-semibold">Name & Contact</th>
                    <th class="py-4 px-6 font-semibold">Designation</th>
                    <th class="py-4 px-6 font-semibold">Biography</th>
                    <th class="py-4 px-6 font-semibold">Status</th>
                    <th class="py-4 px-6 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-xs text-gray-300">
                <?php if (!empty($members)): ?>
                    <?php foreach ($members as $member): ?>
                        <?php 
                            // Determine image source
                            $img_src = $member['image_path'];
                            if (empty($img_src)) {
                                $img_src = "https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=100";
                            } elseif (strpos($img_src, 'http') !== 0) {
                                $img_src = $base_path . '/' . $img_src;
                            }
                        ?>
                        <tr class="member-row hover:bg-white/[0.01] transition-colors" 
                            data-name="<?= e(strtolower($member['name'])) ?>"
                            data-role="<?= e(strtolower($member['role_title'])) ?>"
                            data-status="<?= e(strtolower($member['status'])) ?>">
                            
                            <!-- Image -->
                            <td class="py-4 px-6">
                                <div class="w-10 h-10 rounded-full border border-white/10 overflow-hidden bg-black">
                                    <img src="<?= e($img_src) ?>" alt="Avatar" class="w-full h-full object-cover">
                                </div>
                            </td>

                            <!-- Name & Contact -->
                            <td class="py-4 px-6">
                                <div class="font-semibold text-white text-sm"><?= e($member['name']) ?></div>
                                <div class="text-[10px] text-gray-500 font-mono mt-0.5"><?= e($member['email'] ?? 'No email logged') ?></div>
                            </td>

                            <!-- Designation -->
                            <td class="py-4 px-6 font-medium text-gray-200">
                                <?= e($member['role_title']) ?>
                            </td>

                            <!-- Biography -->
                            <td class="py-4 px-6 max-w-xs truncate font-light text-gray-400">
                                <?= e($member['bio'] ?? '---') ?>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-0.5 rounded-full text-[9px] uppercase tracking-wider font-semibold 
                                    <?= $member['status'] === 'active' ? 'bg-brandGreen/10 text-brandGreen border border-brandGreen/20' : 'bg-gray-800 text-gray-400 border border-gray-700' ?>">
                                    <?= e($member['status']) ?>
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right space-x-2">
                                <button onclick='openEditModal(<?= json_encode($member) ?>)' class="px-3 py-1.5 bg-white/5 border border-white/10 hover:border-brandRed hover:text-brandRed text-[10px] uppercase tracking-widest font-medium rounded transition-all duration-300">
                                    Edit
                                </button>
                                <button onclick="confirmDelete(<?= $member['id'] ?>, '<?= e(addslashes($member['name'])) ?>')" class="px-3 py-1.5 bg-brandRed/10 border border-brandRed/20 hover:bg-brandRed hover:text-white text-[10px] uppercase tracking-widest font-medium rounded transition-all duration-300">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-500 italic">No members currently recorded.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ==========================================
     ADD MEMBER MODAL
     ========================================== -->
<div id="add-modal" class="fixed inset-0 w-full h-full bg-black/80 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
    <div class="w-full max-w-lg glass-panel p-6 md:p-8 rounded-lg relative overflow-hidden spotlight-card">
        <div class="flex items-center justify-between mb-6 pb-2 border-b border-white/5">
            <h2 class="font-serif text-lg font-bold text-white">Add Society Member</h2>
            <button onclick="toggleModal('add-modal')" class="text-gray-400 hover:text-brandRed transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="<?= $base_path ?>/admin/members/create" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Name -->
                <div class="flex flex-col">
                    <label for="add-name" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Full Name *</label>
                    <input type="text" id="add-name" name="name" required placeholder="e.g. Adnan Rahman" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <!-- Email -->
                <div class="flex flex-col">
                    <label for="add-email" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Email</label>
                    <input type="email" id="add-email" name="email" placeholder="e.g. user@domain.com" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Designation -->
                <div class="flex flex-col">
                    <label for="add-role" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Designation *</label>
                    <input type="text" id="add-role" name="role_title" required placeholder="e.g. Senior Debater" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <!-- Status -->
                <div class="flex flex-col">
                    <label for="add-status" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Status *</label>
                    <select id="add-status" name="status" required 
                            class="px-3.5 py-2.5 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                        <option value="active" class="bg-darkGrey">Active</option>
                        <option value="alumni" class="bg-darkGrey">Alumni</option>
                    </select>
                </div>
            </div>

            <!-- Biography -->
            <div class="flex flex-col">
                <label for="add-bio" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Biography</label>
                <textarea id="add-bio" name="bio" rows="3" placeholder="Brief summary of debate achievements, batch info, or patron descriptions..." 
                          class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all"></textarea>
            </div>

            <!-- Image Upload -->
            <div class="flex flex-col">
                <label for="add-image" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Profile Photo (Max 2MB)</label>
                <input type="file" id="add-image" name="image" accept="image/*" 
                       class="text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-[10px] file:font-semibold file:uppercase file:tracking-widest file:bg-white/5 file:text-white hover:file:bg-white/10 file:cursor-pointer transition-all">
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="toggleModal('add-modal')" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Save Member
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================
     EDIT MEMBER MODAL
     ========================================== -->
<div id="edit-modal" class="fixed inset-0 w-full h-full bg-black/80 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
    <div class="w-full max-w-lg glass-panel p-6 md:p-8 rounded-lg relative overflow-hidden spotlight-card">
        <div class="flex items-center justify-between mb-6 pb-2 border-b border-white/5">
            <h2 class="font-serif text-lg font-bold text-white">Edit Member Details</h2>
            <button onclick="toggleModal('edit-modal')" class="text-gray-400 hover:text-brandRed transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="<?= $base_path ?>/admin/members/edit" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
            <input type="hidden" name="id" id="edit-id">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Name -->
                <div class="flex flex-col">
                    <label for="edit-name" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Full Name *</label>
                    <input type="text" id="edit-name" name="name" required 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <!-- Email -->
                <div class="flex flex-col">
                    <label for="edit-email" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Email</label>
                    <input type="email" id="edit-email" name="email" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Designation -->
                <div class="flex flex-col">
                    <label for="edit-role" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Designation *</label>
                    <input type="text" id="edit-role" name="role_title" required 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <!-- Status -->
                <div class="flex flex-col">
                    <label for="edit-status" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Status *</label>
                    <select id="edit-status" name="status" required 
                            class="px-3.5 py-2.5 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                        <option value="active" class="bg-darkGrey">Active</option>
                        <option value="alumni" class="bg-darkGrey">Alumni</option>
                    </select>
                </div>
            </div>

            <!-- Biography -->
            <div class="flex flex-col">
                <label for="edit-bio" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Biography</label>
                <textarea id="edit-bio" name="bio" rows="3" 
                          class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all"></textarea>
            </div>

            <!-- Image Upload -->
            <div class="flex flex-col">
                <label for="edit-image" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Change Photo (Leave empty to keep current)</label>
                <input type="file" id="edit-image" name="image" accept="image/*" 
                       class="text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-[10px] file:font-semibold file:uppercase file:tracking-widest file:bg-white/5 file:text-white hover:file:bg-white/10 file:cursor-pointer transition-all">
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="toggleModal('edit-modal')" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Update Member
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================
     DELETE CONFIRMATION FORM (Hidden)
     ========================================== -->
<form action="<?= $base_path ?>/admin/members/delete" method="POST" id="delete-form" class="hidden">
    <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
    <input type="hidden" name="id" id="delete-id">
</form>

<!-- ==========================================
     PAGE SCRIPTS
     ========================================== -->
<script>
    // Search filtering logic
    const searchInput = document.getElementById('member-search');
    const tableRows = document.querySelectorAll('.member-row');

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        tableRows.forEach(row => {
            const name = row.getAttribute('data-name');
            const role = row.getAttribute('data-role');
            const status = row.getAttribute('data-status');
            
            if (name.includes(query) || role.includes(query) || status.includes(query)) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    });

    // Toggle Modal Utility
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

    // Open Edit Modal and fill data
    function openEditModal(member) {
        document.getElementById('edit-id').value = member.id;
        document.getElementById('edit-name').value = member.name || '';
        document.getElementById('edit-email').value = member.email || '';
        document.getElementById('edit-role').value = member.role_title || '';
        document.getElementById('edit-bio').value = member.bio || '';
        document.getElementById('edit-status').value = member.status || 'active';
        
        toggleModal('edit-modal');
    }

    // Confirm member deletion
    function confirmDelete(id, name) {
        if (confirm(`Are you absolutely sure you want to remove '${name}' from the society registry? This action cannot be undone.`)) {
            document.getElementById('delete-id').value = id;
            document.getElementById('delete-form').submit();
        }
    }
</script>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>
