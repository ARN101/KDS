<?php
// views/admin/events.php
$title = "Events Management";
require_once __DIR__ . '/layouts/header.php';
?>

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <!-- Search Bar -->
    <div class="relative w-full sm:max-w-xs">
        <input type="text" id="event-search" placeholder="Search events..." 
               class="w-full pl-10 pr-4 py-2.5 bg-black/60 border border-white/10 rounded text-sm text-white placeholder-gray-600 focus:border-brandRed focus:outline-none focus:ring-1 focus:ring-brandRed transition-all duration-300">
        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Add Event Trigger -->
    <button onclick="toggleModal('add-modal')" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-xs font-semibold uppercase tracking-widest transition-all duration-300 rounded shadow-lg shadow-brandRed/20 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Event
    </button>
</div>

<!-- Events Table Panel -->
<div class="glass-panel rounded overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="events-table">
            <thead>
                <tr class="border-b border-white/5 bg-black/35 text-[10px] uppercase tracking-widest text-gray-400">
                    <th class="py-4 px-6 font-semibold">Cover</th>
                    <th class="py-4 px-6 font-semibold">Title & Category</th>
                    <th class="py-4 px-6 font-semibold">Date & Time</th>
                    <th class="py-4 px-6 font-semibold">Venue</th>
                    <th class="py-4 px-6 font-semibold">Status</th>
                    <th class="py-4 px-6 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-xs text-gray-300">
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <?php 
                            $img_src = $event['image_path'];
                            if (empty($img_src)) {
                                $img_src = "https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&q=80&w=150";
                            } elseif (strpos($img_src, 'http') !== 0) {
                                $img_src = $base_path . '/' . $img_src;
                            }
                        ?>
                        <tr class="event-row hover:bg-white/[0.01] transition-colors" 
                            data-title="<?= e(strtolower($event['title'])) ?>"
                            data-category="<?= e(strtolower($event['category'])) ?>"
                            data-venue="<?= e(strtolower($event['venue'])) ?>">
                            
                            <!-- Cover Image -->
                            <td class="py-4 px-6">
                                <div class="w-16 h-10 border border-white/10 overflow-hidden bg-black rounded">
                                    <img src="<?= e($img_src) ?>" alt="Cover" class="w-full h-full object-cover">
                                </div>
                            </td>

                            <!-- Title & Category -->
                            <td class="py-4 px-6">
                                <div class="font-semibold text-white text-sm"><?= e($event['title']) ?></div>
                                <span class="px-2 py-0.5 mt-1 inline-block rounded text-[9px] uppercase tracking-wider font-semibold bg-white/5 border border-white/10 text-gray-400">
                                    <?= e($event['category']) ?>
                                </span>
                            </td>

                            <!-- Date & Time -->
                            <td class="py-4 px-6 font-medium text-gray-200">
                                <div><?= date('M d, Y', strtotime($event['event_date'])) ?></div>
                                <div class="text-[10px] text-gray-500 font-mono mt-0.5"><?= e($event['event_time']) ?></div>
                            </td>

                            <!-- Venue -->
                            <td class="py-4 px-6 text-gray-400">
                                <?= e($event['venue']) ?>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-6">
                                <?php if ($event['status'] === 'upcoming'): ?>
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] uppercase tracking-wider font-semibold bg-brandGreen/10 text-brandGreen border border-brandGreen/20">Upcoming</span>
                                <?php elseif ($event['status'] === 'ongoing'): ?>
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] uppercase tracking-wider font-semibold bg-amber-500/10 text-amber-500 border border-amber-500/20">Ongoing</span>
                                <?php else: ?>
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] uppercase tracking-wider font-semibold bg-gray-800 text-gray-400 border border-gray-700">Past</span>
                                <?php endif; ?>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right space-x-2">
                                <button onclick='openEditModal(<?= json_encode($event) ?>)' class="px-3 py-1.5 bg-white/5 border border-white/10 hover:border-brandRed hover:text-brandRed text-[10px] uppercase tracking-widest font-medium rounded transition-all duration-300">
                                    Edit
                                </button>
                                <button onclick="confirmDelete(<?= $event['id'] ?>, '<?= e(addslashes($event['title'])) ?>')" class="px-3 py-1.5 bg-brandRed/10 border border-brandRed/20 hover:bg-brandRed hover:text-white text-[10px] uppercase tracking-widest font-medium rounded transition-all duration-300">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-500 italic">No events currently scheduled.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ==========================================
     ADD EVENT MODAL
     ========================================== -->
