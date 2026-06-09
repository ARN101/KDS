<?php

$title = "Debates Management";
require_once __DIR__ . '/layouts/header.php';
?>


<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    
    <div class="relative w-full sm:max-w-xs">
        <input type="text" id="debate-search" placeholder="Search debates..." 
               class="w-full pl-10 pr-4 py-2.5 bg-black/60 border border-white/10 rounded text-sm text-white placeholder-gray-600 focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed transition-all duration-300">
        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    
    <button onclick="toggleModal('add-modal')" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded shadow-lg shadow-brandRed/20 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Debate Record
    </button>
</div>


<div class="glass-panel rounded overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="debates-table">
            <thead>
                <tr class="border-b border-white/5 bg-black/35 text-[10px] uppercase tracking-widest text-gray-400">
                    <th class="py-4 px-6 font-semibold">Title & Category</th>
                    <th class="py-4 px-6 font-semibold">Debate Type</th>
                    <th class="py-4 px-6 font-semibold">Motion</th>
                    <th class="py-4 px-6 font-semibold">Outcome</th>
                    <th class="py-4 px-6 font-semibold">Date</th>
                    <th class="py-4 px-6 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-xs text-gray-300">
                <?php if (!empty($debates)): ?>
                    <?php foreach ($debates as $debate): ?>
                        <tr class="debate-row hover:bg-white/[0.01] transition-colors" 
                            data-title="<?= e(strtolower($debate['title'])) ?>"
                            data-type="<?= e(strtolower($debate['debate_type'])) ?>"
                            data-motion="<?= e(strtolower($debate['motion'])) ?>">
                            
                            
                            <td class="py-4 px-6">
                                <div class="font-semibold text-white text-sm"><?= e($debate['title']) ?></div>
                                <span class="px-2 py-0.5 mt-1 inline-block rounded text-[9px] uppercase tracking-wider font-semibold bg-white/5 border border-white/10 text-gray-400">
                                    <?= e($debate['category']) ?>
                                </span>
                            </td>

                            
                            <td class="py-4 px-6 font-medium text-gray-200">
                                <?= e($debate['debate_type']) ?>
                            </td>

                            
                            <td class="py-4 px-6 max-w-xs truncate text-gray-400 italic font-light">
                                "<?= e($debate['motion']) ?>"
                            </td>

                            
                            <td class="py-4 px-6 text-gray-300 font-medium">
                                <?= e($debate['outcome'] ?? '---') ?>
                            </td>

                            
                            <td class="py-4 px-6 text-gray-500 font-mono">
                                <?= $debate['debate_date'] ? date('Y-m-d', strtotime($debate['debate_date'])) : '---' ?>
                            </td>

                            
                            <td class="py-4 px-6 text-right space-x-2">
                                <button onclick='openEditModal(<?= json_encode($debate) ?>)' class="px-3 py-1.5 bg-white/5 border border-white/10 hover:border-brandRed hover:text-brandRed text-[10px] uppercase tracking-widest font-medium rounded transition-all duration-300">
                                    Edit
                                </button>
                                <button onclick="confirmDelete(<?= $debate['id'] ?>, '<?= e(addslashes($debate['title'])) ?>')" class="px-3 py-1.5 bg-brandRed/10 border border-brandRed/20 hover:bg-brandRed hover:text-white text-[10px] uppercase tracking-widest font-medium rounded transition-all duration-300">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-500 italic">No debate records logged.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<div id="add-modal" class="fixed inset-0 w-full h-full bg-black/80 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
    <div class="w-full max-w-xl glass-panel p-6 md:p-8 rounded-lg relative overflow-hidden spotlight-card">
        <div class="flex items-center justify-between mb-6 pb-2 border-b border-white/5">
            <h2 class="font-serif text-lg font-bold text-white">Add Debate Record</h2>
            <button onclick="toggleModal('add-modal')" class="text-gray-400 hover:text-brandRed transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="<?= $base_path ?>/admin/debates/create" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div class="flex flex-col">
                    <label for="add-title" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Debate Title *</label>
                    <input type="text" id="add-title" name="title" required placeholder="e.g. Intra-KUET Championship Finals" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                
                <div class="flex flex-col">
                    <label for="add-type" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Format Type *</label>
                    <select id="add-type" name="debate_type" required 
                            class="px-3.5 py-2.5 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                        <option value="British Parliamentary" class="bg-darkGrey">British Parliamentary</option>
                        <option value="Asian Parliamentary" class="bg-darkGrey">Asian Parliamentary</option>
                        <option value="Traditional" class="bg-darkGrey">Traditional</option>
                    </select>
                </div>
            </div>

            
            <div class="flex flex-col">
                <label for="add-motion" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Motion / Topic *</label>
                <input type="text" id="add-motion" name="motion" required placeholder="e.g. This House would regulate artificial intelligence development." 
                       class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                
                <div class="flex flex-col">
                    <label for="add-category" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Language *</label>
                    <select id="add-category" name="category" required 
                            class="px-3.5 py-2.5 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                        <option value="English" class="bg-darkGrey">English</option>
                        <option value="Bangla" class="bg-darkGrey">Bangla</option>
                    </select>
                </div>

                
                <div class="flex flex-col">
                    <label for="add-date" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Debate Date</label>
                    <input type="date" id="add-date" name="debate_date" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <div class="flex flex-col">
                    <label for="add-video" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">YouTube Video URL *</label>
                    <input type="text" id="add-video" name="video_url" required placeholder="e.g. https://www.youtube.com/watch?v=3v3gU0-dDkM" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>
            </div>

            
            <div class="flex flex-col">
                <label for="add-participants" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Key Participants / Teams</label>
                <input type="text" id="add-participants" name="participants" placeholder="e.g. Gov: Team A, Opp: Team B" 
                       class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div class="flex flex-col">
                    <label for="add-outcome" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Outcome / Decision</label>
                    <input type="text" id="add-outcome" name="outcome" placeholder="e.g. Government won (3-0)" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                
                <div class="flex flex-col">
                    <label for="add-description" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Additional Details</label>
                    <input type="text" id="add-description" name="description" placeholder="Brief context or panel information..." 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="toggleModal('add-modal')" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Add Debate
                </button>
            </div>
        </form>
    </div>
