<?php
// Prepare chart data
$trendLabels = json_encode(array_column($trends, 'week'));
$trendCounts = json_encode(array_map('intval', array_column($trends, 'count')));
$trendScores = json_encode(array_map('floatval', array_column($trends, 'avg_score')));

$vLabels = json_encode(array_column($violationStats, 'status'));
$vCounts = json_encode(array_column($violationStats, 'count'));

$btLabels = json_encode(array_column($businessTypes, 'type'));
$btCounts = json_encode(array_column($businessTypes, 'violation_count'));
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    @media print {
        .sidebar, .navbar, .breadcrumb, .export-btns, .print-hide { display: none !important; }
        .main-content { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; page-break-inside: avoid; }
        body { background: white !important; }
    }
</style>

<div class="reports-container">
    <!-- Header with Actions -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;" class="export-btns">
        <div>
            <h2 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: var(--text-color-1);">Intelligence Dashboard</h2>
            <p style="margin: 0; font-size: 0.85rem; color: var(--text-secondary-1);">Dynamic overview of system performance and compliance.</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button onclick="window.print()" class="btn btn-outline-secondary" style="border-radius: 10px; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; background: var(--card-bg-1); border: 1.5px solid var(--border-color-1);">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
            <a href="/reports/export?type=csv" class="btn btn-primary" style="border-radius: 10px; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; background: var(--primary-color-1); border: none; box-shadow: 0 4px 12px rgba(76, 138, 137, 0.2);">
                <i class="fas fa-file-excel"></i> Export CSV/Excel
            </a>
        </div>
    </div>

    <!-- Top Stats Row -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Total Revenue (Fines) -->
        <div class="card shadow-sm" style="padding: 1.5rem; border-radius: 16px; background: linear-gradient(135deg, #0d6efd, #0a58ca); color: white; border: none;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3 style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.8; margin-bottom: 0.5rem;">Fines Collected</h3>
                    <p style="font-size: 1.75rem; font-weight: 800; margin: 0;">₱<?= number_format($stats['total_fines'], 2) ?></p>
                </div>
                <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.8rem; opacity: 0.9;">
                <span style="font-weight: 700;">₱<?= number_format($stats['pending_fines'], 2) ?></span> outstanding
            </div>
        </div>

        <!-- Compliance Rate -->
        <div class="card shadow-sm" style="padding: 1.5rem; border-radius: 16px; background: var(--card-bg-1); border: 1px solid var(--border-color-1);">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3 style="font-size: 0.75rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Avg. Inspection Score</h3>
                    <p style="font-size: 1.75rem; font-weight: 800; margin: 0; color: var(--text-color-1);"><?= number_format($stats['avg_score'], 1) ?>%</p>
                </div>
                <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div style="margin-top: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <div style="flex: 1; height: 6px; background: #e5e7eb; border-radius: 3px; overflow: hidden;">
                    <div style="width: <?= $stats['avg_score'] ?>%; height: 100%; background: #10b981;"></div>
                </div>
            </div>
        </div>

        <!-- Violations Count -->
        <div class="card shadow-sm" style="padding: 1.5rem; border-radius: 16px; background: var(--card-bg-1); border: 1px solid var(--border-color-1);">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3 style="font-size: 0.75rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">System Violations</h3>
                    <p style="font-size: 1.75rem; font-weight: 800; margin: 0; color: #ef4444;"><?= number_format($stats['total_violations']) ?></p>
                </div>
                <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(239, 68, 68, 0.1); color: #ef4444; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.8rem; color: var(--text-secondary-1);">
                From <span style="font-weight: 700;"><?= $stats['total_inspections'] ?></span> total audits
            </div>
        </div>

        <!-- Establishments -->
        <div class="card shadow-sm" style="padding: 1.5rem; border-radius: 16px; background: var(--card-bg-1); border: 1px solid var(--border-color-1);">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3 style="font-size: 0.75rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Establishments</h3>
                    <p style="font-size: 1.75rem; font-weight: 800; margin: 0; color: var(--text-color-1);"><?= number_format($stats['total_establishments']) ?></p>
                </div>
                <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(79, 70, 229, 0.1); color: #4f46e5; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-building"></i>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.8rem; color: var(--text-secondary-1);">
                Active in registry
            </div>
        </div>
    </div>

    <!-- Main Charts Row -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem; align-items: stretch;">
        <!-- Inspection Trend Chart -->
        <div class="card shadow-sm" style="padding: 1.5rem; border-radius: 16px; background: var(--card-bg-1); border: 1px solid var(--border-color-1);">
             <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; font-size: 1rem; font-weight: 800; color: var(--text-color-1);">Inspection Tracking & Compliance Trends</h3>
                <div style="display: flex; gap: 0.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.7rem; color: var(--text-secondary-1);">
                        <span style="width: 10px; height: 10px; border-radius: 2px; background: #0d6efd;"></span> Counts
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.7rem; color: var(--text-secondary-1);">
                        <span style="width: 10px; height: 10px; border-radius: 2px; background: #10b981;"></span> Avg Score
                    </div>
                </div>
            </div>
            <div style="height: 300px;">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Violation Status Chart -->
        <div class="card shadow-sm" style="padding: 1.5rem; border-radius: 16px; background: var(--card-bg-1); border: 1px solid var(--border-color-1);">
            <h3 style="margin: 0 0 1.5rem; font-size: 1rem; font-weight: 800; color: var(--text-color-1);">Violation Lifecycle</h3>
            <div style="height: 300px; display: flex; align-items: center; justify-content: center;">
                <canvas id="violationChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <!-- Distribution by Business Type -->
        <div class="card shadow-sm" style="padding: 1.5rem; border-radius: 16px; background: var(--card-bg-1); border: 1px solid var(--border-color-1);">
            <h3 style="margin: 0 0 1.5rem; font-size: 1rem; font-weight: 800; color: var(--text-color-1);">Top 5 Violation Hotspots (by Type)</h3>
            <div style="height: 250px;">
                <canvas id="businessTypeChart"></canvas>
            </div>
        </div>

        <!-- Recent Critical Failures -->
        <div class="card shadow-sm" style="padding: 1.5rem; border-radius: 16px; background: var(--card-bg-1); border: 1px solid var(--border-color-1);">
            <h3 style="margin: 0 0 1.5rem; font-size: 1rem; font-weight: 800; color: var(--text-color-1);">Recent High-Risk Failures</h3>
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-color-1);">
                            <th style="padding: 0.75rem 0.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase;">Establishment</th>
                            <th style="padding: 0.75rem 0.5rem; text-align: center; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase;">Score</th>
                            <th style="padding: 0.75rem 0.5rem; text-align: right; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($highRisk as $row): ?>
                            <tr style="border-bottom: 1px solid var(--border-color-1);">
                                <td style="padding: 1rem 0.5rem; font-weight: 600; color: var(--text-color-1);"><?= htmlspecialchars($row['name']) ?></td>
                                <td style="padding: 1rem 0.5rem; text-align: center;">
                                    <span style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 0.2rem 0.5rem; border-radius: 6px; font-weight: 800; font-size: 0.75rem;">
                                        <?= $row['score'] ?>%
                                    </span>
                                </td>
                                <td style="padding: 1rem 0.5rem; text-align: right; font-size: 0.8rem; color: var(--text-secondary-1);"><?= date('M d, Y', strtotime($row['scheduled_date'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($highRisk)): ?>
                            <tr>
                                <td colspan="3" style="padding: 3rem; text-align: center; color: var(--text-secondary-1);">No critical failures recorded recently.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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
                    label: 'Inspections',
                    data: <?= $trendCounts ?>,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y'
                },
                {
                    label: 'Avg Score',
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
                y: { 
                    beginAtZero: true, 
                    grid: { color: gridColor },
                    title: { display: true, text: 'Audit Count' }
                },
                y1: {
                    position: 'right',
                    beginAtZero: true,
                    max: 100,
                    grid: { display: false },
                    title: { display: true, text: 'Score %' }
                }
            }
        }
    });

    // 2. Violation Pie Chart
    new Chart(document.getElementById('violationChart'), {
        type: 'doughnut',
        data: {
            labels: <?= $vLabels ?>,
            datasets: [{
                data: <?= $vCounts ?>,
                backgroundColor: ['#ef4444', '#10b981', '#f59e0b', '#0ea5e9'],
                borderWidth: 0,
                cutout: '70%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            }
        }
    });

    // 3. Business Type Bar Chart
    new Chart(document.getElementById('businessTypeChart'), {
        type: 'bar',
        data: {
            labels: <?= $btLabels ?>,
            datasets: [{
                label: 'Violations',
                data: <?= $btCounts ?>,
                backgroundColor: '#6366f1',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, grid: { color: gridColor } }
            }
        }
    });
});
</script>
