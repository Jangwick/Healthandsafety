<?php
/**
 * Full Notifications View - Premium Version
 */
?>

<style>
    .notifications-master {
        max-width: 900px;
        margin: 0 auto;
        width: 100%;
    }

    .notif-header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .notif-card {
        background: var(--card-bg-1);
        border: 1px solid var(--border-color-1);
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        gap: 1.5rem;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .notif-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px var(--shadow-1);
        border-color: var(--primary-color-1);
    }

    .notif-card.unread {
        background: var(--header-bg-1);
        border-left: 4px solid var(--primary-color-1);
    }

    .notif-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .notif-content {
        flex: 1;
    }

    .notif-title {
        font-weight: 800;
        font-size: 1.05rem;
        color: var(--text-color-1);
        margin-bottom: 0.25rem;
    }

    .notif-message {
        color: var(--text-secondary-1);
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 0.5rem;
    }

    .notif-meta {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-secondary-1);
        opacity: 0.7;
        display: flex;
        gap: 1.5rem;
        align-items: center;
    }

    .notif-action-btn {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        background: var(--bg-color-1);
        border: 1px solid var(--border-color-1);
        color: var(--primary-color-1);
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .notif-action-btn:hover {
        background: var(--primary-color-1);
        color: white;
    }

    .btn-mark-all {
        background: var(--primary-color-1);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
    }

    .btn-mark-all:hover {
        filter: brightness(1.1);
        transform: translateY(-2px);
    }
</style>

<div class="notifications-master">
    <div class="notif-header-actions">
        <div>
            <h2 style="font-weight: 900; color: var(--text-color-1); margin: 0;">Archive & Intel</h2>
            <p style="color: var(--text-secondary-1); margin: 0; font-size: 0.9rem;">Historical log of system communications</p>
        </div>
        <button class="btn-mark-all" onclick="markAllNotificationsRead()">
            <i class="fas fa-check-double"></i> Mark All as Read
        </button>
    </div>

    <div id="fullNotifList">
        <?php if (empty($notifications)): ?>
            <div style="text-align: center; padding: 5rem 2rem; border: 2px dashed var(--border-color-1); border-radius: 30px; background: var(--header-bg-1);">
                <i class="fas fa-satellite fa-4x" style="color: var(--border-color-1); margin-bottom: 2rem;"></i>
                <h3 style="font-weight: 800; color: var(--text-color-1);">Registry Clear</h3>
                <p style="color: var(--text-secondary-1);">No broadcast signals have been received in this cycle.</p>
            </div>
        <?php else: ?>
            <?php foreach ($notifications as $notif): 
                $accentColor = match($notif['type']) {
                    'success' => '#10b981',
                    'warning' => '#f59e0b',
                    'error' => '#ef4444',
                    default => '#3b82f6'
                };
            ?>
                <div class="notif-card <?= $notif['is_read'] ? '' : 'unread' ?>" data-id="<?= $notif['id'] ?>">
                    <div class="notif-icon-box" style="background: <?= $accentColor ?>15; color: <?= $accentColor ?>; border: 1px solid <?= $accentColor ?>30;">
                        <i class="<?= $notif['icon'] ?>"></i>
                    </div>
                    <div class="notif-content">
                        <div class="notif-title"><?= htmlspecialchars($notif['title']) ?></div>
                        <div class="notif-message"><?= htmlspecialchars($notif['message']) ?></div>
                        <div class="notif-meta">
                            <span><i class="far fa-clock me-1"></i> <span class="time-text" data-time="<?= $notif['created_at'] ?>"></span></span>
                            <?php if ($notif['link'] && $notif['link'] !== '#'): ?>
                                <a href="<?= $notif['link'] ?>" class="notif-action-btn" onclick="markReadLocal(<?= $notif['id'] ?>)">Inspect Vector</a>
                            <?php endif; ?>
                            <?php if (!$notif['is_read']): ?>
                                <span style="color: <?= $accentColor ?>;"><i class="fas fa-circle me-1"></i> Critical Unread</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    function markAllNotificationsRead() {
        fetch('/notifications/mark-all-read')
            .then(res => res.json())
            .then(() => {
                window.location.reload();
            });
    }

    function markReadLocal(id) {
        fetch('/notifications/mark-read?id=' + id);
    }

    function updateTimes() {
        document.querySelectorAll('.time-text').forEach(el => {
            const time = new Date(el.dataset.time);
            el.textContent = timeAgo(time);
        });
    }

    function timeAgo(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        let interval = seconds / 31536000;
        if (interval > 1) return Math.floor(interval) + "y ago";
        interval = seconds / 2592000;
        if (interval > 1) return Math.floor(interval) + "mo ago";
        interval = seconds / 86400;
        if (interval > 1) return Math.floor(interval) + "d ago";
        interval = seconds / 3600;
        if (interval > 1) return Math.floor(interval) + "h ago";
        interval = seconds / 60;
        if (interval > 1) return Math.floor(interval) + "m ago";
        return Math.floor(seconds) + "s ago";
    }

    updateTimes();
    setInterval(updateTimes, 30000);
</script>
