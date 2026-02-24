<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start;">
    <div class="left-column">
        <!-- Main Information -->
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1); margin-bottom: 1.5rem; overflow: hidden;">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: var(--text-color-1);">
                    <i class="fas fa-info-circle text-primary" style="margin-right: 0.5rem;"></i>Violation Information
                </h3>
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <a href="/violations/edit?id=<?= $violation['id'] ?>" class="btn btn-outline-warning" style="font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 6px; text-decoration: none; border: 1px solid #f59e0b; color: #f59e0b;">
                        <i class="fas fa-edit"></i> Edit Record
                    </a>
                    <span style="background: var(--bg-color-1); color: var(--text-secondary-1); font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 6px; border: 1px solid var(--border-color-1);">ID: #<?= $violation['id'] ?></span>
                </div>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Establishment</label>
                        <div style="font-size: 1.125rem; font-weight: 600; color: var(--text-color-1);">
                            <i class="fas fa-building" style="color: var(--text-secondary-1); margin-right: 0.5rem; font-size: 0.875rem;"></i>
                            <?= htmlspecialchars($violation['establishment_name']) ?>
                        </div>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Inspector</label>
                        <div style="font-size: 1.125rem; font-weight: 600; color: var(--text-color-1);">
                            <i class="fas fa-user-shield" style="color: var(--text-secondary-1); margin-right: 0.5rem; font-size: 0.875rem;"></i>
                            <?= htmlspecialchars($violation['inspector_name']) ?>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Location</label>
                    <div style="color: var(--text-color-1);">
                        <i class="fas fa-map-marker-alt" style="color: #ef4444; margin-right: 0.5rem; font-size: 0.875rem;"></i>
                        <?= htmlspecialchars($violation['location']) ?>
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Violation Description</label>
                    <div style="padding: 1rem; background: #fff5f5; border-radius: 8px; border-left: 4px solid #ef4444; color: #991b1b; font-weight: 500; line-height: 1.5;">
                        <?= nl2br(htmlspecialchars($violation['description'])) ?>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; align-items: center;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Inspection Score</label>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="flex: 1; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                                <div style="width: <?= $violation['score'] ?>%; height: 100%; background: <?= $violation['score'] < 75 ? '#ef4444' : '#f59e0b' ?>;"></div>
                            </div>
                            <span style="font-weight: 700; color: var(--text-color-1); font-size: 0.875rem;"><?= $violation['score'] ?>%</span>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <label style="display: block; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Recorded On</label>
                        <div style="color: var(--text-secondary-1); font-size: 0.875rem;"><?= date('F d, Y h:i A', strtotime($violation['created_at'])) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status History -->
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1); margin-bottom: 1.5rem; overflow: hidden;">
            <div class="card-header" style="background: rgba(0,0,0,0.02); border-bottom: 1px solid var(--border-color-1); padding: 1rem 1.5rem;">
                <h5 style="margin: 0; font-size: 1rem; font-weight: 600; color: var(--text-color-1);"><i class="fas fa-history" style="margin-right: 0.5rem;"></i>Status History</h5>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="table-container" style="border: none; box-shadow: none;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: rgba(0,0,0,0.01);">
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">Date & Time</th>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">Action</th>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">User</th>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logs ?? [])): ?>
                                <tr>
                                    <td colspan="4" style="padding: 2rem; text-align: center; color: var(--text-secondary-1); font-size: 0.875rem;">No history available.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($logs as $log): ?>
                                    <?php $changes = json_decode($log['changes_json'], true); ?>
                                    <tr style="border-bottom: 1px solid var(--border-color-1);">
                                        <td style="padding: 0.75rem 1.5rem; font-size: 0.8125rem; color: var(--text-secondary-1);"><?= date('M d, Y H:i', strtotime($log['timestamp'])) ?></td>
                                        <td style="padding: 0.75rem 1.5rem;">
                                            <span style="font-size: 0.7rem; font-weight: 700; background: #f3f4f6; padding: 0.2rem 0.5rem; border-radius: 4px; border: 1px solid #e5e7eb; color: #374151;"><?= $log['action'] ?></span>
                                        </td>
                                        <td style="padding: 0.75rem 1.5rem; font-size: 0.8125rem; color: var(--text-color-1);"><?= htmlspecialchars($log['user_name'] ?? 'System') ?></td>
                                        <td style="padding: 0.75rem 1.5rem; font-size: 0.8125rem; color: var(--text-secondary-1);">
                                            <?php if ($log['action'] === 'UPDATE_STATUS'): ?>
                                                Status changed from <strong><?= $changes['old_status'] ?></strong> to <strong><?= $changes['new_status'] ?></strong>
                                            <?php else: ?>
                                                <?= htmlspecialchars($log['changes_json'] ?? '') ?>
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

        <!-- Deficiencies -->
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #fecaca; background: var(--card-bg-1); overflow: hidden;">
            <div class="card-header" style="background: #ef4444; border-bottom: 1px solid #dc2626; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                <h5 style="margin: 0; font-size: 1rem; font-weight: 600; color: white;">Identified Deficiencies</h5>
                <span style="background: white; color: #ef4444; font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 999px;"><?= count($failedItems) ?> Items Found</span>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="table-container" style="border: none; box-shadow: none;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: rgba(0,0,0,0.02);">
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase;">Requirement</th>
                                <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; width: 100px;">Evidence</th>
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase;">Status</th>
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase;">Inspector Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($failedItems)): ?>
                                <tr>
                                    <td colspan="4" style="padding: 3rem; text-align: center; color: var(--text-secondary-1);">No specific items flagged.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($failedItems as $item): ?>
                                    <tr style="border-bottom: 1px solid var(--border-color-1);">
                                        <td style="padding: 1.25rem 1.5rem;">
                                            <div style="font-weight: 600; color: var(--text-color-1); margin-bottom: 0.25rem;"><?= htmlspecialchars($item['requirement_text']) ?></div>
                                            <div style="font-size: 0.75rem; color: var(--text-secondary-1);">Item ID: <?= $item['checklist_item_id'] ?></div>
                                        </td>
                                        <td style="padding: 1.25rem 1.5rem; text-align: center;">
                                            <?php if (!empty($item['photo_path'])): ?>
                                                <a href="<?= htmlspecialchars($item['photo_path']) ?>" target="_blank">
                                                    <img src="<?= htmlspecialchars($item['photo_path']) ?>" style="width: 45px; height: 45px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                                                </a>
                                            <?php else: ?>
                                                <div style="width: 45px; height: 45px; background: #f9fafb; border: 1px dashed #d1d5db; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                                    <i class="fas fa-camera-slash" style="font-size: 0.8rem;"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding: 1.25rem 1.5rem;">
                                            <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">Fail</span>
                                        </td>
                                        <td style="padding: 1.25rem 1.5rem;">
                                            <div style="font-style: italic; color: var(--text-secondary-1); font-size: 0.875rem;">
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
                        <div style="font-size: 3rem; font-weight: 800; color: #ef4444; line-height: 1; margin-bottom: 0.5rem;"><?= number_format((float)$violation['fine_amount'], 2) ?></div>
                    <?php else: ?>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #94a3b8; line-height: 1; margin: 1rem 0; padding: 1rem; background: #f1f5f9; border-radius: 8px; border: 1px dashed #cbd5e1;">Awaiting Fine</div>
                    <?php endif; ?>
                    
                    <?php
                    $statusStyle = match($violation['status']) {
                        'Pending' => 'background: #ef4444; color: white;',
                        'In Progress' => 'background: #f59e0b; color: white;',
                        'Paid' => 'background: #0ea5e9; color: white;',
                        'Resolved' => 'background: #10b981; color: white;',
                        default => 'background: #6b7280; color: white;'
                    };
                    ?>
                    <div style="<?= $statusStyle ?> font-size: 0.875rem; font-weight: 700; text-transform: uppercase; padding: 0.6rem 1rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); display: inline-block; width: 100%;">
                        Status: <?= $violation['status'] ?>
                    </div>
                </div>

                <!-- Fine Assignment Form -->
                <?php if ($violation['fine_amount'] == 0): ?>
                    <div style="background: #fff8f8; border: 1px solid #fee2e2; padding: 1.25rem; border-radius: 12px; margin-bottom: 1.5rem;">
                        <h4 style="margin: 0 0 1rem; font-size: 0.875rem; font-weight: 700; color: #991b1b; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-gavel"></i> Assign Penalty
                        </h4>
                        <form action="/violations/assign-fine" method="POST">
                            <input type="hidden" name="id" value="<?= $violation['id'] ?>">
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--text-secondary-1); margin-bottom: 0.4rem;">Fine Amount (PHP)</label>
                                <div style="position: relative;">
                                    <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); font-weight: 600; color: #64748b;">₱</span>
                                    <input type="number" name="fine_amount" required step="0.01" value="5000.00" style="width: 100%; padding: 0.6rem 1rem 0.6rem 2rem; border: 1px solid #cbd5e1; border-radius: 8px; font-weight: 700;">
                                </div>
                            </div>
                            <div style="margin-bottom: 1.25rem;">
                                <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--text-secondary-1); margin-bottom: 0.4rem;">Payment Due Date</label>
                                <input type="date" name="due_date" required value="<?= date('Y-m-d', strtotime('+7 days')) ?>" style="width: 100%; padding: 0.6rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px;">
                            </div>
                            <button type="submit" class="btn btn-danger" style="width: 100%; padding: 0.75rem; border-radius: 8px; font-weight: 700; background: #ef4444; border: none;">
                                Submit Fine
                            </button>
                        </form>
                    </div>
                <?php endif; ?>

                <div style="border-top: 1px solid var(--border-color-1); padding-top: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                    <?php if ($violation['status'] === 'Pending'): ?>
                        <form action="/violations/update-status" method="POST">
                            <input type="hidden" name="id" value="<?= $violation['id'] ?>">
                            <input type="hidden" name="status" value="Paid">
                            <button type="submit" class="btn btn-success" style="width: 100%; height: 50px; font-weight: 700; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                                <i class="fas fa-receipt"></i> Mark as Paid
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if ($violation['status'] === 'Paid' || $violation['status'] === 'In Progress'): ?>
                        <form action="/violations/update-status" method="POST">
                            <input type="hidden" name="id" value="<?= $violation['id'] ?>">
                            <input type="hidden" name="status" value="Resolved">
                            <button type="submit" class="btn btn-primary" style="width: 100%; height: 50px; font-weight: 700; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                                <i class="fas fa-check-double"></i> Resolve Violation
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if ($violation['status'] === 'Pending'): ?>
                        <form action="/violations/update-status" method="POST">
                            <input type="hidden" name="id" value="<?= $violation['id'] ?>">
                            <input type="hidden" name="status" value="In Progress">
                            <button type="submit" class="btn btn-outline-warning" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; border: 1px solid #f59e0b; color: #f59e0b; background: transparent; padding: 0.75rem; border-radius: 8px;">
                                <i class="fas fa-spinner"></i> Set to In Progress
                            </button>
                        </form>
                    <?php endif; ?>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-top: 0.5rem;">
                        <a href="/violations/print?id=<?= $violation['id'] ?>" target="_blank" class="btn btn-outline-secondary" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; text-decoration: none; font-size: 0.875rem; border: 1px solid var(--border-color-1); color: var(--text-color-1); padding: 0.75rem; border-radius: 8px;">
                            <i class="fas fa-print"></i> Print
                        </a>
                        <a href="/inspections/show?id=<?= $violation['inspection_id'] ?>" class="btn btn-outline-secondary" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; text-decoration: none; font-size: 0.875rem; border: 1px solid var(--border-color-1); color: var(--text-color-1); padding: 0.75rem; border-radius: 8px;">
                            <i class="fas fa-search"></i> Inspect
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Info -->
        <div style="background: rgba(0,0,0,0.02); border: 1px dashed var(--border-color-1); border-radius: 12px; padding: 1.25rem;">
            <h6 style="font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem;">
                <i class="fas fa-question-circle text-muted"></i> Help & Guidance
            </h6>
            <p style="font-size: 0.75rem; line-height: 1.6; color: var(--text-secondary-1); margin: 0;">
                Violations should be marked as <strong>Paid</strong> once the establishment provides a proof of payment from the Treasurer''s Office.
                Set to <strong>Resolved</strong> only after both the fine is paid and all listed deficiencies have been corrected through a re-inspection.
            </p>
        </div>
    </div>
</div>