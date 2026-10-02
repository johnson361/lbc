<?php
// Logic to capture submitted service IDs and retain selection after form submit.
$selected_service_ids = $this->input->post('service_id');
$selected_service_ids = is_array($selected_service_ids) ? $selected_service_ids : [];

// Capture Start and End Dates from POST
$start_date = $this->input->post('start_date') ?? '';
$end_date = $this->input->post('end_date') ?? '';
?>

<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.dataTables.min.css'); ?>">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<div class="container-fluid mt-3" style=" width: 95%; ">
    <h2>Week Wise Report</h2>

    <form action="<?= base_url('reports/offerings') ?>" method="post" class="mb-2">
        <div class="row align-items-end">

            <div class="col-md-3">
                <label for="start_date" class="form-label mb-1">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control form-control-sm"
                    value="<?= htmlspecialchars($start_date) ?>">
            </div>

            <div class="col-md-3">
                <label for="end_date" class="form-label mb-1">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control form-control-sm"
                    value="<?= htmlspecialchars($end_date) ?>">
            </div>

            <div class="col-md-6">
                <label for="service_id" class="form-label mb-1">Filter by Service(s)</label>
                <select name="service_id[]" id="service_id" class="form-select form-select-sm" multiple>
                    <?php
                    foreach ($services as $service):
                        $service_details = [];
                        if (!empty($service['language_name'])) $service_details[] = $service['language_name'];
                        if (!empty($service['offering_name'])) $service_details[] = $service['offering_name'];
                        if (!empty($service['service_slot'])) $service_details[] = $service['service_slot'];

                        $service_string = implode(' - ', $service_details);

                        $selected = in_array($service['id'], $selected_service_ids) ? 'selected' : '';
                    ?>
                        <option value="<?= $service['id'] ?>" <?= $selected ?>>
                            <?= $service_string ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-12 d-flex flex-column flex-md-row justify-content-start align-items-center mt-2">
                <button type="submit" class="btn btn-primary btn-sm mt-2 mt-md-0">Apply Filter</button>
                <a href="<?= base_url('reports/offerings') ?>" class="btn btn-secondary btn-sm mt-2 mt-md-0 ms-md-2">Clear Filter</a>

                <button type="button" id="select_all_services" class="btn btn-info btn-sm mt-2 mt-md-0 ms-md-2">Select All</button>
                <button type="button" id="deselect_all_services" class="btn btn-warning btn-sm mt-2 mt-md-0 ms-md-2">Deselect All</button>
            </div>
        </div>
    </form>
    <hr class="my-3">

    <table class="table table-bordered table-striped table-hover" id="datatable">
        <thead class="table-dark">
            <tr>
                <th>Service Date</th>
                <th>Total Amount (Cash)</th>
                <th>Total Cheque Amount</th>
                <th>Rejected Cheques<br>(Count / Amount)</th>
                <th>Valid Cheques<br>(Count / Amount)</th>
                <th>Grand Total</th>
                <th>Deposit Date</th>
                <th>Amount Deposited</th>
                <th>Diff Amount</th>
                <th>Bank</th>
                <th>Notes</th>
                <th>Action</th>
            </tr>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($report)) : ?>
                <?php
                // initialize totals
                $total_deposit_amount = 0;
                $total_amount = 0;
                $check_amount = 0;
                $rejected_cheque_count = 0;
                $rejected_cheque_amount = 0;
                $valid_cheque_count = 0;
                $valid_cheque_amount = 0;
                $grand_total = 0;
                $total_diff_amount = 0;
                // echo "<pre>";
                // print_r($report);
                // echo "</pre>";
                ?>

                <?php foreach ($report as $row) : ?>
                    <?php
                    // accumulate totals
                    $total_amount += $row['total_amount'];
                    $total_deposit_amount += $row['deposit_amount'];
                    $check_amount += $row['check_amount'];
                    $rejected_cheque_count += $row['rejected_cheque_count'];
                    $rejected_cheque_amount += $row['rejected_cheque_amount'];
                    $valid_cheque_count += $row['valid_cheque_count'];
                    $valid_cheque_amount += $row['valid_cheque_amount'];
                    $grand_total += $row['grand_total'];
                    $total_diff_amount += $diff_amount = ($row['grand_total'] - $row['deposit_amount'] - $row['valid_cheque_amount']);

                    $bgClass = ($diff_amount > 0) ? 'bg-danger-subtle' : '';
                    ?>
                    <tr data-service_date="<?= $row['service_date'] ?>" data-deposit_id="<?= $row['deposit_id'] ?>">
                        <td> <a href="<?= base_url('Offg/summary/' . $row['service_date']); ?>">
                                <?= $row['service_date'] ?>
                            </a>
                        </td>

                        <td class="text-end"><?= number_format_india($row['total_amount'], 0, '.', ',') ?></td>
                        <td class="text-end"><?= number_format_india($row['check_amount'], 0, '.', ',') ?></td>


                        <td class="text-end">
                            <div class="report-tip-container">
                                <?= $row['rejected_cheque_count'] ?> /
                                <?= number_format_india($row['rejected_cheque_amount'], 0, '.', ',') ?>

                                <div class="report-tip-box">
                                    <?= nl2br(htmlspecialchars($row['rejected_cheque_list'])) ?>
                                </div>
                            </div>
                        </td>

                        <td class="text-end">
                            <div class="report-tip-container">
                                <?= $row['valid_cheque_count'] ?> /
                                <?= number_format_india($row['valid_cheque_amount'], 0, '.', ',') ?>

                                <div class="report-tip-box">
                                    <?= nl2br(htmlspecialchars($row['valid_cheque_list'])) ?>
                                </div>
                            </div>
                        </td>

                        <td class="text-end fw-bold"><?= number_format_india($row['grand_total'], 0, '.', ',') ?></td>

                        <!-- <td class="text-end"><?= htmlspecialchars($row['deposit_date']) ?></td>
                        <td class="text-end"><?= number_format_india($row['deposit_amount'], 0, '.', ',') ?></td>
                        <td class="text-end <?= $bgClass ?>">
                            <?= number_format_india($diff_amount, 0, '.', ',') ?>
                        </td>
                        <td class="text-end"><?= htmlspecialchars($row['bank']) ?></td> -->

                        <td class="text-end td-deposit-date">
                            <span><?= htmlspecialchars($row['deposit_date']) ?></span>
                        </td>

                        <td class="text-end td-deposit-amount">
                            <span><?= $row['deposit_amount'] ?></span>
                        </td>

                        <td class="text-end <?= $bgClass ?>">
                            <?= number_format_india($diff_amount, 0, '.', ',') ?>
                        </td>

                        <td class="text-end td-bank">
                            <span><?= htmlspecialchars($row['bank']) ?></span>
                        </td>

                        <td class="text-end td-notes">
                            <span><?= htmlspecialchars($row['notes']) ?></span>

                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit">Edit</button>
                            <button type="button" class="btn btn-sm btn-success btn-save d-none">Save</button>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <tr class="fw-bold table-secondary">
                    <td class="text-end">Total</td>
                    <td class="text-end"><?= number_format_india($total_amount, 0, '.', ',') ?></td>
                    <td class="text-end"><?= number_format_india($check_amount, 0, '.', ',') ?></td>

                    <td class="text-end">
                        <?= $rejected_cheque_count ?> /
                        <?= number_format_india($rejected_cheque_amount, 0, '.', ',') ?>
                    </td>
                    <td class="text-end">
                        <?= $valid_cheque_count ?> /
                        <?= number_format_india($valid_cheque_amount, 0, '.', ',') ?>
                    </td>
                    <td class="text-end"><?= number_format_india($grand_total, 0, '.', ',') ?></td>
                    <td class="text-end"></td>
                    <td class="text-end"><?= number_format_india($total_deposit_amount, 0, '.', ',') ?></td>
                    <td class="text-end"><?= number_format_india($total_diff_amount, 0, '.', ',') ?></td>
                    <td class="text-end"></td>
                    <td class="text-end"></td>
                    <td class="text-end"></td>

                </tr>

            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2.
        $('#service_id').select2({
            theme: 'bootstrap-5',
            placeholder: "Select one or more services",
            allowClear: true
        });

        // Select All Logic
        $('#select_all_services').on('click', function() {
            $('#service_id option').prop('selected', true);
            $('#service_id').trigger('change');
        });

        // Deselect All Logic
        $('#deselect_all_services').on('click', function() {
            $('#service_id option').prop('selected', false);
            $('#service_id').trigger('change');
        });


        // Initialize DataTables
        $('#datatable').DataTable({
            pageLength: 500
        });


        // 1. Handle Textbox Inline Edit (Date and Amount)
        $('#datatable').on('click', '.btn-edit', function() {
            const row = $(this).closest('tr');

            // Hide edit button, show save button
            row.find('.btn-edit').addClass('d-none');
            row.find('.btn-save').removeClass('d-none');

            // Transform cells into inputs
            const dateCell = row.find('.td-deposit-date');
            const amountCell = row.find('.td-deposit-amount');
            const bankCell = row.find('.td-bank');

            dateCell.html(`<input type="date" class="form-control form-control-sm edit-date" value="${dateCell.text().trim()}">`);
            amountCell.html(`<input type="number" class="form-control form-control-sm edit-amount" value="${amountCell.text().trim()}">`);

            const currentBank = bankCell.text().trim();
            bankCell.html(`
            <select class="form-select form-select-sm edit-bank">
                <option value="">Select Bank</option>
                <option value="SBI" ${currentBank === 'SBI' ? 'selected' : ''}>SBI</option>
                <option value="AXIS" ${currentBank === 'AXIS' ? 'selected' : ''}>AXIS</option>
            </select>
        `);
        });

        // 2. Handle Save Button Click
        $('#datatable').on('click', '.btn-save', function() {
            const btn = $(this);
            const row = btn.closest('tr');

            const data = {
                deposit_id: row.attr('data-deposit_id'),
                service_date: row.attr('data-service_date'),
                deposit_date: row.find('.edit-date').val(),
                deposit_amount: row.find('.edit-amount').val(),
                bank: row.find('.edit-bank').val()
            };

            btn.prop('disabled', true).text('...');

            $.ajax({
                url: "<?= base_url('reports/upsert_deposit') ?>", // Note: I suggest a 'full' upsert function
                method: "POST",
                data: data,
                success: function(response) {
                    // Return row to normal state
                    row.find('.td-deposit-date').html(`<span>${data.deposit_date}</span>`);
                    row.find('.td-deposit-amount').html(`<span>${data.deposit_amount}</span>`);
                    row.find('.td-bank').html(`<span>${data.bank}</span>`);

                    row.find('.btn-save').addClass('d-none');
                    row.find('.btn-edit').removeClass('d-none');
                    btn.prop('disabled', false).text('Save');

                    // Optional: Update Diff calculation here or reload
                    // location.reload();
                },
                error: function() {
                    alert("Error saving data");
                    btn.prop('disabled', false).text('Save');
                }
            });
        });
    });
