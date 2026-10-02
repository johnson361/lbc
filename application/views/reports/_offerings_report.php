<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.dataTables.min.css'); ?>">

<div class="container mt-5">
    <h2>Week Wise Report</h2>
    <!-- <table class="table table-bordered table-striped" id="datatable"> -->
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Service Date</th>
                <th>Total Amount (Cash)</th>
                <th>Total Cheque Amount</th>
                <th>Rejected Cheques<br>(Count / Amount)</th>
                <th>Valid Cheques<br>(Count / Amount)</th>
                <th>Grand Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($report)) : ?>
                <?php
                // initialize totals
                $total_amount = 0;
                $check_amount = 0;
                $rejected_cheque_count = 0;
                $rejected_cheque_amount = 0;
                $valid_cheque_count = 0;
                $valid_cheque_amount = 0;
                $grand_total = 0;
                ?>

                <?php foreach ($report as $row) : ?>
                    <?php
                    // accumulate totals
                    $total_amount += $row['total_amount'];
                    $check_amount += $row['check_amount'];
                    $rejected_cheque_count += $row['rejected_cheque_count'];
                    $rejected_cheque_amount += $row['rejected_cheque_amount'];
                    $valid_cheque_count += $row['valid_cheque_count'];
                    $valid_cheque_amount += $row['valid_cheque_amount'];
                    $grand_total += $row['grand_total'];
                    ?>
                    <tr>
                        <td> <a href="<?= base_url('Offg/summary/' . $row['service_date']); ?>">
                                <?= $row['service_date'] ?>
                            </a>
                        </td>
                        <td class="text-end"><?= number_format_india($row['total_amount'], 0, '.', ',') ?></td>
                        <td class="text-end"><?= number_format_india($row['check_amount'], 0, '.', ',') ?></td>
                        <!-- <td class="text-end">
                            <?= $row['rejected_cheque_count'] ?> /
                            <?= number_format_india($row['rejected_cheque_amount'], 0, '.', ',') ?>
                        </td>
                        <td class="text-end">
                            <?= $row['valid_cheque_count'] ?> /
                            <?= number_format_india($row['valid_cheque_amount'], 0, '.', ',') ?>
                        </td> -->
                        <td class="text-end"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="<?= htmlspecialchars($row['rejected_cheque_list']) ?>">
                            <?= $row['rejected_cheque_count'] ?> /
                            <?= number_format_india($row['rejected_cheque_amount'], 0, '.', ',') ?>
                        </td>

                        <td class="text-end"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="<?= htmlspecialchars($row['valid_cheque_list']) ?>">
                            <?= $row['valid_cheque_count'] ?> /
                            <?= number_format_india($row['valid_cheque_amount'], 0, '.', ',') ?>
                        </td>

                        <td class="text-end fw-bold"><?= number_format_india($row['grand_total'], 0, '.', ',') ?></td>
                    </tr>
                <?php endforeach; ?>

                <!-- Totals Row -->
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
                </tr>

            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">No records found</td>
                </tr>
            <?php endif; ?>
        </tbody>

    </table>
</div>

<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            pageLength: 500
        });
    });
</script>