<div id="add-modal" class="fixed inset-0 w-full h-full bg-black/80 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
    <div class="w-full max-w-xl glass-panel p-6 md:p-8 rounded-lg relative overflow-hidden spotlight-card">
        <div class="flex items-center justify-between mb-6 pb-2 border-b border-white/5">
            <h2 class="font-serif text-lg font-bold text-white">Create New Event</h2>
            <button onclick="toggleModal('add-modal')" class="text-gray-400 hover:text-brandRed transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="<?= $base_path ?>/admin/events/create" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

            <!-- Title -->
            <div class="flex flex-col">
                <label for="add-title" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Event Title *</label>
                <input type="text" id="add-title" name="title" required placeholder="e.g. KUET National Debate Fest 2026" 
                       class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Category -->
                <div class="flex flex-col">
                    <label for="add-category" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Category *</label>
                    <select id="add-category" name="category" required 
                            class="px-3.5 py-2.5 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                        <option value="Bangla Debate" class="bg-darkGrey">Bangla Debate</option>
                        <option value="English Debate" class="bg-darkGrey">English Debate</option>
                        <option value="Workshop" class="bg-darkGrey">Workshop</option>
                        <option value="Tournament" class="bg-darkGrey">Tournament</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="flex flex-col">
                    <label for="add-status" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Status *</label>
                    <select id="add-status" name="status" required 
                            class="px-3.5 py-2.5 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                        <option value="upcoming" class="bg-darkGrey">Upcoming</option>
                        <option value="ongoing" class="bg-darkGrey">Ongoing</option>
                        <option value="past" class="bg-darkGrey">Past</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Date -->
                <div class="flex flex-col">
                    <label for="add-date" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Event Date *</label>
                    <input type="date" id="add-date" name="event_date" required 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <!-- Time -->
                <div class="flex flex-col">
                    <label for="add-time" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Event Time *</label>
                    <input type="text" id="add-time" name="event_time" required placeholder="e.g. 15:30" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <!-- Venue -->
                <div class="flex flex-col">
                    <label for="add-venue" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Venue *</label>
                    <input type="text" id="add-venue" name="venue" required placeholder="e.g. Auditorium" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>
            </div>

            <!-- Description -->
            <div class="flex flex-col">
                <label for="add-description" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Description</label>
                <textarea id="add-description" name="description" rows="3" placeholder="Brief outline of event schedule, registration deadlines, and chief guest parameters..." 
                          class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Registration Link -->
                <div class="flex flex-col">
                    <label for="add-link" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Registration Link</label>
                    <input type="url" id="add-link" name="registration_link" placeholder="e.g. https://forms.gle/..." 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <!-- Cover Image -->
                <div class="flex flex-col">
                    <label for="add-image" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Cover Cover (Max 2MB)</label>
                    <input type="file" id="add-image" name="image" accept="image/*" 
                           class="text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-[10px] file:font-semibold file:uppercase file:tracking-widest file:bg-white/5 file:text-white hover:file:bg-white/10 file:cursor-pointer transition-all">
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="toggleModal('add-modal')" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Create Event
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================
     EDIT EVENT MODAL
     ========================================== -->