</script>
<style>
    /* Unique container for the table cell */
    .report-tip-container {
        position: relative;
        display: inline-block;
        cursor: help;
        border-bottom: 1px dashed #ccc;
        /* Visual hint for user */
        /* width: 100%; */
        /* Ensure it fills the cell for hover area */
    }

    /* The actual tooltip popup */
    .report-tip-container .report-tip-box {
        visibility: hidden;
        width: 200px;
        /* Adjust based on your cheque string length */
        background-color: darkgray;
        /* Dark background */
        color: #fff;
        text-align: left;
        border-radius: 4px;
        padding: 8px 12px;
        position: absolute;
        z-index: 9999;
        bottom: 125%;
        /* Position above the text */
        left: 50%;
        transform: translateX(-50%);
        /* Centers the box perfectly */
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
        font-size: 0.85rem;
        line-height: 1.5;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        pointer-events: none;
        /* Prevents flickering when mouse hits the box */
    }

    /* Tooltip Arrow */
    .report-tip-container .report-tip-box::after {
        content: "";
        position: absolute;
        top: 100%;
        /* Arrow at the bottom of the box */
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: darkgray transparent transparent transparent;
    }

    /* Show the box on hover */
    .report-tip-container:hover .report-tip-box {
        visibility: visible;
        opacity: 1;
    }
</style>