</div>


<div id="edit-modal" class="fixed inset-0 w-full h-full bg-black/80 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
    <div class="w-full max-w-xl glass-panel p-6 md:p-8 rounded-lg relative overflow-hidden spotlight-card">
        <div class="flex items-center justify-between mb-6 pb-2 border-b border-white/5">
            <h2 class="font-serif text-lg font-bold text-white">Edit Debate Record</h2>
            <button onclick="toggleModal('edit-modal')" class="text-gray-400 hover:text-brandRed transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="<?= $base_path ?>/admin/debates/edit" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
            <input type="hidden" name="id" id="edit-id">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div class="flex flex-col">
                    <label for="edit-title" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Debate Title *</label>
                    <input type="text" id="edit-title" name="title" required 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                
                <div class="flex flex-col">
                    <label for="edit-type" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Format Type *</label>
                    <select id="edit-type" name="debate_type" required 
                            class="px-3.5 py-2.5 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                        <option value="British Parliamentary" class="bg-darkGrey">British Parliamentary</option>
                        <option value="Asian Parliamentary" class="bg-darkGrey">Asian Parliamentary</option>
                        <option value="Traditional" class="bg-darkGrey">Traditional</option>
                    </select>
                </div>
            </div>

            
            <div class="flex flex-col">
                <label for="edit-motion" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Motion / Topic *</label>
                <input type="text" id="edit-motion" name="motion" required 
                       class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                
                <div class="flex flex-col">
                    <label for="edit-category" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Language *</label>
                    <select id="edit-category" name="category" required 
                            class="px-3.5 py-2.5 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                        <option value="English" class="bg-darkGrey">English</option>
                        <option value="Bangla" class="bg-darkGrey">Bangla</option>
                    </select>
                </div>

                
                <div class="flex flex-col">
                    <label for="edit-date" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Debate Date</label>
                    <input type="date" id="edit-date" name="debate_date" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <div class="flex flex-col">
                    <label for="edit-video" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">YouTube Video URL *</label>
                    <input type="text" id="edit-video" name="video_url" required placeholder="e.g. https://www.youtube.com/watch?v=3v3gU0-dDkM" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>
            </div>

            
            <div class="flex flex-col">
                <label for="edit-participants" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Key Participants / Teams</label>
                <input type="text" id="edit-participants" name="participants" 
                       class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div class="flex flex-col">
                    <label for="edit-outcome" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Outcome / Decision</label>
                    <input type="text" id="edit-outcome" name="outcome" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                
                <div class="flex flex-col">
                    <label for="edit-description" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Additional Details</label>
                    <input type="text" id="edit-description" name="description" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="toggleModal('edit-modal')" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Update Debate
                </button>
            </div>
        </form>
    </div>
</div>


<form action="<?= $base_path ?>/admin/debates/delete" method="POST" id="delete-form" class="hidden">
    <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
    <input type="hidden" name="id" id="delete-id">
</form>

<script>
    
    const searchInput = document.getElementById('debate-search');
    const tableRows = document.querySelectorAll('.debate-row');

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        tableRows.forEach(row => {
            const title = row.getAttribute('data-title');
            const type = row.getAttribute('data-type');
            const motion = row.getAttribute('data-motion');
            
            if (title.includes(query) || type.includes(query) || motion.includes(query)) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    });

    
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

    
    function openEditModal(debate) {
        document.getElementById('edit-id').value = debate.id;
        document.getElementById('edit-title').value = debate.title || '';
        document.getElementById('edit-type').value = debate.debate_type || 'British Parliamentary';
        document.getElementById('edit-motion').value = debate.motion || '';
        document.getElementById('edit-category').value = debate.category || 'English';
        document.getElementById('edit-date').value = debate.debate_date || '';
        document.getElementById('edit-video').value = debate.video_url || '';
        document.getElementById('edit-participants').value = debate.participants || '';
        document.getElementById('edit-outcome').value = debate.outcome || '';
        document.getElementById('edit-description').value = debate.description || '';
        
        toggleModal('edit-modal');
    }

    
    function confirmDelete(id, title) {
        if (confirm(`Are you sure you want to permanently delete the debate record '${title}'?`)) {
            document.getElementById('delete-id').value = id;
            document.getElementById('delete-form').submit();
        }
    }
</script>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>
