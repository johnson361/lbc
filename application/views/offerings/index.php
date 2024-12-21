<div class="container-fluid">
    <!-- <h2>Offerings</h2> -->
    <form method="POST" action="<?= site_url('offerings/save'); ?>">

        <div class="mt-2 mb-2 d-flex justify-content-end align-items-center">
            <!-- <label for="service_id" class="form-label mr-2">Select Service</label> -->

            <label>
                <input type="checkbox" id="short_coins_toggle"> Show Short Coins
            </label>
            <label>
                <input type="checkbox" id="short_notes_toggle"> Show Short Notes
            </label>

            <select name="service_id" id="service_id" class="form-select" style=" width: 400; ">
                <option value="">--Please Select Service-- </option>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service['id'] ?>"><?= $service['language_name'] ?> - <?= $service['offering_name'] ?> - <?= $service['service_slot'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>


        <table class="table table-bordered offerings_table">
            <thead>
                <tr>
                    <th>SNO</th>
                    <th>Member</th>
                    <th>2000 N</th>
                    <th>500 N</th>
                    <th>200 N</th>
                    <th>100 N</th>
                    <th>50 N</th>
                    <th class="short_notes">20 N</th>
                    <th class="short_coins">20 C</th>
                    <th class="short_notes">10 N</th>
                    <th class="short_coins">10 C</th>
                    <th class="short_notes">5 N</th>
                    <th class="short_coins">5 C</th>
                    <th class="short_notes">2 N</th>
                    <th class="short_coins">2 C</th>
                    <th class="short_notes">1 N</th>
                    <th class="short_coins">1 C</th>
                    <th>Total</th>
                    <th>Add</th>
                </tr>
            </thead>
            <tbody id="offerings-container">
                <tr>
                    <td class="row-number">1</td>
                    <td>
                        <div class="autocomplete-container">

                            <input type="text" class="form-select autocomplete_member" name="offerings[0][autocomplete_member]" placeholder="Start typing...">
                            <ul class="suggestions"></ul>
                        </div>
                    </td>
                    <td><input type="number" name="offerings[0][denomination_2000]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_500]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_200]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_100]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[0][denomination_50]" class="form-control denomination" value="0" required></td>
                    <td class="short_notes"><input type="number" name="offerings[0][denomination_20_notes]" class="form-control denomination" value="0" required></td>
                    <td class="short_coins"><input type="number" name="offerings[0][denomination_20_coins]" class="form-control denomination" value="0" required></td>
                    <td class="short_notes"><input type="number" name="offerings[0][denomination_10_notes]" class="form-control denomination" value="0" required></td>
                    <td class="short_coins"><input type="number" name="offerings[0][denomination_10_coins]" class="form-control denomination" value="0" required></td>
                    <td class="short_notes"><input type="number" name="offerings[0][denomination_5_notes]" class="form-control denomination" value="0" required></td>
                    <td class="short_coins"><input type="number" name="offerings[0][denomination_5_coins]" class="form-control denomination" value="0" required></td>
                    <td class="short_notes"><input type="number" name="offerings[0][denomination_2_notes]" class="form-control denomination" value="0" required></td>
                    <td class="short_coins"><input type="number" name="offerings[0][denomination_2_coins]" class="form-control denomination" value="0" required></td>
                    <td class="short_notes"><input type="number" name="offerings[0][denomination_1_notes]" class="form-control denomination" value="0" required></td>
                    <td class="short_coins"><input type="number" name="offerings[0][denomination_1_coins]" class="form-control denomination" value="0" required></td>
                    <td><span class="total-amount">0</span></td>
                    <td>
                        <button type="button" class="btn btn-success add-offering">Add</button>
                    </td>

                </tr>
            </tbody>
            <tfoot>
                <tr id="totals-row">
                    <th id="count-rows"></th>
                    <th>Total</th>
                    <th class="total-denomination" id="total-denomination-2000">-</th>
                    <th class="total-denomination" id="total-denomination-500">-</th>
                    <th class="total-denomination" id="total-denomination-200">-</th>
                    <th class="total-denomination" id="total-denomination-100">-</th>
                    <th class="total-denomination" id="total-denomination-50">-</th>
                    <th class="total-denomination short_notes" id="total-denomination-20-notes">-</th>
                    <th class="total-denomination short_coins" id="total-denomination-20-coins">-</th>
                    <th class="total-denomination short_notes" id="total-denomination-10-notes">-</th>
                    <th class="total-denomination short_coins" id="total-denomination-10-coins">-</th>
                    <th class="total-denomination short_notes" id="total-denomination-5-notes">-</th>
                    <th class="total-denomination short_coins" id="total-denomination-5-coins">-</th>
                    <th class="total-denomination short_notes" id="total-denomination-2-notes">-</th>
                    <th class="total-denomination short_coins" id="total-denomination-2-coins">-</th>
                    <th class="total-denomination short_notes" id="total-denomination-1-notes">-</th>
                    <th class="total-denomination short_coins" id="total-denomination-1-coins">-</th>
                    <th id="grand-total">-</th>
                </tr>
            </tfoot>
        </table>

        <!-- Add Row Button -->
        <button type="button" class="btn btn-secondary" id="new-row">Add Row</button>

        <!-- Submit Button -->
        <!-- <button type="submit" class="btn btn-primary mt-3">Submit Offerings</button> -->
    </form>
