<div class="container mt-5">

    <h2>Deposit List</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#depositModal" onclick="openAdd()">Add Deposit</button>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Deposit Bank</th>
                <th>Service Date</th>
                <th style=" WIDTH: 30%; ">Notes</th>
                <th>Created</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deposits as $row): ?>
                <tr>
                    <td><?= $row->id ?></td>
                    <td><?= $row->amount ?></td>
                    <td><?= $row->bank ?></td>
                    <td><?= $row->service_date ?></td>
                    <td><?= $row->notes ?></td>
                    <td><?= $row->created_at ?></td>
                    <!-- <td>
                        <button class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#depositModal"
                            onclick="openEdit('<?= $row->id ?>','<?= $row->amount ?>','<?= $row->service_date ?>','<?= $row->notes ?>','<?= $row->bank ?>')">
                            Edit
                        </button>
                        <a href="<?= site_url('deposit/delete/' . $row->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this?')">Delete</a>
                    </td> -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="depositModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="depositForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Deposit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="formAction" name="formAction">
                        <div class="mb-3">
                            <label>Amount</label>
                            <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Service Date</label>
                            <input type="date" name="service_date" id="service_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="bank">Deposit Bank</label>
                            <select name="bank" id="bank" class="form-control" required>
                                <option value="">-- Select Bank --</option>
                                <option value="SBI">SBI</option>
                                <option value="AXIS">Axis</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openAdd() {
        document.getElementById('modalTitle').innerText = "Add Deposit";
        document.getElementById('depositForm').action = "<?= site_url('deposit/store') ?>";
        document.getElementById('amount').value = "";
        document.getElementById('bank').value = "";
        document.getElementById('service_date').value = "";
        document.getElementById('notes').value = "";
    }

    function openEdit(id, amount, service_date, notes, bank) {
        document.getElementById('modalTitle').innerText = "Edit Deposit";
        document.getElementById('depositForm').action = "<?= site_url('deposit/update/') ?>" + id;
        document.getElementById('amount').value = amount;
        document.getElementById('bank').value = bank;
        document.getElementById('service_date').value = service_date;
        document.getElementById('notes').value = notes;
    }
</script>