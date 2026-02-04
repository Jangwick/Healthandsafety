<div class="print-actions no-print" style="max-width: 900px; margin: 0 auto 20px auto; display: flex; justify-content: space-between; align-items: center;">
    <a href="/certificates" class="btn btn-outline-secondary" style="display: flex; align-items: center; gap: 0.5rem; text-decoration: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to Log
    </a>
    <div style="display: flex; gap: 1rem;">
        <?php if ($certificate['status'] !== 'Revoked'): ?>
            <button onclick="window.print()" class="btn btn-primary" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(76, 138, 137, 0.2);">
                <i class="fas fa-print"></i> Print Document
            </button>
        <?php endif; ?>
    </div>
</div>

<div class="certificate-document shadow-lg" style="background: white; border: 2px solid #ddd; padding: 0; max-width: 900px; margin: 0 auto; min-heigth: 1100px; position: relative; font-family: 'Georgia', serif; color: #1a1a1a;">
    <!-- Status Watermark -->
    <?php if ($certificate['status'] === 'Revoked'): ?>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 10rem; color: rgba(220, 38, 38, 0.15); font-weight: 900; pointer-events: none; z-index: 10; text-transform: uppercase; border: 20px solid rgba(220, 38, 38, 0.15); padding: 20px; border-radius: 20px; width: 100%; text-align: center;">
            REVOKED
        </div>
    <?php elseif (strtotime($certificate['expiry_date']) < time()): ?>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 10rem; color: rgba(107, 114, 128, 0.1); font-weight: 900; pointer-events: none; z-index: 10; text-transform: uppercase;">
            EXPIRED
        </div>
    <?php endif; ?>

    <!-- Certificate Border Decoration -->
    <div style="position: absolute; top: 20px; left: 20px; right: 20px; bottom: 20px; border: 4px double #1a237e; pointer-events: none;"></div>
    <div style="position: absolute; top: 30px; left: 30px; right: 30px; bottom: 30px; border: 1px solid #1a237e; pointer-events: none;"></div>

    <div style="padding: 60px 80px; position: relative; z-index: 5;">
        <!-- Official Header -->
        <div style="text-align: center; margin-bottom: 40px;">
            <div style="display: flex; align-items: center; justify-content: center; gap: 30px; margin-bottom: 20px;">
                <img src="/images/logo.svg" alt="Seal" style="width: 90px; height: 90px; object-fit: contain; filter: grayscale(0.2);">
                <div style="text-align: center;">
                    <p style="text-transform: uppercase; font-size: 0.9rem; letter-spacing: 2px; margin: 0; color: #444;">Republic of the Philippines</p>
                    <p style="text-transform: uppercase; font-size: 1rem; font-weight: 700; margin: 2px 0; color: #1a237e;">Department of Health</p>
                    <p style="text-transform: uppercase; font-size: 1.1rem; font-weight: 800; margin: 0; color: #1a237e;">City Health Office / Sanitary Division</p>
                </div>
                <div style="width: 90px;"></div> <!-- Spacer to balance layout -->
            </div>
            
            <div style="margin-top: 50px;">
                <h1 style="font-size: 3rem; text-transform: uppercase; color: #1a237e; font-weight: 900; margin: 0; letter-spacing: 4px;">SANITARY PERMIT</h1>
                <p style="font-size: 1.2rem; color: #555; margin-top: 10px; font-style: italic;">To Operate an Establishment</p>
            </div>
        </div>

        <!-- Main Content -->
        <div style="text-align: center; margin-top: 50px;">
            <p style="font-size: 1.25rem; font-family: 'Times New Roman', serif;">THIS PERMIT IS HEREBY GRANTED TO</p>
            
            <div style="margin: 30px 0;">
                <h2 style="font-size: 2.5rem; text-transform: uppercase; color: #1a237e; border-bottom: 3px solid #1a237e; display: inline-block; padding: 0 40px; margin-bottom: 10px; font-weight: 900;">
                    <?= htmlspecialchars($certificate['establishment_name']) ?>
                </h2>
                <div style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
                    <span style="font-size: 1.1rem; color: #444; font-weight: 600;"><?= htmlspecialchars($certificate['location']) ?></span>
                    <span style="font-size: 0.9rem; color: #666; text-transform: uppercase; letter-spacing: 1px;">(<?= htmlspecialchars($certificate['establishment_type']) ?>)</span>
                </div>
            </div>

            <div style="max-width: 600px; margin: 40px auto; line-height: 1.8; font-size: 1.15rem; color: #222;">
                This establishment has been found compliant with the rules and regulations of the <b>Sanitation Code of the Philippines (P.D. 856)</b> and is therefore authorized to conduct business operations for the period specified below.
            </div>
        </div>

        <!-- Meta Data Section -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 60px; padding: 30px 40px; background: rgba(26, 35, 126, 0.03); border-radius: 12px; border: 1px solid rgba(26, 35, 126, 0.1);">
            <div>
                <p style="margin: 0; font-size: 0.8rem; text-transform: uppercase; color: #666; font-weight: 700;">Permit Control No.</p>
                <p style="margin: 0; font-size: 1.3rem; font-weight: 900; color: #1a237e; letter-spacing: 1px;"><?= $certificate['certificate_number'] ?></p>
            </div>
            <div style="text-align: right;">
                <p style="margin: 0; font-size: 0.8rem; text-transform: uppercase; color: #666; font-weight: 700;">Inspection Reference</p>
                <p style="margin: 0; font-size: 1.3rem; font-weight: 900; color: #1a237e;">
                    <?= $certificate['inspection_id'] ? '#INS-' . str_pad((string)$certificate['inspection_id'], 6, '0', STR_PAD_LEFT) : 'MANUAL ISSUANCE' ?>
                </p>
            </div>
            
            <div>
                <p style="margin: 0; font-size: 0.8rem; text-transform: uppercase; color: #666; font-weight: 700;">Date of Issuance</p>
                <p style="margin: 0; font-size: 1.2rem; font-weight: 700;"><?= date('F d, Y', strtotime($certificate['issue_date'])) ?></p>
            </div>
            <div style="text-align: right;">
                <p style="margin: 0; font-size: 0.8rem; text-transform: uppercase; color: #666; font-weight: 700;">Valid Until</p>
                <p style="margin: 0; font-size: 1.2rem; font-weight: 700; color: <?= strtotime($certificate['expiry_date']) < time() ? '#dc2626' : '#1a237e' ?>;">
                    <?= date('F d, Y', strtotime($certificate['expiry_date'])) ?>
                </p>
            </div>
        </div>

        <!-- Signatures and Verification -->
        <div style="margin-top: 80px; display: grid; grid-template-columns: 2fr 1.5fr; align-items: flex-end;">
            <div>
                <img src="/images/logo.svg" style="width: 80px; opacity: 0.2; position: absolute; bottom: 85px; left: 180px;" alt="Signature Seal">
                <div style="text-align: center; width: 300px;">
                    <p style="margin-bottom: 5px; font-weight: 900; font-size: 1.1rem; border-bottom: 2px solid #000; display: inline-block; width: 100%;">DR. ARTURO S. SANTOS, MD</p>
                    <p style="margin: 0; font-size: 0.85rem; text-transform: uppercase; font-weight: 700; color: #444;">City Health Officer II</p>
                </div>
            </div>
            
            <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end;">
                <!-- QR Code Simulation -->
                <div style="width: 100px; height: 100px; border: 1px solid #ccc; padding: 5px; background: white; margin-bottom: 10px;">
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 0.6rem; color: #999; text-align: center; border: 1px solid #eee;">
                        SECURE<br>VALIDATION<br>QR CODE
                    </div>
                </div>
                <p style="font-size: 0.75rem; color: #777; width: 150px; text-align: right; line-height: 1.3;">Scan for electronic verification of permit status.</p>
            </div>
        </div>

        <!-- Footer Notice -->
        <div style="margin-top: 80px; text-align: center; border-top: 1px solid #eee; padding-top: 20px;">
            <p style="font-size: 0.75rem; color: #888; text-transform: uppercase; letter-spacing: 1px;">This is a system-generated document. Unauthorized alterations void this permit.</p>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .navbar, .breadcrumb, .no-print, .content-header {
        display: none !important;
    }
    .content-wrapper {
        margin: 0 !important;
        padding: 0 !important;
        background: white !important;
    }
    .certificate-document {
        box-shadow: none !important;
        border: none !important;
        margin: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    body {
        background: white !important;
    }
}

.certificate-document {
    transition: transform 0.3s ease;
}

@media screen and (min-width: 900px) {
    .certificate-document:hover {
        transform: translateY(-5px);
    }
}
</style>
