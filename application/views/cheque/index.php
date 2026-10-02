<div class="container mt-5">

    <h2 class="mb-4">Cheque Offerings</h2>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th> <!-- Serial Number -->
                <th>Service Date</th>
                <th>Cheque No</th>
                <th>Cheque Amount</th>
                <th>User</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $serial = 1;
            $total_amount = 0;
            ?>
            <?php if (!empty($cheques)): ?>
                <?php foreach ($cheques as $row): ?>
                    <?php $total_amount += $row['check_amount']; ?>
                    <tr class="<?= $row['cheque_rejected'] ? 'table-danger' : '' ?>">
                        <td><?= $serial++; ?></td>
                        <td><?= $row['service_date']; ?></td>
                        <td><?= $row['check_no']; ?></td>
                        <td class="text-end"><?= number_format_india($row['check_amount']); ?></td>
                        <td><?= $row['user_name']; ?></td>
                        <td><?= $row['cheque_rejected'] ? 'Rejected' : 'Valid'; ?></td>
                        <td>
                            <?php if (!$row['cheque_rejected']): ?>
                                <a href="<?= site_url('cheque/reject/' . $row['id']); ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to reject this cheque?');">
                                    Reject
                                </a>
                            <?php else: ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <!-- Total Row -->
                <tr class="table-secondary fw-bold">
                    <td colspan="3" class="text-end">Total</td>
                    <td class="text-end"><?= number_format_india($total_amount); ?></td>
                    <td colspan="3"></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No cheque offerings found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>