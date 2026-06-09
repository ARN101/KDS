<?php

$title = "Gallery Manager";
require_once __DIR__ . '/layouts/header.php';
?>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
        
        <div class="relative w-full sm:w-64">
            <input type="text" id="gallery-search" placeholder="Search gallery..." 
                   class="w-full pl-10 pr-4 py-2.5 bg-black/60 border border-white/10 rounded text-sm text-white placeholder-gray-600 focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed transition-all duration-300">
            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        
        <select id="gallery-filter-category" 
                class="px-3.5 py-2.5 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
            <option value="all">All Categories</option>
            <option value="Weekly Sessions">Weekly Sessions</option>
            <option value="National Tournaments">National Tournaments</option>
            <option value="Workshops">Workshops</option>
            <option value="Social Events">Social Events</option>
        </select>
    </div>

    
    <button onclick="toggleModal('add-modal')" class="w-full sm:w-auto px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded shadow-lg shadow-brandRed/20 flex items-center justify-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Photo
    </button>
</div>

<?php if (!empty($photos)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="gallery-grid">
        <?php foreach ($photos as $photo): ?>
            <?php 
                $img_src = $photo['file_path'];
                if (empty($img_src)) {
                    $img_src = "https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&q=80&w=300";
                } elseif (strpos($img_src, 'http') !== 0) {
                    $img_src = $base_path . '/' . $img_src;
                }
            ?>
            <div class="gallery-card group glass-panel rounded overflow-hidden aspect-[4/3] relative flex flex-col justify-end spotlight-card cursor-pointer border border-white/5 hover:border-brandRed/30 transition-all duration-500" 
                 data-title="<?= e(strtolower($photo['title'])) ?>"
                 data-caption="<?= e(strtolower($photo['caption'] ?? '')) ?>"
                 data-category="<?= e($photo['category']) ?>">
                
                
                <img src="<?= e($img_src) ?>" alt="<?= e($photo['title']) ?>" class="absolute inset-0 w-full h-full object-cover scale-100 group-hover:scale-105 transition-all duration-700 ease-out z-0">
                
                
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-75 group-hover:opacity-90 transition-opacity duration-300 z-10"></div>
                
                
                <div class="absolute top-3 right-3 z-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button onclick="event.stopPropagation(); confirmDelete(<?= $photo['id'] ?>, '<?= e(addslashes($photo['title'])) ?>')" 
                            class="p-2 bg-brandRed/20 hover:bg-brandRed border border-brandRed/30 text-white rounded transition-colors duration-300"
                            title="Delete Image">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>

                
                <div class="p-5 relative z-20 flex flex-col justify-end">
                    <span class="text-[9px] uppercase tracking-wider text-brandRed font-semibold mb-1 block">
                        <?= e($photo['category']) ?>
                    </span>
                    <h3 class="font-serif text-sm font-bold text-white leading-tight">
                        <?= e($photo['title']) ?>
                    </h3>
                    <p class="text-[10px] text-gray-400 mt-1 line-clamp-2 font-light">
                        <?= e($photo['caption'] ?? 'No description logged.') ?>
                    </p>
                    <span class="text-[8px] font-mono text-gray-500 mt-2 block">
                        Uploaded: <?= date('Y-m-d H:i', strtotime($photo['upload_date'])) ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="glass-panel p-12 text-center rounded">
        <p class="text-gray-500 font-light italic">No images currently uploaded to the gallery.</p>
    </div>
<?php endif; ?>

<div id="add-modal" class="fixed inset-0 w-full h-full bg-black/80 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
    <div class="w-full max-w-lg glass-panel p-6 md:p-8 rounded-lg relative overflow-hidden spotlight-card">
        <div class="flex items-center justify-between mb-6 pb-2 border-b border-white/5">
            <h2 class="font-serif text-lg font-bold text-white">Upload New Photo</h2>
            <button onclick="toggleModal('add-modal')" class="text-gray-400 hover:text-brandRed transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="<?= $base_path ?>/admin/gallery/create" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

            
            <div class="flex flex-col">
                <label for="add-title" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Image Title *</label>
                <input type="text" id="add-title" name="title" required placeholder="e.g. Debate Finals Group Shot" 
                       class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
            </div>

            
            <div class="flex flex-col">
                <label for="add-category" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Category *</label>
                <select id="add-category" name="category" required 
                        class="px-3.5 py-2.5 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                    <option value="Weekly Sessions" class="bg-darkGrey">Weekly Sessions</option>
                    <option value="National Tournaments" class="bg-darkGrey">National Tournaments</option>
                    <option value="Workshops" class="bg-darkGrey">Workshops</option>
                    <option value="Social Events" class="bg-darkGrey">Social Events</option>
                </select>
            </div>

            
            <div class="flex flex-col">
                <label for="add-caption" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Caption / Description</label>
                <textarea id="add-caption" name="caption" rows="3" placeholder="Describe the scene, people, or event..." 
                          class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all"></textarea>
            </div>

            
            <div class="flex flex-col">
                <label for="add-image" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Select Image * (Max 2MB, JPG/PNG/WEBP)</label>
                <input type="file" id="add-image" name="image" accept="image/*" required
                       class="text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-[10px] file:font-semibold file:uppercase file:tracking-widest file:bg-white/5 file:text-white hover:file:bg-white/10 file:cursor-pointer transition-all">
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="toggleModal('add-modal')" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Upload Photo
                </button>
            </div>
        </form>
    </div>
</div>

<form action="<?= $base_path ?>/admin/gallery/delete" method="POST" id="delete-form" class="hidden">
    <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
    <input type="hidden" name="id" id="delete-id">
</form>

<script>
    
    const searchInput = document.getElementById('gallery-search');
    const categoryFilter = document.getElementById('gallery-filter-category');
    const cards = document.querySelectorAll('.gallery-card');

    function applyFilter() {
        const query = searchInput.value.toLowerCase().trim();
        const category = categoryFilter.value;

        cards.forEach(card => {
            const title = card.getAttribute('data-title');
            const caption = card.getAttribute('data-caption');
            const cardCategory = card.getAttribute('data-category');

            const matchesSearch = title.includes(query) || caption.includes(query);
            const matchesCategory = category === 'all' || cardCategory === category;

            if (matchesSearch && matchesCategory) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', applyFilter);
    categoryFilter.addEventListener('change', applyFilter);

    
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

    
    function confirmDelete(id, title) {
        if (confirm(`Are you sure you want to permanently delete the photo '${title}'?`)) {
            document.getElementById('delete-id').value = id;
            document.getElementById('delete-form').submit();
        }
    }
</script>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>
