<div style="max-width: 800px; margin: 0 auto;">
    <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1); overflow: hidden;">
        <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.5rem;">
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-color-1);">Manual Certificate Issuance</h3>
            <p style="margin: 0.5rem 0 0 0; color: var(--text-secondary-1); font-size: 0.875rem;">Create a new certificate record manually for an existing establishment.</p>
        </div>
        
        <div class="card-body" style="padding: 2rem;">
            <?php if (isset($_GET['error'])): ?>
                <div style="margin-bottom: 1.5rem; padding: 1rem; background: #fee2e2; color: #991b1b; border-radius: 8px; border: 1px solid #fecaca; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <form action="/certificates/store" method="POST">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Establishment Selection -->
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">For Establishment *</label>
                        <select name="establishment_id" class="form-control" required style="width: 100%; height: 48px; border-radius: 8px; border: 1px solid var(--border-color-1); padding: 0 1rem;">
                            <option value="">Select an establishment...</option>
                            <?php foreach ($establishments as $est): ?>
                                <option value="<?= $est['id'] ?>"><?= htmlspecialchars($est['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Certificate Type -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Permit/Certificate Type *</label>
                        <select name="type" class="form-control" required style="width: 100%; height: 48px; border-radius: 8px; border: 1px solid var(--border-color-1); padding: 0 1rem;">
                            <option value="Sanitary Clearance">Sanitary Clearance</option>
                            <option value="Health Certificate">Health Certificate</option>
                            <option value="Operational Permit">Operational Permit</option>
                        </select>
                    </div>

                    <!-- Certificate Number -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Certificate Number *</label>
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="text" id="cert_number_input" name="certificate_number" class="form-control" required placeholder="CERT-2024-001" style="flex: 1; height: 48px; border-radius: 8px; border: 1px solid var(--border-color-1); padding: 0 1rem;" 
                                   value="CERT-<?= date('Y') ?>-<?= str_pad((string)rand(1000, 9999), 4, '0', STR_PAD_LEFT) ?>">
                            <button type="button" onclick="generateNewNumber()" class="btn btn-outline-secondary" style="height: 48px; border-radius: 8px; border: 1px solid var(--border-color-1); padding: 0 0.75rem; background: var(--card-bg-1);" title="Generate Random Number">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>

                    <script>
                    function generateNewNumber() {
                        const year = new Date().getFullYear();
                        const rand = Math.floor(1000 + Math.random() * 9000);
                        document.getElementById('cert_number_input').value = `CERT-${year}-${rand}`;
                    }
                    </script>

                    <!-- Dates -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Issue Date *</label>
                        <input type="date" name="issue_date" class="form-control" required value="<?= date('Y-m-d') ?>" style="width: 100%; height: 48px; border-radius: 8px; border: 1px solid var(--border-color-1); padding: 0 1rem;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Expiry Date *</label>
                        <input type="date" name="expiry_date" class="form-control" required value="<?= date('Y-m-d', strtotime('+1 year')) ?>" style="width: 100%; height: 48px; border-radius: 8px; border: 1px solid var(--border-color-1); padding: 0 1rem;">
                    </div>
                </div>

                <div style="margin-top: 2.5rem; display: flex; gap: 1rem; border-top: 1px solid var(--border-color-1); padding-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; font-size: 1rem; flex: 1;">
                        <i class="fas fa-check-circle"></i> Issue Certificate
                    </button>
                    <a href="/certificates" class="btn btn-outline-secondary" style="padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; text-decoration: none; border: 1px solid var(--border-color-1); color: var(--text-color-1); display: flex; align-items: center; justify-content: center;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>