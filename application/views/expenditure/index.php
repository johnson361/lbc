<div class="container mt-5">
    <h2>Expenditures</h2>
    <div class="d-flex mb-4 gap-2 justify-content-between align-items-start">
        <div class="d-flex gap-2">
            <button class="btn btn-primary" onclick="openModal()">Add Expenditure</button>
            <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCashModal">
                Add Cash In Hand
            </button> -->
        </div>

        <span class="cash-balance-display p-2 rounded text-end">
            <?php $cash_balance = array_column($cash_balance, 'current_balance'); ?>
            <strong>AXIS:</strong> ₹<?= number_format($cash_balance[0], 0); ?><br>
            <strong>SBI:</strong> ₹<?= number_format($cash_balance[1], 0); ?><br>
            <strong>Cash in hand.:</strong> ₹<?= number_format($cash_balance[2], 0); ?>
        </span>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <!-- 
    <div class="modal fade" id="addCashModal" tabindex="-1" aria-labelledby="addCashModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="<?= base_url('Cash_balance/add_cash') ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCashModalLabel">Add Cash In Hand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label">Amount to Add</label>
                            <input type="number" class="form-control" name="amount" placeholder="Enter amount to add" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Cash</button>
                    </div>
                </div>
            </form>
        </div>
    </div> -->

    <div class="modal fade" id="expenditureModal" tabindex="-1" aria-labelledby="expenditureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="expenditureForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="expenditureModalLabel">Add Expenditure</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="exp_id">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title*</label>
                                    <input type="text" class="form-control" name="title" id="title" required>
                                </div>

                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method*</label>
                                    <select class="form-select" name="payment_method" id="payment_method" required>
                                        <option value="">-- Select Payment Method --</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="payment_to_div">
                                    <label for="payment_to" class="form-label">Payment To*</label>
                                    <select class="form-select" name="payment_to" id="payment_to">
                                        <option value="">-- Select Payment To --</option>
                                        <option value="Self">Self</option>
                                        <option value="Others">Others</option>
                                        <option value="RTGS">RTGS</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="bank_name_div">
                                    <label for="bank_name" class="form-label">Bank*</label>
                                    <select class="form-select" name="bank_name" id="bank_name">
                                        <option value="">-- Select Bank --</option>
                                        <option value="sbi">SBI</option>
                                        <option value="axis">AXIS</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount*</label>
                                    <input type="number" class="form-control" name="amount" id="amount" required>
                                </div>

                                <div class="mb-3">
                                    <label for="expense_date" class="form-label">Date*</label>
                                    <input type="date" class="form-control" name="expense_date" id="expense_date" required>
                                </div>

                                <div class="mb-3" id="cheque_div" style="display:none;">
                                    <label for="cheque_number" class="form-label">Cheque Number*</label>
                                    <input type="text"
                                        class="form-control"
                                        id="cheque_number"
                                        name="cheque_number"
                                        placeholder="Enter Cheque Number"
                                        maxlength="6"
                                        pattern="\d{6}">
                                </div>

                                <div class="mb-3">
                                    <label for="comments" class="form-label">Comments</label>
                                    <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover mt-4">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Payment To</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Cheque No</th>
                    <th>Payment Method</th>
                    <th>Bank</th>
                    <!-- <th>Actions</th> -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expenditures as $exp): ?>
                    <tr>
                        <td><?= $exp->id ?></td>
                        <td><?= $exp->title ?></td>
                        <td><?= $exp->payment_to ?></td>
                        <td><?= $exp->amount ?></td>
                        <td><?= $exp->expense_date ?></td>
                        <td><?= $exp->cheque_number ?></td>
                        <td><?= $exp->payment_method ?></td>
                        <td><?= $exp->bank_name ?></td>
                        <!-- <td>
                            <button class="btn btn-sm btn-info text-white" onclick="openModal(<?= $exp->id ?>)">Edit</button>
                            <a href="<?= site_url('expenditure/delete/' . $exp->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td> -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function openModal(id = null) {
        $('#expenditureForm')[0].reset();
        $('#exp_id').val('');
        $('#expenditureModalLabel').text('Add Expenditure');

        // Ensure conditional fields are hidden on reset
        $('#payment_method').val('').trigger('change');

        if (id) {
            // Your existing AJAX call to fetch data for editing
            $.get('<?= site_url("expenditure/get") ?>/' + id, function(data) {
                let exp = JSON.parse(data);
                $('#exp_id').val(exp.id);
                $('#title').val(exp.title);
                $('#amount').val(exp.amount);
                $('#expense_date').val(exp.expense_date);
                $('#comments').val(exp.comments);
                $('#payment_method').val(exp.payment_method).trigger('change'); // Set and trigger change

                // Set other fields based on fetched data
                if (exp.payment_method === 'cheque') {
                    $('#cheque_number').val(exp.cheque_number);
                    $('#payment_to').val(exp.payment_to);
                    $('#bank_name').val(exp.bank_name);
                }

                $('#expenditureModalLabel').text('Edit Expenditure');
                $('#expenditureModal').modal('show');
            });
        } else {
            $('#expenditureModal').modal('show');
        }
    }

    // Save via AJAX
    $('#expenditureForm').submit(function(e) {
        e.preventDefault();
        // The comments field was missing a name attribute, added it in the HTML for serializing
        $.post('<?= site_url("expenditure/save") ?>', $(this).serialize(), function(resp) {
            let res = JSON.parse(resp);
            if (res.status == 'success') {
                location.reload();
            } else {
                alert(res.message);
            }
        });
    });

    // Conditional field visibility logic
    $('#payment_method').on('change', function() {
        const method = $(this).val();

        // All cheque-related fields
        const chequeFields = $('#payment_to_div, #bank_name_div, #cheque_div');

        if (method === 'cheque') {
            chequeFields.slideDown(200); // Use a smooth animation
            // Add 'required' attribute to necessary fields for cheque
            $('#payment_to').prop('required', true);
            $('#bank_name').prop('required', true);

        } else if (method === 'cash') {
            chequeFields.slideUp(200, function() {
                // Clear values when hidden
                $('#cheque_number').val('');
                $('#payment_to').val('');
                $('#bank_name').val('');
                // Remove 'required' attribute
                $('#payment_to').prop('required', false);
                $('#bank_name').prop('required', false);
            });
        } else {
            // Handle the initial state or no selection
            chequeFields.hide();
            $('#payment_to').prop('required', false);
            $('#bank_name').prop('required', false);
        }
    }).trigger('change'); // Trigger on load to set initial state
</script>

<style>
    .cash-balance-display {
        background-color: #0d6efd;
        /* Use primary/info color for a clean look */
        color: #fff;
        padding: 10px 15px;
        border-radius: 0.375rem;
        /* Standard Bootstrap rounding */
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.5;
        /* Ensure good line spacing */
        min-width: 150px;
        /* Give it a set width */
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .cash-balance-display strong {
        font-weight: 700;
    }

    /* Adjusting textarea in the modal for a better look */
    #comments {
        width: 100%;
        border: 1px solid #ced4da;
        /* standard input border */
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
    }
</style>