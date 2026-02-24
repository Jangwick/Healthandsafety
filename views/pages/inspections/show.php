<style>
    .report-card {
        border-radius: 16px;
        border: 1px solid var(--border-color-1);
        background: var(--card-bg-1);
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .report-header {
        background: linear-gradient(135deg, var(--primary-color-1), #5ca4a3);
        padding: 2.5rem;
        color: white;
        text-align: center;
    }
    .score-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        border: 2px solid rgba(255,255,255,0.3);
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-completed { background: #dcfce7; color: #15803d; }
    .status-scheduled { background: #dbeafe; color: #1d4ed8; }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        padding: 2rem;
        background: rgba(0,0,0,0.02);
        border-bottom: 1px solid var(--border-color-1);
    }
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    .info-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-secondary-1);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-color-1);
    }
    
    .checklist-table {
        width: 100%;
        border-collapse: collapse;
    }
    .checklist-table th {
        background: #f8fafc;
        padding: 1rem 1.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-secondary-1);
        text-transform: uppercase;
        border-bottom: 2px solid var(--border-color-1);
    }
    .checklist-table td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-color-1);
        vertical-align: middle;
    }
    .evidence-img {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        transition: transform 0.2s;
        cursor: pointer;
    }
    .evidence-img:hover {
        transform: scale(1.1);
    }
    .result-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.75rem;
    }
    .badge-pass { background: #ecfdf5; color: #059669; }
    .badge-fail { background: #fef2f2; color: #dc2626; }
</style>

<div class="row" style="max-width: 1100px; margin: 0 auto;">
    <div class="col-12">
        <div class="report-card">
            <!-- Premium Header -->
            <div class="report-header">
                <div class="score-circle">
                    <span style="font-size: 1.75rem; font-weight: 800; line-height: 1;"><?= number_format($inspection['score'], 1) ?>%</span>
                    <span style="font-size: 0.65rem; font-weight: 700; opacity: 0.9; margin-top: 2px;">AUDIT SCORE</span>
                </div>
                <h2 style="margin: 0; font-weight: 800; font-size: 2rem;"><?= $inspection['rating'] ?? 'Incomplete' ?></h2>
                <p style="opacity: 0.9; margin: 0.5rem 0 1.5rem; font-weight: 500;">
                    Overall compliance rating for <?= htmlspecialchars($inspection['business_name']) ?>
                </p>
                <div class="status-pill <?= $inspection['status'] === 'Completed' ? 'status-completed' : 'status-scheduled' ?>">
                    <i class="fas <?= $inspection['status'] === 'Completed' ? 'fa-check-circle' : 'fa-clock' ?>"></i>
                    <?= $inspection['status'] ?>
                </div>
            </div>

            <!-- Essential Meta Data -->
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Audit Date</span>
                    <span class="info-value">
                        <?php if ($inspection['completed_at']): ?>
                            <?= date('F d, Y', strtotime($inspection['completed_at'])) ?>
                        <?php else: ?>
                            <span style="color: #94a3b8; font-style: italic;">Not completed</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Lead Inspector</span>
                    <span class="info-value"><?= htmlspecialchars($inspection['inspector_name']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Inspection Type</span>
                    <span class="info-value"><?= htmlspecialchars($inspection['template_name']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Establishment ID</span>
                    <span class="info-value">#<?= $inspection['establishment_id'] ?></span>
                </div>
            </div>

            <!-- Checklist Section -->
            <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border-color-1); background: white;">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: var(--text-color-1);">Checklist Detailed Results</h3>
            </div>
            <div class="card-body p-0" style="background: white;">
                <table class="checklist-table">
                    <thead>
                        <tr>
                            <th style="padding-left: 2rem;">Requirement</th>
                            <th style="width: 100px; text-align: center;">Evidence</th>
                            <th style="width: 120px; text-align: center;">Result</th>
                            <th style="width: 150px; text-align: center;">Compliance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($results)): ?>
                            <tr>
                                <td colspan="4" style="padding: 4rem; text-align: center;">
                                    <div style="color: #94a3b8; font-weight: 500;">
                                        <i class="fas fa-clipboard-list" style="font-size: 3rem; opacity: 0.1; display: block; margin-bottom: 1rem;"></i>
                                        Detailed item results are not available for this record.
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($results as $item): ?>
                                <tr>
                                    <td style="padding-left: 2rem;">
                                        <div style="font-weight: 700; color: var(--text-color-1); font-size: 0.95rem;"><?= htmlspecialchars($item['requirement_text']) ?></div>
                                        <div style="font-size: 0.75rem; color: var(--text-secondary-1); margin-top: 2px;">Item ID: #<?= htmlspecialchars($item['checklist_item_id']) ?></div>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php if (!empty($item['photo_path'])): ?>
                                            <a href="<?= htmlspecialchars($item['photo_path']) ?>" target="_blank">
                                                <img src="<?= htmlspecialchars($item['photo_path']) ?>" class="evidence-img" title="Click to view full image">
                                            </a>
                                        <?php else: ?>
                                            <div style="width: 48px; height: 48px; background: #f8fafc; border-radius: 8px; margin: 0 auto; display: flex; align-items: center; justify-content: center; color: #cbd5e1; border: 1px dashed #e2e8f0;">
                                                <i class="fas fa-camera-slash" style="font-size: 0.8rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="result-badge badge-<?= strtolower($item['status']) ?>">
                                            <?= strtolower($item['status']) === 'pass' ? '<i class="fas fa-check"></i> ' : '<i class="fas fa-times"></i> ' ?>
                                            <?= $item['status'] ?>
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-weight: 700; font-size: 0.85rem; color: <?= $item['status'] === 'Pass' ? '#10b981' : '#ef4444' ?>;">
                                            <i class="fas <?= $item['status'] === 'Pass' ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                                            <?= $item['status'] === 'Pass' ? 'Compliant' : 'Non-Compliant' ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer Remarks -->
            <?php if (!empty($inspection['remarks'])): ?>
                <div style="padding: 2rem; background: #f8fafc; border-top: 1px solid var(--border-color-1);">
                    <h4 style="margin: 0 0 0.75rem; font-size: 0.9rem; font-weight: 800; color: var(--text-secondary-1); text-transform: uppercase;">Inspector General Remarks</h4>
                    <div style="background: white; padding: 1.25rem; border-radius: 12px; border: 1px solid var(--border-color-1); line-height: 1.6; color: var(--text-color-1); font-style: italic;">
                        "<?= nl2br(htmlspecialchars($inspection['remarks'])) ?>"
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
            <a href="/inspections" style="text-decoration: none; font-weight: 700; color: var(--text-secondary-1); font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-arrow-left"></i> Back to Register
            </a>
            <div style="display: flex; gap: 1rem;">
                <?php if ($inspection['score'] >= 75): ?>
                    <a href="/certificates" class="btn btn-success" style="padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 700; background: #10b981; border: none; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);">
                        <i class="fas fa-certificate"></i> View Certificate
                    </a>
                <?php else: ?>
                    <a href="/violations" class="btn btn-danger" style="padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 700; background: #ef4444; border: none; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2);">
                        <i class="fas fa-exclamation-triangle"></i> View Violation
                    </a>
                <?php endif; ?>
                <button onclick="window.print()" class="btn btn-outline-secondary" style="padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 700; border: 1px solid #cbd5e1; background: white; color: var(--text-color-1);">
                    <i class="fas fa-print"></i> Print Report
                </button>
            </div>
        </div>
    </div>
</div>

