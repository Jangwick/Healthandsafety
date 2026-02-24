<?php if (isset($_GET['error'])): ?>
    <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; border: 1px solid #fecaca; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <i class="fas fa-exclamation-circle"></i>
        <span style="font-size: 0.875rem; font-weight: 500; flex: 1;"><?= htmlspecialchars($_GET['error']) ?></span>
    </div>
<?php endif; ?>

<style>
    /* Modal Styles */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
        backdrop-filter: blur(5px);
        padding: 20px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .modal-content {
        max-width: 90%;
        max-height: 80vh;
        border-radius: 12px;
        box-shadow: 0 0 30px rgba(0,0,0,0.5);
        object-fit: contain;
    }
    .modal-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }
    .modal-close:hover { color: #bbb; }
    .modal-caption {
        margin-top: 20px;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        text-align: center;
    }

    .badge-status {
        font-size: 0.875rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 0.6rem 1rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        display: inline-block;
        width: 100%;
        text-align: center;
    }
</style>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start;">
    <div class="left-column">
        <!-- Main Information -->
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1); margin-bottom: 1.5rem; overflow: hidden;">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: var(--text-color-1);">
                    <i class="fas fa-info-circle" style="margin-right: 0.5rem; color: #4c8a89;"></i>Violation Information
                </h3>
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <a href="/violations/edit?id=<?= $violation['id'] ?>" class="btn btn-outline-warning" style="font-size: 0.75rem; padding: 0.4rem 1rem; border-radius: 6px; text-decoration: none; border: 1px solid #f59e0b; color: #f59e0b; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-edit"></i> Edit Record
                    </a>
                    <span style="background: var(--bg-color-1); color: var(--text-secondary-1); font-size: 0.75rem; padding: 0.4rem 1rem; border-radius: 6px; border: 1px solid var(--border-color-1); font-weight: 600;">ID: #<?= $violation['id'] ?></span>
                </div>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">Establishment</label>
                        <div style="font-size: 1.125rem; font-weight: 700; color: var(--text-color-1); display: flex; align-items: center; gap: 0.75rem;">
                            <div style="color: var(--text-secondary-1);"><i class="fas fa-building"></i></div>
                            <?= htmlspecialchars($violation['establishment_name']) ?>
                        </div>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">Inspector</label>
                        <div style="font-size: 1.125rem; font-weight: 700; color: var(--text-color-1); display: flex; align-items: center; gap: 0.75rem;">
                            <div style="color: var(--text-secondary-1);"><i class="fas fa-user-shield"></i></div>
                            <?= htmlspecialchars($violation['inspector_name']) ?>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">Location</label>
                    <div style="color: var(--text-color-1); font-weight: 500; display: flex; align-items: center; gap: 0.75rem;">
                        <div style="color: #ef4444;"><i class="fas fa-map-marker-alt"></i></div>
                        <?= htmlspecialchars($violation['location']) ?>
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">Violation Description</label>
                    <div style="padding: 1.25rem; background: #fff5f5; border-radius: 10px; border-left: 5px solid #ef4444; color: #991b1b; font-weight: 500; line-height: 1.6; font-size: 0.95rem;">
                        <?= nl2br(htmlspecialchars($violation['description'])) ?>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; align-items: center;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">Inspection Score</label>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="flex: 1; height: 10px; background: #e5e7eb; border-radius: 5px; overflow: hidden;">
                                <div style="width: <?= $violation['score'] ?>%; height: 100%; background: linear-gradient(to right, #ef4444, #f59e0b); border-radius: 5px;"></div>
                            </div>
                            <span style="font-weight: 800; color: var(--text-color-1); font-size: 1rem;"><?= number_format($violation['score'], 2) ?>%</span>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">Recorded On</label>
                        <div style="color: var(--text-secondary-1); font-size: 0.9rem; font-weight: 500;"><?= date('F d, Y h:i A', strtotime($violation['created_at'])) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status History -->
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1); margin-bottom: 1.5rem; overflow: hidden;">
            <div class="card-header" style="background: rgba(0,0,0,0.02); border-bottom: 1px solid var(--border-color-1); padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-history" style="color: var(--text-secondary-1);"></i>
                <h5 style="margin: 0; font-size: 1rem; font-weight: 700; color: var(--text-color-1);">Status History</h5>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="table-container" style="border: none; box-shadow: none;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: rgba(0,0,0,0.01);">
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">Date & Time</th>
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">Action</th>
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">User</th>
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 800; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logs ?? [])): ?>
                                <tr>
                                    <td colspan="4" style="padding: 3rem; text-align: center; color: var(--text-secondary-1); font-weight: 500;">No history records found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($logs as $log): ?>
                                    <?php $changes = json_decode($log['changes_json'], true); ?>
                                    <tr style="border-bottom: 1px solid var(--border-color-1);">
                                        <td style="padding: 1.25rem 1.5rem; font-size: 0.85rem; color: var(--text-secondary-1);">
                                            <div style="font-weight: 600;"><?= date('M d, Y', strtotime($log['timestamp'])) ?></div>
                                            <div style="font-size: 0.75rem; opacity: 0.8;"><?= date('H:i', strtotime($log['timestamp'])) ?></div>
                                        </td>
                                        <td style="padding: 1.25rem 1.5rem;">
                                            <span style="font-size: 0.7rem; font-weight: 800; background: #f3f4f6; padding: 0.35rem 0.75rem; border-radius: 6px; border: 1px solid #e5e7eb; color: #374151; letter-spacing: 0.02em;"><?= $log['action'] ?></span>
                                        </td>
                                        <td style="padding: 1.25rem 1.5rem; font-size: 0.85rem; color: var(--text-color-1); font-weight: 600;"><?= htmlspecialchars($log['user_name'] ?? 'System') ?></td>
                                        <td style="padding: 1.25rem 1.5rem; font-size: 0.85rem; color: var(--text-secondary-1); line-height: 1.5;">
                                            <?php if ($log['action'] === 'UPDATE_STATUS'): ?>
                                                Status changed from <strong><?= $changes['old_status'] ?></strong> to <strong><?= $changes['new_status'] ?></strong>
                                            <?php elseif ($log['action'] === 'CLAIM_FINE'): ?>
                                                Fine payment recorded. OR #: <strong><?= htmlspecialchars($changes['or_number'] ?? 'N/A') ?></strong>
                                            <?php elseif ($log['action'] === 'ASSIGN_FINE'): ?>
                                                Assessed fine: <strong>₱<?= number_format($changes['fine_amount'] ?? 0, 2) ?></strong>. Due: <?= $changes['due_date'] ?? 'N/A' ?>
                                            <?php else: ?>
                                                <div style="font-family: monospace; font-size: 0.75rem; opacity: 0.7; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 300px;">
                                                    <?= htmlspecialchars($log['changes_json'] ?? '') ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="right-column">
        <!-- Penalty & Actions -->
        <div class="card shadow-md" style="border-radius: 12px; border: 1px solid #ef4444; background: var(--card-bg-1); margin-bottom: 1.5rem; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.1);">
            <div class="card-header" style="background: #ef4444; border-bottom: 1px solid #dc2626; padding: 1.25rem 1.5rem;">
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: white;">Penalty Details</h3>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                <?php if (isset($_GET['success'])): ?>
                    <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; border: 1px solid #bbf7d0; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-check-circle"></i>
                        <span style="font-size: 0.875rem; font-weight: 500; flex: 1;"><?= htmlspecialchars($_GET['success']) ?></span>
                    </div>
                <?php endif; ?>

                <div style="text-align: center; margin-bottom: 2rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">Total Assessed Fine</label>
                    <?php if ($violation['fine_amount'] > 0): ?>
                        <div style="font-size: 3.5rem; font-weight: 800; color: #ef4444; line-height: 1; margin-bottom: 1rem; letter-spacing: -1px;">
                            <?= number_format((float)$violation['fine_amount'], 2) ?>
                        </div>
                    <?php else: ?>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #94a3b8; line-height: 1; margin: 1rem 0; padding: 1.5rem; background: #f1f5f9; border-radius: 12px; border: 2px dashed #cbd5e1;">Awaiting Assesment</div>
                    <?php endif; ?>
                    
                    <?php
                    $statusColor = match($violation['status']) {
                        'Pending' => '#ef4444',
                        'In Progress' => '#f59e0b',
                        'Paid' => '#0ea5e9',
                        'Resolved' => '#10b981',
                        default => '#6b7280'
                    };
                    ?>
                    <div class="badge-status" style="background: <?= $statusColor ?>; color: white;">
                        STATUS: <?= $violation['status'] ?>
                    </div>
                    
                    <?php if ($violation['or_number']): ?>
                        <div style="margin-top: 1rem; padding: 1rem; background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 10px; text-align: left;">
                            <div style="font-size: 0.7rem; font-weight: 700; color: #10b981; text-transform: uppercase; margin-bottom: 0.25rem;">Payment Reference</div>
                            <div style="font-weight: 700; color: var(--text-color-1);">OR #<?= htmlspecialchars($violation['or_number']) ?></div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary-1); margin-top: 0.25rem;">Paid on <?= date('M d, Y', strtotime($violation['paid_at'])) ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Fine Assignment Form -->
                <?php if ($violation['fine_amount'] == 0): ?>
                    <div style="background: #fff8f8; border: 1px solid #fee2e2; padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
                        <h4 style="margin: 0 0 1.25rem; font-size: 0.9rem; font-weight: 800; color: #991b1b; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-gavel"></i> Assign Penalty
                        </h4>
                        <form action="/violations/assign-fine" method="POST">
                            <input type="hidden" name="id" value="<?= $violation['id'] ?>">
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary-1); margin-bottom: 0.5rem;">Fine Amount (PHP)</label>
                                <div style="position: relative;">
                                    <span style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); font-weight: 800; color: #64748b; font-size: 1.1rem;">₱</span>
                                    <input type="number" name="fine_amount" required step="0.01" value="5000.00" style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.5rem; border: 2px solid #e2e8f0; border-radius: 10px; font-weight: 800; font-size: 1.1rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#ef4444'">
                                </div>
                            </div>
                            <div style="margin-bottom: 1.5rem;">
                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary-1); margin-bottom: 0.5rem;">Payment Due Date</label>
                                <input type="date" name="due_date" required value="<?= date('Y-m-d', strtotime('+7 days')) ?>" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 10px; font-weight: 600; outline: none;" onfocus="this.style.borderColor='#ef4444'">
                            </div>
                            <button type="submit" class="btn btn-danger" style="width: 100%; padding: 1rem; border-radius: 10px; font-weight: 800; background: #ef4444; border: none; font-size: 1rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                                Submit Fine
                            </button>
                        </form>
                    </div>
                <?php endif; ?>

                <!-- Claim Fine Form (Mark as Paid) -->
                <?php if ($violation['fine_amount'] > 0 && $violation['status'] === 'Pending'): ?>
                    <div style="background: #f0f9ff; border: 1px solid #bae6fd; padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
                        <h4 style="margin: 0 0 1.25rem; font-size: 0.9rem; font-weight: 800; color: #0369a1; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-cash-register"></i> Claim Fine / Mark Paid
                        </h4>
                        <form action="/violations/claim-fine" method="POST">
                            <input type="hidden" name="id" value="<?= $violation['id'] ?>">
                            <div style="margin-bottom: 1.5rem;">
                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #0369a1; margin-bottom: 0.5rem;">Official Receipt (OR) Number</label>
                                <input type="text" name="or_number" required placeholder="Enter OR # from Treasury" style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #bae6fd; border-radius: 10px; font-weight: 800; font-size: 1rem; outline: none;" onfocus="this.style.borderColor='#0ea5e9'">
                            </div>
                            <button type="submit" class="btn btn-info" style="width: 100%; padding: 1rem; border-radius: 10px; font-weight: 800; background: #0ea5e9; border: none; color: white; font-size: 1rem; cursor: pointer; transition: background 0.2s;">
                                Confirm Payment
                            </button>
                        </form>
                    </div>
                <?php endif; ?>

                <div style="border-top: 1px solid var(--border-color-1); padding-top: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                    <?php if ($violation['status'] === 'Paid' || $violation['status'] === 'In Progress'): ?>
                        <form action="/violations/update-status" method="POST">
                            <input type="hidden" name="id" value="<?= $violation['id'] ?>">
                            <input type="hidden" name="status" value="Resolved">
                            <button type="submit" class="btn btn-success" style="width: 100%; height: 55px; font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 0.75rem; background: #10b981; border: none; border-radius: 12px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="fas fa-check-double"></i> Resolve Violation
                            </button>
                        </form>
                    <?php endif; ?>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 0.5rem;">
                        <a href="/violations/print?id=<?= $violation['id'] ?>" target="_blank" class="btn btn-outline-secondary" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; text-decoration: none; font-size: 0.9rem; font-weight: 700; border: 1.5px solid var(--border-color-1); color: var(--text-color-1); padding: 0.85rem; border-radius: 10px; background: white;">
                            <i class="fas fa-print"></i> Print
                        </a>
                        <a href="/inspections/show?id=<?= $violation['inspection_id'] ?>" class="btn btn-outline-secondary" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; text-decoration: none; font-size: 0.9rem; font-weight: 700; border: 1.5px solid var(--border-color-1); color: var(--text-color-1); padding: 0.85rem; border-radius: 10px; background: white;">
                            <i class="fas fa-search"></i> Inspect
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Info -->
        <div style="background: var(--card-bg-1); border: 1px solid var(--border-color-1); border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <h6 style="font-weight: 800; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.75rem; font-size: 0.9rem; color: var(--text-color-1);">
                <i class="fas fa-question-circle" style="color: var(--text-secondary-1);"></i> Help & Guidance
            </h6>
            <p style="font-size: 0.8rem; line-height: 1.7; color: var(--text-secondary-1); margin: 0;">
                Violations should be marked as <strong>Paid</strong> once the establishment provides a proof of payment from the Treasurer''s Office. 
                <br><br>
                Set to <strong>Resolved</strong> only after both the fine is paid and all listed deficiencies have been corrected through a re-inspection.
            </p>
        </div>
    </div>
