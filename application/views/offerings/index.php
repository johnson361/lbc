<div class="container-fluid mt-5">
    <h2>Offerings</h2>

    <!-- Form for multiple rows -->
    <form method="POST" action="<?= site_url('offerings/save'); ?>">

        <div class="mb-5">
            <label for="service_id" class="form-label">Select Service</label>
            <select name="service_id" id="service_id" class="form-select" required>
                <!-- Dynamic Dropdown for Service -->
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service['id'] ?>"><?= $service['language_name'] ?> - <?= $service['offering_name'] ?> - <?= $service['service_slot'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <table class="table table-bordered offerings_table">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>500 N</th>
                    <th>200 N</th>
                    <th>100 N</th>
                    <th>50 N</th>
                    <th>20 N</th>
                    <th>20 C</th>
                    <th>10 N</th>
                    <th>10 C</th>
                    <th>5 N</th>
                    <th>5 C</th>
                    <th>2 N</th>
                    <th>2 C</th>
                    <th>1 N</th>
                    <th>1 C</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="offerings-container">
                <tr>
                    <td>
                        <select name="offerings[0][user_id]" class="form-select" required>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="number" name="offerings[0][denomination_500]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_200]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_100]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_50]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_20_notes]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_20_coins]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_10_notes]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_10_coins]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_5_notes]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_5_coins]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_2_notes]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_2_coins]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_1_notes]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_1_coins]" class="form-control denomination" value="0" required></td>
                    <td><span class="total-amount">0</span></td>
                </tr>
            </tbody>
            <tfoot>
                <tr id="totals-row">
                    <th>Total</th>
                    <th class="total-denomination" id="total-denomination-500">0</th>
                    <th class="total-denomination" id="total-denomination-200">0</th>
                    <th class="total-denomination" id="total-denomination-100">0</th>
                    <th class="total-denomination" id="total-denomination-50">0</th>
                    <th class="total-denomination" id="total-denomination-20-notes">0</th>
                    <th class="total-denomination" id="total-denomination-20-coins">0</th>
                    <th class="total-denomination" id="total-denomination-10-notes">0</th>
                    <th class="total-denomination" id="total-denomination-10-coins">0</th>
                    <th class="total-denomination" id="total-denomination-5-notes">0</th>
                    <th class="total-denomination" id="total-denomination-5-coins">0</th>
                    <th class="total-denomination" id="total-denomination-2-notes">0</th>
                    <th class="total-denomination" id="total-denomination-2-coins">0</th>
                    <th class="total-denomination" id="total-denomination-1-notes">0</th>
                    <th class="total-denomination" id="total-denomination-1-coins">0</th>
                    <th id="grand-total">0</th>
                </tr>
            </tfoot>
        </table>

        <!-- Add Row Button -->
        <button type="button" class="btn btn-secondary" id="add-row">Add Row</button>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary mt-3">Submit Offerings</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        let rowCount = 1;

        // Function to calculate total for a row
        function calculateTotal(row) {
            let total = 0;
            const denominations = [{
                    name: 'denomination_500',
                    value: 500
                },
                {
                    name: 'denomination_200',
                    value: 200
                },
                {
                    name: 'denomination_100',
                    value: 100
                },
                {
                    name: 'denomination_50',
                    value: 50
                },
                {
                    name: 'denomination_20_notes',
                    value: 20
                },
                {
                    name: 'denomination_20_coins',
                    value: 20
                },
                {
                    name: 'denomination_10_notes',
                    value: 10
                },
                {
                    name: 'denomination_10_coins',
                    value: 10
                },
                {
                    name: 'denomination_5_notes',
                    value: 5
                },
                {
                    name: 'denomination_5_coins',
                    value: 5
                },
                {
                    name: 'denomination_2_notes',
                    value: 2
                },
                {
                    name: 'denomination_2_coins',
                    value: 2
                },
                {
                    name: 'denomination_1_notes',
                    value: 1
                },
                {
                    name: 'denomination_1_coins',
                    value: 1
                }
            ];

            denominations.forEach(function(denom) {
                const input = row.find(`input[name^="offerings"][name*="[${denom.name}]"]`);
                let inputValue = parseInt(input.val(), 10) || 0; // Ensure the input value is parsed as an integer
                total += inputValue * denom.value;
            });

            row.find('.total-amount').text(total); // Display the total as a whole number
            calculateColumnTotals(); // Update the column totals whenever a row total changes
            calculateGrandTotal(); // Update the grand total whenever a row total changes
        }

        // Function to calculate the totals for each denomination column
        function calculateColumnTotals() {
            const denominations = [
                'denomination_500', 'denomination_200', 'denomination_100', 'denomination_50',
                'denomination_20_notes', 'denomination_20_coins', 'denomination_10_notes', 'denomination_10_coins',
                'denomination_5_notes', 'denomination_5_coins', 'denomination_2_notes', 'denomination_2_coins',
                'denomination_1_notes', 'denomination_1_coins'
            ];

            denominations.forEach(function(denom) {
                let columnTotal = 0;
                $(`input[name^="offerings"][name*="[${denom}]"]`).each(function() {
                    let inputValue = parseInt($(this).val(), 10) || 0;
                    columnTotal += inputValue;
                });
                console.log(`#total-${denom.replace(/_/g, '-')}`);
                $(`#total-${denom.replace(/_/g, '-')}`).text(columnTotal); // Update the column total in the footer
            });
        }

        // Function to calculate the grand total
        function calculateGrandTotal() {
            let grandTotal = 0;
            $('#offerings-container tr').each(function() {
                const rowTotal = parseInt($(this).find('.total-amount').text(), 10) || 0;
                grandTotal += rowTotal;
            });
            $('#grand-total').text(grandTotal); // Update the grand total in the footer
        }

        // Add event listener to inputs for real-time total calculation
        $(document).on('input', 'input', function() {
            const row = $(this).closest('tr');
            calculateTotal(row);
        });

        // Function to handle adding a new row
        $('#add-row').click(function() {
            const newRow = $('tbody tr:first').clone();
            newRow.find('input').val(0); // Reset values for new row
            newRow.find('.total-amount').text('0'); // Set total to 0 for the new row

            // Modify the name attributes to ensure they are unique
            newRow.find('select[name*="offerings[0][user_id]"]').attr('name', `offerings[${rowCount}][user_id]`);
            newRow.find('input').each(function() {
                const name = $(this).attr('name').replace('[0]', `[${rowCount}]`);
                $(this).attr('name', name);
            });

            $('#offerings-container').append(newRow);
            rowCount++;
        });
    });
</script>