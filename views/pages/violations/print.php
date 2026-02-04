<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violation Citation #<?= $violation['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: white; color: black; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .citation-container { max-width: 800px; margin: 40px auto; border: 2px solid #000; padding: 40px; }
        .header-logo { width: 80px; height: 80px; margin-bottom: 10px; }
        .status-stamp { 
            position: absolute; top: 100px; right: 60px; 
            border: 4px solid #dc3545; color: #dc3545; 
            padding: 10px 20px; font-weight: bold; font-size: 24px; 
            transform: rotate(15deg); text-transform: uppercase;
        }
        .status-stamp.paid { border-color: #198754; color: #198754; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; }
            .citation-container { margin: 0; border: none; width: 100%; max-width: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print p-3 bg-light border-bottom text-center">
        <button onclick="window.print()" class="btn btn-primary">Print Now</button>
        <button onclick="window.close()" class="btn btn-secondary">Close Window</button>
    </div>

    <div class="position-relative">
        <div class="citation-container">
            <?php if ($violation['status'] === 'Paid'): ?>
                <div class="status-stamp paid">Paid</div>
            <?php elseif ($violation['status'] === 'Pending'): ?>
                <div class="status-stamp">Pending</div>
            <?php endif; ?>

            <div class="text-center mb-5">
                <h4>REPUBLIC OF THE PHILIPPINES</h4>
                <h5>OFFICE OF THE LOCAL GOVERNMENT UNIT</h5>
                <h6 class="text-secondary">Health and Safety Inspection Division</h6>
                <hr class="my-4" style="border-top: 2px solid #000;">
                <h2 class="fw-bold mt-4">NOTICE OF VIOLATION</h2>
                <p class="text-secondary">Official Citation Record #<?= str_pad((string)$violation['id'], 6, '0', STR_PAD_LEFT) ?></p>
            </div>

            <div class="row mb-5">
                <div class="col-6">
                    <p class="mb-1 fw-bold">ESTABLISHMENT NAME:</p>
                    <p class="ps-3 border-bottom mb-4"><?= htmlspecialchars($violation['establishment_name']) ?></p>

                    <p class="mb-1 fw-bold">BUSINESS ADDRESS:</p>
                    <p class="ps-3 border-bottom mb-4"><?= htmlspecialchars($violation['location']) ?></p>
                </div>
                <div class="col-6">
                    <p class="mb-1 fw-bold">DATE ISSUED:</p>
                    <p class="ps-3 border-bottom mb-4"><?= date('F d, Y', strtotime($violation['created_at'])) ?></p>

                    <p class="mb-1 fw-bold">INSPECTION DATE:</p>
                    <p class="ps-3 border-bottom mb-4"><?= date('F d, Y', strtotime($violation['scheduled_date'])) ?></p>
                </div>
            </div>

            <div class="mb-5">
                <p class="fw-bold">VIOLATION DETAILS / DESCRIPTION:</p>
                <div class="p-3 bg-light border mb-4">
                    <?= nl2br(htmlspecialchars($violation['description'])) ?>
                </div>

                <?php if (!empty($failedItems)): ?>
                    <p class="fw-bold small">SPECIFIC DEFICIENCIES:</p>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr class="table-light">
                                <th style="width: 70%">Requirement / Regulation</th>
                                <th style="width: 30%">Inspector Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($failedItems as $item): ?>
                                <tr>
                                    <td class="small"><?= htmlspecialchars($item['requirement_text']) ?></td>
                                    <td class="small fst-italic"><?= htmlspecialchars($item['notes'] ?? 'None') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="row align-items-center mb-5">
                <div class="col-6">
                    <div class="p-4 border text-center">
                        <p class="mb-0 text-secondary">ASSESSED FINE AMOUNT</p>
                        <h1 class="fw-bold mb-0">₱<?= number_format((float)$violation['fine_amount'], 2) ?></h1>
                    </div>
                </div>
                <div class="col-6">
                    <p class="text-center small text-secondary">
                        Please present this citation at the City Treasurer's Office 
                        within 5 working days from the date of issuance to avoid 
                        further legal action or closure of the establishment.
                    </p>
                </div>
            </div>

            <div class="row mt-5 pt-5">
                <div class="col-6 text-center">
                    <div class="border-top mx-auto w-75 pt-2">
                        <small>Signature over Printed Name</small>
                        <p class="mb-0 fw-bold">Owner / Representative</p>
                    </div>
                </div>
                <div class="col-6 text-center">
                    <div class="border-top mx-auto w-75 pt-2">
                        <p class="mb-0 fw-bold underline"><?= htmlspecialchars($violation['inspector_name']) ?></p>
                        <small>Assigned Safety Inspector</small>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>