<div class="row" style="max-width: 800px; margin: 0 auto;">
    <div class="col-12">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.5rem;">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-color-1);">Schedule New Audit</h3>
                <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: var(--text-secondary-1);">Set up a health and safety inspection for an establishment</p>
            </div>
            
            <div class="card-body" style="padding: 2rem;">
                <form action="/inspections/store" method="POST">
                    <div class="row">
                        <!-- Establishment Selection -->
                        <div class="col-12" style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Target Establishment</label>
                            <div style="position: relative;">
                                <i class="fas fa-building" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1);"></i>
                                <select name="establishment_id" required style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1); appearance: none;">
                                    <option value="">Select Establishment...</option>
                                    <?php foreach ($establishments as $est): ?>
                                        <option value="<?= $est['id'] ?>" <?= (isset($_GET['establishment_id']) && $_GET['establishment_id'] == $est['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($est['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Template Selection -->
                        <div class="col-md-6" style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Inspection Type / Checklist</label>
                            <div style="position: relative;">
                                <i class="fas fa-clipboard-check" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1);"></i>
                                <select name="template_id" required style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1); appearance: none;">
                                    <option value="">Select Checklist...</option>
                                    <?php foreach ($templates as $temp): ?>
                                        <option value="<?= $temp['id'] ?>"><?= htmlspecialchars($temp['category']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Priority -->
                        <div class="col-md-6" style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Priority Level</label>
                            <div style="position: relative;">
                                <i class="fas fa-flag" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1);"></i>
                                <select name="priority" style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1); appearance: none;">
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                    <option value="Urgent">Urgent</option>
                                </select>
                            </div>
                        </div>

                        <!-- Scheduled Date -->
                        <div class="col-md-6" style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Scheduled Date & Time</label>
                            <div style="position: relative;">
                                <i class="fas fa-calendar" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1);"></i>
                                <input type="datetime-local" name="scheduled_date" required style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1);">
                            </div>
                        </div>

                        <!-- Assigned Inspector -->
                        <div class="col-md-6" style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Assigned Inspector</label>
                            <div style="position: relative;">
                                <i class="fas fa-user-shield" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1);"></i>
                                <select name="inspector_id" required style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1); appearance: none;">
                                    <option value="">Choose Inspector...</option>
                                    <?php foreach ($inspectors as $insp): ?>
                                        <option value="<?= $insp['id'] ?>" <?= (isset($_GET['inspector_id']) && $_GET['inspector_id'] == $insp['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($insp['full_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 1rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color-1); display: flex; justify-content: flex-end; gap: 1rem;">
                        <a href="/inspections" class="btn btn-outline-secondary" style="background: transparent; border: 1px solid var(--border-color-1); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; text-decoration: none; color: var(--text-color-1);">Cancel</a>
                        <button type="submit" class="btn btn-primary" style="background: var(--primary-color-1); border: none; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; color: white; cursor: pointer;">
                            <i class="fas fa-calendar-check" style="margin-right: 0.5rem;"></i> Confirm Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
