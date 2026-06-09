<?php

require_once dirname(__DIR__, 2) . '/config/database.php';
$db = Database::getConnection();


$activeMembersCount = $db->query("SELECT COUNT(*) FROM members WHERE status = 'active'")->fetchColumn();
$pendingRecruitsCount = $db->query("SELECT COUNT(*) FROM recruitment WHERE status = 'pending'")->fetchColumn();
$totalAchievementsCount = $db->query("SELECT COUNT(*) FROM achievements")->fetchColumn();
$totalEventsCount = $db->query("SELECT COUNT(*) FROM events")->fetchColumn();


$recentContacts = $db->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 4")->fetchAll();


$recentApplicants = $db->query("SELECT * FROM recruitment ORDER BY applied_at DESC LIMIT 4")->fetchAll();

$title = "Admin Overview";
require_once __DIR__ . '/layouts/header.php';
?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="mb-8 p-4 bg-brandGreen/10 border border-brandGreen/30 text-white rounded text-xs animate-fade-in">
        <?= e($_SESSION['success_message']) ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="mb-8 p-4 bg-brandRed/10 border border-brandRed/30 text-white rounded text-xs animate-fade-in">
        <?= e($_SESSION['error_message']) ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    
    
    <div class="glass-panel p-6 rounded relative overflow-hidden group hover:border-brandRed/30 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Active Members</span>
            <div class="p-2 bg-brandRed/10 rounded text-brandRed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
        <div class="text-3xl font-serif font-bold text-white mb-1"><?= $activeMembersCount ?></div>
        <p class="text-[10px] text-gray-500 font-light">Debaters currently active in society</p>
    </div>

    
    <div class="glass-panel p-6 rounded relative overflow-hidden group hover:border-brandGreen/30 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Pending Applicants</span>
            <div class="p-2 bg-brandGreen/10 rounded text-brandGreen">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
        </div>
        <div class="text-3xl font-serif font-bold text-white mb-1"><?= $pendingRecruitsCount ?></div>
        <p class="text-[10px] text-gray-500 font-light">New applicant submissions awaiting review</p>
    </div>

    
    <div class="glass-panel p-6 rounded relative overflow-hidden group hover:border-brandRed/30 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Achievements</span>
            <div class="p-2 bg-brandRed/10 rounded text-brandRed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
            </div>
        </div>
        <div class="text-3xl font-serif font-bold text-white mb-1"><?= $totalAchievementsCount ?></div>
        <p class="text-[10px] text-gray-500 font-light">Trophies, speaker prizes, and awards</p>
    </div>

    
    <div class="glass-panel p-6 rounded relative overflow-hidden group hover:border-brandGreen/30 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Total Events</span>
            <div class="p-2 bg-brandGreen/10 rounded text-brandGreen">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <div class="text-3xl font-serif font-bold text-white mb-1"><?= $totalEventsCount ?></div>
        <p class="text-[10px] text-gray-500 font-light">Scheduled workshops, debates, and festivals</p>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    
    <div class="lg:col-span-6 glass-panel p-6 rounded">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/5">
            <h2 class="font-serif text-lg font-semibold text-white">Recent Applications</h2>
            <a href="<?= $base_path ?>/admin/recruitment" class="text-[10px] text-brandRed uppercase tracking-wider font-semibold hover:underline">View All</a>
        </div>
        
        <?php if (!empty($recentApplicants)): ?>
            <div class="space-y-4">
                <?php foreach ($recentApplicants as $applicant): ?>
                    <div class="p-4 bg-white/5 border border-white/5 rounded hover:border-white/10 transition-colors">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-xs font-semibold text-white"><?= e($applicant['name']) ?></span>
                            <span class="text-[9px] uppercase tracking-wider px-2 py-0.5 rounded text-white bg-amber-500/20 border border-amber-500/30">
                                <?= e($applicant['status']) ?>
                            </span>
                        </div>
                        <p class="text-[10px] text-gray-400 font-light mb-2">
                            <?= e($applicant['department']) ?> &bull; Roll: <?= e($applicant['roll_no']) ?>
                        </p>
                        <p class="text-[11px] text-gray-300 font-light italic line-clamp-2 bg-black/40 p-2 rounded">
                            "<?= e($applicant['motivation']) ?>"
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-xs text-gray-500 italic py-8 text-center">No applications pending review.</p>
        <?php endif; ?>
    </div>

    
    <div class="lg:col-span-6 glass-panel p-6 rounded">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/5">
            <h2 class="font-serif text-lg font-semibold text-white">Recent Messages</h2>
            <span class="text-[9px] text-gray-500 uppercase tracking-widest">Inbox Registry</span>
        </div>
        
        <?php if (!empty($recentContacts)): ?>
            <div class="space-y-4">
                <?php foreach ($recentContacts as $msg): ?>
                    <div class="p-4 bg-white/5 border border-white/5 rounded hover:border-white/10 transition-all duration-300 relative">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="text-xs font-semibold text-white block"><?= e($msg['name']) ?></span>
                                <a href="mailto:<?= e($msg['email']) ?>" class="text-[10px] text-gray-400 hover:text-brandRed transition-colors font-mono">
                                    <?= e($msg['email']) ?>
                                </a>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-[9px] text-gray-500 font-mono"><?= date('M d, H:i', strtotime($msg['created_at'])) ?></span>
                                <button onclick="deleteContact(<?= $msg['id'] ?>, '<?= e(addslashes($msg['name'])) ?>')" class="text-gray-600 hover:text-brandRed transition-colors p-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <span class="text-[10px] text-brandRed font-semibold block mb-2"><?= e($msg['subject']) ?></span>
                        <p class="text-xs text-gray-300 font-light leading-relaxed bg-black/40 p-2.5 rounded">
                            <?= e($msg['message']) ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>

            <form id="delete-contact-form" action="<?= $base_path ?>/admin/contacts/delete" method="POST" class="hidden">
                <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">
                <input type="hidden" name="id" id="delete-contact-id">
            </form>

            <script>
                function deleteContact(id, name) {
                    if (confirm(`Are you sure you want to delete the message from '${name}'?`)) {
                        document.getElementById('delete-contact-id').value = id;
                        document.getElementById('delete-contact-form').submit();
                    }
                }
            </script>
        <?php else: ?>
            <p class="text-xs text-gray-500 italic py-8 text-center">No messages received.</p>
        <?php endif; ?>
    </div>

</div>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>