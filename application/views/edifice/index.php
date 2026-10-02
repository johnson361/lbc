<div class="container-fluid mt-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Edifice Records</h2>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edificeModal" onclick="openAdd()">
                <i class="bi bi-plus-circle"></i> Add Edifice Record
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Cash</h6>
                    <h3 class="card-text">₹<?= number_format($totals->total_cash ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Cheque</h6>
                    <h3 class="card-text">₹<?= number_format($totals->total_cheque ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title text-muted">Grand Total</h6>
                    <h3 class="card-text">₹<?= number_format($totals->grand_total ?? 0) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Receipt Date</th>
                    <th>Receipt No.</th>
                    <th>Reference No.</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Cash</th>
                    <th>Cheque</th>
                    <th>Book Owner</th>
                    <th>CHQ Status</th>
                    <th>Total</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($edifices)): ?>
                    <?php foreach ($edifices as $row): ?>
                        <tr>
                            <td><?= $row->id ?></td>
                            <td><?= date('d-M-Y', strtotime($row->receipt_date)) ?></td>
                            <td><?= htmlspecialchars($row->receipt_no) ?></td>
                            <td><?= htmlspecialchars($row->reference_number ?? '') ?></td>
                            <td><?= htmlspecialchars($row->name) ?></td>
                            <td><?= htmlspecialchars($row->mobile) ?></td>
                            <td class="text-end"><strong>₹<?= number_format($row->cash_amount) ?></strong></td>
                            <td class="text-end"><strong>₹<?= number_format($row->cheque_amount) ?></strong></td>
                            <td><?= htmlspecialchars($row->book_owner_name) ?></td>
                            <td>
                                <?php if ($row->cheque_rejected_status): ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Accepted</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end"><strong>₹<?= number_format($row->total_amount) ?></strong></td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edificeModal"
                                    onclick="openEdit('<?= $row->id ?>',
                                        '<?= $row->receipt_date ?>',
                                        '<?= addslashes($row->book_number) ?>',
                                        '<?= addslashes($row->receipt_no) ?>',
                                        '<?= addslashes($row->reference_number) ?>',
                                        '<?= addslashes($row->name) ?>',
                                        '<?= $row->mobile ?>',
                                        '<?= $row->cash_amount ?>',
                                        '<?= $row->cheque_amount ?>',
                                        '<?= addslashes($row->cheque_number) ?>',
                                        '<?= addslashes($row->book_owner_name) ?>',
                                        '<?= $row->cheque_rejected_status ?>')">
                                    Edit
                                </button>
                                <a href="<?= site_url('edifice/delete/' . $row->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center text-muted">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot class="table-dark">
                <tr>
                    <th colspan="6" class="text-end">TOTAL:</th>
                    <th class="text-end">₹<?= number_format($totals->total_cash ?? 0) ?></th>
                    <th class="text-end">₹<?= number_format($totals->total_cheque ?? 0) ?></th>
                    <th colspan="4"></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Summary Section -->
    <div class="row mt-5">
        <div class="col-md-6">
            <h5 class="mb-3">Summary by Book Number</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Book No.</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $grand_total = 0; ?>
                        <?php foreach ($summary_by_book as $book): ?>
                            <tr>
                                <td>Book No <?= htmlspecialchars($book->book_number) ?> (<?= htmlspecialchars($book->book_owner_name) ?>)</td>
                                <td class="text-end"><strong>₹<?= number_format($book->book_total) ?></strong></td>
                            </tr>
                            <?php $grand_total += $book->book_total; ?>
                        <?php endforeach; ?>
                        <tr class="table-secondary">
                            <th>Grand Total</th>
                            <th class="text-end">₹<?= number_format($grand_total) ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <h5 class="mb-3">Summary by Payment Type</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Payment Type</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge bg-info">Online</span></td>
                            <td class="text-end"><strong>₹<?= number_format($summary_by_payment->cash_total ?? 0) ?></strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-success">Cash</span></td>
                            <td class="text-end"><strong>₹<?= number_format($summary_by_payment->cash_total ?? 0) ?></strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-warning">Cheque</span></td>
                            <td class="text-end"><strong>₹<?= number_format($summary_by_payment->cheque_total ?? 0) ?></strong></td>
                        </tr>
                        <tr class="table-secondary">
                            <th>Grand Total</th>
                            <th class="text-end">₹<?= number_format(($summary_by_payment->cash_total ?? 0) + ($summary_by_payment->cheque_total ?? 0)) ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit -->
<div class="modal fade" id="edificeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" id="edificeForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Edifice Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receipt Date <span class="text-danger">*</span></label>
                            <input type="date" name="receipt_date" id="receipt_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Book Number <span class="text-danger">*</span></label>
                            <input type="text" name="book_number" id="book_number" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receipt No. <span class="text-danger">*</span></label>
                            <input type="text" name="receipt_no" id="receipt_no" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">Reference No.</label>
                            <input type="text" name="reference_number" id="reference_number" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Book Owner Name <span class="text-danger">*</span></label>
                            <select name="book_owner_name" id="book_owner_name" class="form-control" required>
                                <option value="">-- Select Book Owner --</option>
                                <?php foreach ($book_owners as $owner): ?>
                                    <option value="<?= htmlspecialchars($owner) ?>"><?= htmlspecialchars($owner) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mobile</label>
                            <input type="tel" name="mobile" id="mobile" class="form-control" pattern="[0-9]{10}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cash Amount</label>
                            <input type="number" name="cash_amount" id="cash_amount" class="form-control" value="0" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cheque Amount</label>
                            <input type="number" name="cheque_amount" id="cheque_amount" class="form-control" value="0" min="0">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cheque Number</label>
                            <input type="text" name="cheque_number" id="cheque_number" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="cheque_rejected_status" id="cheque_rejected_status" value="1">
                                <label class="form-check-label" for="cheque_rejected_status">
                                    Cheque Rejected
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openAdd() {
        document.getElementById('modalTitle').innerText = "Add Edifice Record";
        document.getElementById('edificeForm').action = "<?= site_url('edifice/store') ?>";
        document.getElementById('edificeForm').reset();
        document.getElementById('cheque_rejected_status').checked = false;
        document.getElementById('book_owner_name').value = "";
    }

    function openEdit(id, receipt_date, book_number, receipt_no, reference_number, name, mobile, cash_amount, cheque_amount, cheque_number, book_owner_name, cheque_rejected_status) {
        document.getElementById('modalTitle').innerText = "Edit Edifice Record";
        document.getElementById('edificeForm').action = "<?= site_url('edifice/update/') ?>" + id;
        document.getElementById('receipt_date').value = receipt_date;
        document.getElementById('book_number').value = book_number;
        document.getElementById('receipt_no').value = receipt_no;
        document.getElementById('reference_number').value = reference_number;
        document.getElementById('name').value = name;
        document.getElementById('mobile').value = mobile;
        document.getElementById('cash_amount').value = cash_amount;
        document.getElementById('cheque_amount').value = cheque_amount;
        document.getElementById('cheque_number').value = cheque_number;
        document.getElementById('book_owner_name').value = book_owner_name;
        document.getElementById('cheque_rejected_status').checked = cheque_rejected_status == 1;
    }
</script>