</div>
<script>
    $('#short_coins_toggle').on('change', function() {
        if ($(this).prop('checked')) {
            // Show the short_coins column
            $('.short_coins').show();
        } else {
            // Hide the short_coins column
            $('.short_coins').hide();
        }
    });

    $('#short_notes_toggle').on('change', function() {
        if ($(this).prop('checked')) {
            // Show the short_notes column
            $('.short_notes').show();
        } else {
            // Hide the short_notes column
            $('.short_notes').hide();
        }
    });

    $(document).ready(function() {
        let baseUrl = '<?= base_url(); ?>';
        let debounceTimeout;

        function handleAutocompleteKeyup(inputElement, baseUrl) {
            const query = inputElement.val();
            const suggestionsList = inputElement.next('.suggestions');

            clearTimeout(debounceTimeout); // Clear the previous timeout

            if (query.length > 0) {
                // Set a timeout to delay the AJAX call
                debounceTimeout = setTimeout(function() {
                    $.ajax({
                        url: baseUrl + 'Users/search_users',
                        method: 'GET',
                        data: {
                            term: query
                        },
                        dataType: 'json',
                        success: function(response) {
                            suggestionsList.empty();

                            if (response.length > 0) {
                                response.forEach(function(item) {
                                    suggestionsList.append('<li data-id="' + item.id + '">' + item.name + '</li>');
                                });
                            } else {
                                suggestionsList.append('<li>No results found</li>');
                            }
                        },
                    });
                }, 300); // Adjust the delay (e.g., 300ms) as needed
            } else {
                suggestionsList.empty(); // Clear suggestions when the input is empty
            }
        }

        // $('.autocomplete_member').on('keyup', function() {
        //     handleAutocompleteKeyup($(this));
        // });

        // Event listener for autocomplete keyup on newly added rows
        $(document).on('keyup', '.autocomplete_member', function() {
            handleAutocompleteKeyup($(this), baseUrl);
        });

        // Event delegation for click events on the suggestions list
        $(document).on('click', '.suggestions li', function() {
            const selectedName = $(this).text(); // Use const as selectedName is not reassigned
            const userInput = $(this).closest('div').find('.autocomplete_member'); // Find the closest input field
            userInput.val(selectedName); // Set the input field value
            $(this).closest('.suggestions').empty(); // Clear the suggestions list
        });

        let rowCount = 1;

        const denominations = [{
                name: 'denomination_2000',
                value: 2000
            },
            {
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

        const denominationNames = denominations.map(denom => denom.name);

        // Function to calculate total for a row
        function calculateTotal(row) {
            let total = 0;

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
            denominationNames.forEach(function(denom) {
                let columnTotal = 0;
                $(`input[name^="offerings"][name*="[${denom}]"]`).each(function() {
                    let inputValue = parseInt($(this).val(), 10) || 0;
                    columnTotal += inputValue;
                });
                if (columnTotal == 0)
                    columnTotal = '.';
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

        $('#service_id').on('change', function() {
            // Simulate read-only behavior by preventing any further interaction
            $(this).css({
                'pointer-events': 'none', // Disable interaction (simulates read-only)
                'background-color': '#f0f0f0', // Optional: Change background color to simulate read-only state
                'color': '#666' // Optional: Change the text color to simulate read-only state
            });
        });

        $('#new-row').click(function() {
            // Clone the first row
            const newRow = $('tbody tr:first').clone();

            // Reset input values for the new row
            // newRow.find('input').val(0);
            newRow.find('input').not('.autocomplete_member').val(0); //excepet firt column

            newRow.find('.total-amount').text('0'); // Set total to 0 for the new row

            // Modify the name attributes to ensure they are unique for each row
            newRow.find('select[name*="offerings[0][autocomplete_member]"]').attr('name', `offerings[${rowCount}][autocomplete_member]`);
            newRow.find('input').each(function() {
                const name = $(this).attr('name').replace('[0]', `[${rowCount}]`);
                $(this).attr('name', name);
            });

            // Update row number
            newRow.find('.row-number').text(rowCount + 1); // Set the row number based on rowCount

            // Append the new row to the table
            $('#offerings-container').append(newRow);
            rowCount++; // Increment the rowCount

            // Scroll to the bottom of the table body
            $('html, body').animate({
                scrollTop: $('#offerings-container').offset().top + $('#offerings-container').height()
            }, 500); // Smooth scroll to the bottom in 500ms
        }); //add row


        $(document).on('click', '.add-offering', function() {
            const row = $(this).closest('tr'); // Get the clicked row
            const data = {}; // Initialize data object to store values

            // Collect all input values from the row
            row.find('input').each(function() {
                const name = $(this).attr('name'); // Get the input name
                const value = $(this).val(); // Get the input value
                data[name] = value; // Add to the data object
            });

            const rowIndex = row.find('.row-number').text() - 1; // Get row number and adjust to zero-based index
            console.log('rowIndex', rowIndex);
            data[`offerings[${rowIndex}][service_id]`] = $('#service_id').val();;

            console.log('Updated data', data);
            // AJAX call to handle adding the row data
            $.ajax({
                url: '<?= site_url("offerings/add"); ?>', // Update to your AJAX handler
                method: 'POST',
                data: {
                    data: data, // Send row data
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Row added successfully');
                    } else {
                        alert('Failed to add row');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('An error occurred while adding the row');
                },
            });
        });
    });
</script>
<script>
  // Info notification
  PNotify.alert({
    text: "This is an information message.",
    type: "info"
  });

  // Success notification
  PNotify.alert({
    text: "Operation was successful!",
    type: "success"
  });

  // Error notification
  PNotify.alert({
    text: "Something went wrong!",
    type: "error"
  });

  // Warning notification
  PNotify.alert({
    text: "This is a warning message.",
    type: "warning"
  });
</script>