<div id="edit-modal" class="fixed inset-0 w-full h-full bg-black/80 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
    <div class="w-full max-w-xl glass-panel p-6 md:p-8 rounded-lg relative overflow-hidden spotlight-card">
        <div class="flex items-center justify-between mb-6 pb-2 border-b border-white/5">
            <h2 class="font-serif text-lg font-bold text-white">Edit Event Details</h2>
            <button onclick="toggleModal('edit-modal')" class="text-gray-400 hover:text-brandRed transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="<?= $base_path ?>/admin/events/edit" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
            <input type="hidden" name="id" id="edit-id">

            <!-- Title -->
            <div class="flex flex-col">
                <label for="edit-title" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Event Title *</label>
                <input type="text" id="edit-title" name="title" required 
                       class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Category -->
                <div class="flex flex-col">
                    <label for="edit-category" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Category *</label>
                    <select id="edit-category" name="category" required 
                            class="px-3.5 py-2.5 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                        <option value="Bangla Debate" class="bg-darkGrey">Bangla Debate</option>
                        <option value="English Debate" class="bg-darkGrey">English Debate</option>
                        <option value="Workshop" class="bg-darkGrey">Workshop</option>
                        <option value="Tournament" class="bg-darkGrey">Tournament</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="flex flex-col">
                    <label for="edit-status" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Status *</label>
                    <select id="edit-status" name="status" required 
                            class="px-3.5 py-2.5 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                        <option value="upcoming" class="bg-darkGrey">Upcoming</option>
                        <option value="ongoing" class="bg-darkGrey">Ongoing</option>
                        <option value="past" class="bg-darkGrey">Past</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Date -->
                <div class="flex flex-col">
                    <label for="edit-date" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Event Date *</label>
                    <input type="date" id="edit-date" name="event_date" required 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <!-- Time -->
                <div class="flex flex-col">
                    <label for="edit-time" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Event Time *</label>
                    <input type="text" id="edit-time" name="event_time" required 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <!-- Venue -->
                <div class="flex flex-col">
                    <label for="edit-venue" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Venue *</label>
                    <input type="text" id="edit-venue" name="venue" required 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>
            </div>

            <!-- Description -->
            <div class="flex flex-col">
                <label for="edit-description" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Description</label>
                <textarea id="edit-description" name="description" rows="3" 
                          class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Registration Link -->
                <div class="flex flex-col">
                    <label for="edit-link" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Registration Link</label>
                    <input type="url" id="edit-link" name="registration_link" 
                           class="px-3.5 py-2 bg-black/60 border border-white/10 rounded text-xs text-white focus:border-brandRed focus:outline-none transition-all">
                </div>

                <!-- Cover Image -->
                <div class="flex flex-col">
                    <label for="edit-image" class="text-[10px] uppercase tracking-widest text-gray-400 mb-1.5 font-semibold">Change Cover (Leave empty to keep current)</label>
                    <input type="file" id="edit-image" name="image" accept="image/*" 
                           class="text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-[10px] file:font-semibold file:uppercase file:tracking-widest file:bg-white/5 file:text-white hover:file:bg-white/10 file:cursor-pointer transition-all">
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="toggleModal('edit-modal')" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-brandRed hover:bg-brandRed/90 text-white text-[10px] font-semibold uppercase tracking-widest rounded transition-all">
                    Update Event
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================
     DELETE CONFIRMATION FORM (Hidden)
     ========================================== -->
<form action="<?= $base_path ?>/admin/events/delete" method="POST" id="delete-form" class="hidden">
    <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
    <input type="hidden" name="id" id="delete-id">
</form>

<script>
    // Search logic
    const searchInput = document.getElementById('event-search');
    const tableRows = document.querySelectorAll('.event-row');

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        tableRows.forEach(row => {
            const title = row.getAttribute('data-title');
            const category = row.getAttribute('data-category');
            const venue = row.getAttribute('data-venue');
            
            if (title.includes(query) || category.includes(query) || venue.includes(query)) {
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
    function openEditModal(event) {
        document.getElementById('edit-id').value = event.id;
        document.getElementById('edit-title').value = event.title || '';
        document.getElementById('edit-category').value = event.category || 'Bangla Debate';
        document.getElementById('edit-status').value = event.status || 'upcoming';
        document.getElementById('edit-date').value = event.event_date || '';
        document.getElementById('edit-time').value = event.event_time || '';
        document.getElementById('edit-venue').value = event.venue || '';
        document.getElementById('edit-description').value = event.description || '';
        document.getElementById('edit-link').value = event.registration_link || '';
        
        toggleModal('edit-modal');
    }

    // Delete Trigger
    function confirmDelete(id, title) {
        if (confirm(`Are you sure you want to permanently delete the event '${title}'?`)) {
            document.getElementById('delete-id').value = id;
            document.getElementById('delete-form').submit();
        }
    }
</script>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>
