<?php
// Prepare chart data
$trendLabels = json_encode(array_column($trends, 'week'));
$trendCounts = json_encode(array_map('intval', array_column($trends, 'count')));
$trendScores = json_encode(array_map('floatval', array_column($trends, 'avg_score')));

$vLabels = json_encode(array_column($violationStats, 'status'));
$vCounts = json_encode(array_column($violationStats, 'count'));

$catLabels = json_encode(array_column($categoryCompliance, 'type'));
$catScores = json_encode(array_map('floatval', array_column($categoryCompliance, 'avg_score')));

$revLabels = json_encode(array_column($revenueTrends, 'month'));
$revCollected = json_encode(array_map('floatval', array_column($revenueTrends, 'total_collected')));
$revImposed = json_encode(array_map('floatval', array_column($revenueTrends, 'total_imposed')));
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Custom Responsive Grid */
    .reports-view {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }
    
    .chart-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }
    
    .secondary-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    
    .data-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .analytics-grid { grid-template-columns: repeat(2, 1fr); }
        .chart-grid { grid-template-columns: 1fr; }
    }
    
    @media (max-width: 768px) {
        .analytics-grid { grid-template-columns: 1fr; }
        .secondary-grid, .data-grid { grid-template-columns: 1fr; }
    }

    /* Premium Card Styling */
    .analytics-card {
        border-radius: 20px;
        background: var(--card-bg-1);
        border: 1px solid var(--border-color-1);
        padding: 1.5rem;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 120px;
    }
    
    .analytics-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    
    .stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        margin: 0.5rem 0;
        color: var(--text-color-1);
    }
    
    .stat-label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--text-secondary-1);
        letter-spacing: 0.8px;
    }
    
    .table-modern {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-modern th {
        background: rgba(var(--header-bg-1-rgb), 0.5);
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--text-secondary-1);
        padding: 1rem;
        border-bottom: 2px solid var(--border-color-1);
        text-align: left;
    }
    
    .table-modern td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color-1);
        font-size: 0.85rem;
    }

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .analytics-card { border: 1px solid #eee !important; box-shadow: none !important; }
        .analytics-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>

<div class="reports-view">
    <!-- Header Controls -->
    <div class="header-actions no-print">
        <div>
            <h2 style="font-weight: 800; font-size: 1.25rem; margin: 0; color: var(--text-color-1);">Governance Insight</h2>
            <p style="color: var(--text-secondary-1); font-size: 0.85rem; margin-top: 0.25rem;">Live compliance tracking and enforcement oversight.</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button onclick="window.print()" class="btn btn-secondary" style="border-radius: 12px; font-weight: 700; padding: 0.6rem 1rem; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
                <i class="fas fa-print me-2"></i> Print
            </button>
            <a href="/reports/export?type=csv" class="btn btn-primary" style="border-radius: 12px; font-weight: 700; padding: 0.6rem 1rem; background: var(--primary-color-1); border: none;">
                <i class="fas fa-file-csv me-2"></i> Export CSV
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="analytics-grid">
        <div class="analytics-card" style="border-left: 4px solid #10b981;">
            <div>
                <div class="stat-label">Safety Compliance</div>
                <div class="stat-value"><?= number_format($stats['avg_score'], 1) ?>%</div>
            </div>
            <div style="font-size: 0.75rem; color: #10b981; font-weight: 700;">
                <i class="fas fa-check-circle me-1"></i> Global Avg
            </div>
        </div>
        
        <div class="analytics-card" style="border-left: 4px solid #0ea5e9;">
            <div>
                <div class="stat-label">Total Imposed</div>
                <div class="stat-value">₱<?= number_format($stats['total_fines'] + $stats['pending_fines'], 0) ?></div>
            </div>
            <div style="font-size: 0.75rem; color: var(--text-secondary-1); font-weight: 700;">
                <i class="fas fa-file-invoice-dollar me-1"></i> Fines Generated
            </div>
        </div>
        
        <div class="analytics-card" style="border-left: 4px solid #f59e0b;">
            <div>
                <div class="stat-label">Actual Collections</div>
                <div class="stat-value">₱<?= number_format($stats['total_fines'], 0) ?></div>
            </div>
            <div style="font-size: 0.75rem; color: #f59e0b; font-weight: 700;">
                <i class="fas fa-cash-register me-1"></i> Realized Revenue
            </div>
        </div>
        
        <div class="analytics-card" style="border-left: 4px solid #ef4444;">
            <div>
                <div class="stat-label">Active Violations</div>
                <div class="stat-value"><?= number_format($stats['total_violations']) ?></div>
            </div>
            <div style="font-size: 0.75rem; color: #ef4444; font-weight: 700;">
                <i class="fas fa-triangle-exclamation me-1"></i> Open Citations
            </div>
        </div>
    </div>

    <!-- Main Charts -->
    <div class="chart-grid">
        <div class="analytics-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="font-size: 0.9rem; font-weight: 800; margin: 0;">Inspection & Performance History</h3>
                <div style="display: flex; gap: 1rem; font-size: 0.7rem; color: var(--text-secondary-1); font-weight: 700;">
                    <span style="display: flex; align-items: center; gap: 0.3rem;"><i class="fas fa-circle" style="color: #0d6efd;"></i> Audits</span>
                    <span style="display: flex; align-items: center; gap: 0.3rem;"><i class="fas fa-circle" style="color: #10b981;"></i> Score %</span>
                </div>
            </div>
            <div style="height: 350px;">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
        
        <div class="analytics-card">
            <h3 style="font-size: 0.9rem; font-weight: 800; margin-bottom: 2rem;">Violation Lifecycle</h3>
            <div style="height: 350px;">
                <canvas id="violationChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Secondary Charts -->
    <div class="secondary-grid">
        <div class="analytics-card">
            <h3 style="font-size: 0.9rem; font-weight: 800; margin-bottom: 2rem;">Revenue Flow (Last 6 Months)</h3>
            <div style="height: 300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="analytics-card">
            <h3 style="font-size: 0.9rem; font-weight: 800; margin-bottom: 2rem;">Category Distribution</h3>
            <div style="height: 300px;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Data Tables -->
    <div class="data-grid">
        <div class="analytics-card" style="padding: 0; overflow: hidden;">
            <div style="padding: 1.25rem; border-bottom: 1px solid var(--border-color-1);">
                <h3 style="font-size: 0.9rem; font-weight: 800; margin: 0;">Inspector Rankings</h3>
            </div>
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Officer</th>
                        <th style="text-align: center;">Total Audits</th>
                        <th style="text-align: right;">Avg Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inspectorStats as $inspector): ?>
                    <tr>
                        <td style="font-weight: 700;"><?= htmlspecialchars($inspector['inspector_name']) ?></td>
                        <td style="text-align: center;"><span style="background: rgba(var(--header-bg-1-rgb), 0.8); padding: 0.2rem 0.5rem; border-radius: 6px; font-weight: 800; font-size: 0.8rem;"><?= $inspector['total_conducted'] ?></span></td>
                        <td style="text-align: right; color: var(--primary-color-1); font-weight: 800;"><?= number_format($inspector['avg_rating_given'], 1) ?>%</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="analytics-card" style="padding: 0; overflow: hidden;">
            <div style="padding: 1.25rem; border-bottom: 1px solid var(--border-color-1);">
                <h3 style="font-size: 0.9rem; font-weight: 800; margin: 0; color: #ef4444;">Critical Risk Baseline</h3>
            </div>
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Business Entity</th>
                        <th style="text-align: center;">Health Score</th>
                        <th style="text-align: right;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($highRisk as $risk): ?>
                    <tr>
                        <td>
                            <div style="font-weight: 700;"><?= htmlspecialchars($risk['name']) ?></div>
                            <div style="font-size: 0.7rem; color: var(--text-secondary-1);"><?= htmlspecialchars($risk['category']) ?></div>
                        </td>
                        <td style="text-align: center;">
                            <span style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 0.2rem 0.5rem; border-radius: 6px; font-weight: 800; font-size: 0.8rem;">
                                <?= $risk['score'] ?>%
                            </span>
                        </td>
                        <td style="text-align: right; font-size: 0.75rem; color: var(--text-secondary-1);"><?= date('M d, Y', strtotime($risk['scheduled_date'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const textColor = isDark ? '#94a3b8' : '#64748b';
    const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';

    Chart.defaults.color = textColor;
    Chart.defaults.font.family = "'Inter', sans-serif";

    // 1. Trend Chart
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: <?= $trendLabels ?>,
            datasets: [
                {
                    label: 'Audits',
                    data: <?= $trendCounts ?>,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y'
                },
                {
                    label: 'Score %',
                    data: <?= $trendScores ?>,
                    borderColor: '#10b981',
                    borderDash: [5, 5],
                    tension: 0.4,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, grid: { color: gridColor }, title: { display: true, text: 'Volume' } },
                y1: { position: 'right', beginAtZero: true, max: 100, grid: { display: false }, title: { display: true, text: 'Index' } }
            }
        }
    });

    // 2. Violation Chart
    new Chart(document.getElementById('violationChart'), {
        type: 'doughnut',
        data: {
            labels: <?= $vLabels ?>,
            datasets: [{
                data: <?= $vCounts ?>,
                backgroundColor: ['#ef4444', '#10b981', '#f59e0b', '#0ea5e9'],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 25 } } }
        }
    });

    // 3. Revenue Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: <?= $revLabels ?>,
            datasets: [
                {
                    label: 'Collected',
                    data: <?= $revCollected ?>,
                    backgroundColor: '#10b981',
                    borderRadius: 6
                },
                {
                    label: 'Imposed',
                    data: <?= $revImposed ?>,
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top', labels: { usePointStyle: true } } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, grid: { color: gridColor } }
            }
        }
    });

    // 4. Category Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'radar',
        data: {
            labels: <?= $catLabels ?>,
            datasets: [{
                label: 'Avg Performance',
                data: <?= $catScores ?>,
                backgroundColor: 'rgba(76, 138, 137, 0.2)',
                borderColor: '#4c8a89',
                pointBackgroundColor: '#4c8a89',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    angleLines: { color: gridColor },
                    grid: { color: gridColor },
                    suggestedMin: 50,
                    suggestedMax: 100,
                    ticks: { backdropColor: 'transparent' }
                }
            },
            plugins: { legend: { display: false } }
        }
    });
});
</script>
