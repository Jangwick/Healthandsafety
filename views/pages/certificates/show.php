<div class="certificate-container" style="background: white; border: 15px double #1a237e; padding: 50px; max-width: 800px; margin: 0 auto; position: relative;">
    <div class="text-center mb-5">
        <img src="/images/logo.svg" alt="LGU Logo" style="width: 100px; margin-bottom: 20px;">
        <h4 style="text-transform: uppercase; color: #1a237e; margin: 0;">Republic of the Philippines</h4>
        <h2 style="text-transform: uppercase; margin: 10px 0; color: #1a237e;">Sanitary Clearance</h2>
        <p class="text-muted">Office of the City Health Officer</p>
    </div>

    <div class="certificate-body text-center" style="margin-top: 40px;">
        <p style="font-size: 1.2rem;">This is to certify that</p>
        <h1 style="font-family: 'Times New Roman', serif; border-bottom: 2px solid #333; display: inline-block; margin: 20px 0; padding: 0 50px;">
            <?= htmlspecialchars($certificate['establishment_name']) ?>
        </h1>
        <p style="font-size: 1rem; color: #555;">located at</p>
        <p style="font-style: italic; font-weight: bold;"><?= htmlspecialchars($certificate['location']) ?></p>
        
        <p style="margin-top: 40px; font-size: 1.1rem;">
            has undergone inspection and is hereby granted this 
            <strong><?= htmlspecialchars($certificate['type']) ?></strong>
            for compliance with the high standards of Health and Safety regulations.
        </p>
    </div>

    <div class="row mt-5 pt-4">
        <div class="col-6 text-center">
            <div style="border-top: 1px solid #333; width: 200px; margin: 0 auto; padding-top: 5px;">
                <strong><?= date('M d, Y', strtotime($certificate['issue_date'])) ?></strong><br>
                <small class="text-muted">Date Issued</small>
            </div>
        </div>
        <div class="col-6 text-center">
            <div style="border-top: 1px solid #333; width: 200px; margin: 0 auto; padding-top: 5px;">
                <strong><?= date('M d, Y', strtotime($certificate['expiry_date'])) ?></strong><br>
                <small class="text-muted">Date of Expiration</small>
            </div>
        </div>
    </div>

    <div class="certificate-footer text-center mt-5">
        <p class="mb-0">Certificate Number:</p>
        <h4 style="color: #1a237e;"><?= $certificate['certificate_number'] ?></h4>
    </div>
</div>

<div class="text-center mt-4 no-print">
    <button onclick="window.print()" class="btn btn-lg btn-primary">
        <i class="fas fa-print"></i> Print Certificate
    </button>
</div>

<style>
@media print {
    .sidebar, .navbar, .breadcrumb, .no-print {
        display: none !important;
    }
    .content-wrapper {
        margin: 0 !important;
        padding: 0 !important;
    }
    body {
        background: white !important;
    }
}
</style>