</div>

<!-- Deficiencies (moved to bottom or keep in left col? user pic shows it might be below or not shown yet) -->
<!-- Restoring the Deficiencies table from original but styled better -->
<div style="margin-top: 1.5rem;">
    <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #fecaca; background: var(--card-bg-1); overflow: hidden;">
        <div class="card-header" style="background: #ef4444; border-bottom: 1px solid #dc2626; padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: white;">Identified Deficiencies</h5>
            <span style="background: white; color: #ef4444; font-size: 0.8rem; font-weight: 800; padding: 0.35rem 0.85rem; border-radius: 999px;"><?= count($failedItems) ?> Items Flagged</span>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-container" style="border: none; box-shadow: none;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: rgba(0,0,0,0.02);">
                            <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 800; color: var(--text-secondary-1); text-transform: uppercase;">Requirement</th>
                            <th style="padding: 1.25rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 800; color: var(--text-secondary-1); text-transform: uppercase; width: 120px;">Evidence</th>
                            <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 800; color: var(--text-secondary-1); text-transform: uppercase;">Status</th>
                            <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 800; color: var(--text-secondary-1); text-transform: uppercase;">Inspector Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($failedItems)): ?>
                            <tr>
                                <td colspan="4" style="padding: 4rem; text-align: center; color: var(--text-secondary-1); font-weight: 500;">No specific items flagged during inspection.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($failedItems as $item): ?>
                                <tr style="border-bottom: 1px solid var(--border-color-1);">
                                    <td style="padding: 1.5rem 1.5rem;">
                                        <div style="font-weight: 700; color: var(--text-color-1); margin-bottom: 0.35rem; font-size: 1rem;"><?= htmlspecialchars($item['requirement_text']) ?></div>
                                        <div style="font-size: 0.8rem; color: var(--text-secondary-1); font-weight: 500;">Item ID: <?= $item['checklist_item_id'] ?></div>
                                    </td>
                                    <td style="padding: 1.5rem 1.5rem; text-align: center;">
                                        <?php if (!empty($item['photo_path'])): ?>
                                            <a href="javascript:void(0)" onclick="openImageModal('<?= htmlspecialchars($item['photo_path']) ?>', '<?= htmlspecialchars($item['requirement_text']) ?>')">
                                                <img src="<?= htmlspecialchars($item['photo_path']) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px; border: 2px solid #e2e8f0; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                            </a>
                                        <?php else: ?>
                                            <div style="width: 50px; height: 50px; background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                                <i class="fas fa-camera-slash" style="font-size: 0.9rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1.5rem 1.5rem;">
                                        <span style="background: #fee2e2; color: #ef4444; padding: 0.4rem 0.85rem; border-radius: 999px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; border: 1px solid #fecaca;">Failed</span>
                                    </td>
                                    <td style="padding: 1.5rem 1.5rem;">
                                        <div style="font-style: italic; color: var(--text-secondary-1); font-size: 0.9rem; font-weight: 500; line-height: 1.5;">
                                            <?= htmlspecialchars($item['notes'] ?? 'No remarks provided') ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imgModal" class="image-modal" onclick="this.style.display='none'">
    <span class="modal-close" onclick="document.getElementById('imgModal').style.display='none'">&times;</span>
    <img id="modalImg" class="modal-content">
    <div id="modalCaption" class="modal-caption"></div>
</div>

<script>
function openImageModal(imgSrc, caption) {
    const modal = document.getElementById('imgModal');
    const modalImg = document.getElementById('modalImg');
    const captionText = document.getElementById('modalCaption');
    
    modal.style.display = "flex";
    modalImg.src = imgSrc;
    captionText.innerHTML = caption;
}

// Close on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
        document.getElementById('imgModal').style.display = "none";
    }
});
</script>