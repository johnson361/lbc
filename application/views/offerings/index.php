<?php
$service_id = $this->uri->segment(3);
$service_date = $this->uri->segment(4);

$tableClass = (empty($service_date) && empty($service_id)) ? 'd-none' : '';


?>
<div class="container-fluid">
    <!-- <h2>Offerings</h2> -->
    <form method="POST" action="<?= site_url('offerings/save'); ?>">

        <div class="mt-2 mb-2 d-flex justify-content-end align-items-center">
            <!-- <label for="service_id" class="form-label mr-2">Select Service</label> -->

            <span class="<?= $tableClass ?>">
                <label class="me-4">
                    <input type="checkbox" id="short_coins_toggle"> Show Short Coins
                </label>
                <label class="me-5">
                    <input type="checkbox" id="short_notes_toggle"> Show Short Notes
                </label>
            </span>

            <label class="me-5">
                <!-- <label for="date">Service Date</label> -->
                <input type="date" id="service_date" name="service_date" class="form-control" placeholder="dd/mm/yyyy">
            </label>

            <select name="service_id" id="service_id" class="form-select" style=" width: 400; ">
                <option value="">--Please Select Service-- </option>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service['id'] ?>" <?= $service_id == $service['id'] ? 'selected' : '' ?>>
                        <?= $service['language_name'] ?> - <?= $service['offering_name'] ?> - <?= $service['service_slot'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <table class="table table-bordered offerings_table <?= $tableClass ?>">
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
                <?php
                $serialNo = 1; // Default serial number starts at 1
                if (!empty($existing_data)):
                    foreach ($existing_data as $index => $data):
                        $serialNo = $index + 1; // Increment serial number for each entry
                ?>
                        <tr>
                            <td class="row-number"><?= $serialNo ?></td>
                            <td>
                                <input type="hidden" name="offerings[<?= $serialNo ?>][serial_no]" class="serial_no" value="<?= $serialNo ?>" />
                                <div class="autocomplete-container">
                                    <input type="text" disabled class="form-select autocomplete_member" name="offerings[<?= $serialNo ?>][autocomplete_member]" value="<?= htmlspecialchars($data['full_name'] ?? '') ?>" placeholder="Start typing...">
                                    <ul class="suggestions"></ul>
                                </div>
                            </td>
                            <td><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_2000]" class="form-control denomination" value="<?= $data['denomination_2000'] ?? 0 ?>" required></td>
                            <td><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_500]" class="form-control denomination" value="<?= $data['denomination_500'] ?? 0 ?>" required></td>
                            <td><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_200]" class="form-control denomination" value="<?= $data['denomination_200'] ?? 0 ?>" required></td>
                            <td><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_100]" class="form-control denomination" value="<?= $data['denomination_100'] ?? 0 ?>" required></td>
                            <td><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_50]" class="form-control denomination" value="<?= $data['denomination_50'] ?? 0 ?>" required></td>
                            <td class="short_notes"><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_20_notes]" class="form-control denomination" value="<?= $data['denomination_20_notes'] ?? 0 ?>" required></td>
                            <td class="short_coins"><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_20_coins]" class="form-control denomination" value="<?= $data['denomination_20_coins'] ?? 0 ?>" required></td>
                            <td class="short_notes"><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_10_notes]" class="form-control denomination" value="<?= $data['denomination_10_notes'] ?? 0 ?>" required></td>
                            <td class="short_coins"><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_10_coins]" class="form-control denomination" value="<?= $data['denomination_10_coins'] ?? 0 ?>" required></td>
                            <td class="short_notes"><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_5_notes]" class="form-control denomination" value="<?= $data['denomination_5_notes'] ?? 0 ?>" required></td>
                            <td class="short_coins"><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_5_coins]" class="form-control denomination" value="<?= $data['denomination_5_coins'] ?? 0 ?>" required></td>
                            <td class="short_notes"><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_2_notes]" class="form-control denomination" value="<?= $data['denomination_2_notes'] ?? 0 ?>" required></td>
                            <td class="short_coins"><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_2_coins]" class="form-control denomination" value="<?= $data['denomination_2_coins'] ?? 0 ?>" required></td>
                            <td class="short_notes"><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_1_notes]" class="form-control denomination" value="<?= $data['denomination_1_notes'] ?? 0 ?>" required></td>
                            <td class="short_coins"><input type="number" disabled name="offerings[<?= $serialNo ?>][denomination_1_coins]" class="form-control denomination" value="<?= $data['denomination_1_coins'] ?? 0 ?>" required></td>
                            <td><span class="total-amount"><?= $data['total_amount'] ?? 0 ?></span></td>
                            <td>
                                <button type="button" disabled class="btn btn-success add-offering">Add</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php $serialNo = $serialNo + 1; ?>
                <?php else: ?>
                    <?php $serialNo = 1; ?>
                <?php endif; ?>

                <tr>
                    <td class="row-number"><?= $serialNo ?></td>
                    <td>
                        <input type="hidden" name="offerings[<?= $serialNo ?>][serial_no]" class="serial_no" value="<?= $serialNo ?>" />
                        <div class="autocomplete-container">
                            <input type="text" class="form-select autocomplete_member" name="offerings[<?= $serialNo ?>][autocomplete_member]" placeholder="Start typing...">
                            <ul class="suggestions"></ul>
                        </div>
                    </td>
                    <td><input type="number" name="offerings[<?= $serialNo ?>][denomination_2000]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[<?= $serialNo ?>][denomination_500]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[<?= $serialNo ?>][denomination_200]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[<?= $serialNo ?>][denomination_100]" class="form-control denomination" value="0" required></td>
                    <td><input type="number" name="offerings[<?= $serialNo ?>][denomination_50]" class="form-control denomination" value="0" required></td>
                    <td class="short_notes"><input type="number" name="offerings[<?= $serialNo ?>][denomination_20_notes]" class="form-control denomination" value="0" required></td>
                    <td class="short_coins"><input type="number" name="offerings[<?= $serialNo ?>][denomination_20_coins]" class="form-control denomination" value="0" required></td>
                    <td class="short_notes"><input type="number" name="offerings[<?= $serialNo ?>][denomination_10_notes]" class="form-control denomination" value="0" required></td>
                    <td class="short_coins"><input type="number" name="offerings[<?= $serialNo ?>][denomination_10_coins]" class="form-control denomination" value="0" required></td>
                    <td class="short_notes"><input type="number" name="offerings[<?= $serialNo ?>][denomination_5_notes]" class="form-control denomination" value="0" required></td>
                    <td class="short_coins"><input type="number" name="offerings[<?= $serialNo ?>][denomination_5_coins]" class="form-control denomination" value="0" required></td>
                    <td class="short_notes"><input type="number" name="offerings[<?= $serialNo ?>][denomination_2_notes]" class="form-control denomination" value="0" required></td>
                    <td class="short_coins"><input type="number" name="offerings[<?= $serialNo ?>][denomination_2_coins]" class="form-control denomination" value="0" required></td>
                    <td class="short_notes"><input type="number" name="offerings[<?= $serialNo ?>][denomination_1_notes]" class="form-control denomination" value="0" required></td>
                    <td class="short_coins"><input type="number" name="offerings[<?= $serialNo ?>][denomination_1_coins]" class="form-control denomination" value="0" required></td>
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


        <div id="currency-total-table"></div>

        <!-- Add Row Button -->
        <!-- <button type="button" class="btn btn-secondary" id="new-row">Add Row</button> -->

        <!-- Submit Button -->
        <!-- <button type="submit" class="btn btn-primary mt-3">Submit Offerings</button> -->
    </form>
</div>

<?php
$default_service_date = empty($service_date) ? date('d/m/Y') : date('d/m/Y', strtotime($service_date));
?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        flatpickr("#service_date", {
            dateFormat: "d/m/Y", // Custom format dd/mm/yyyy
            defaultDate: "<?php echo $default_service_date; ?>",
        });
    });

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
        <?php if (empty($tableClass)) { ?>
            $('#service_date').prop('disabled', true);
            $('#service_id').css({
                'pointer-events': 'none', // Disable interaction (simulates read-only)
                'background-color': '#f0f0f0', // Optional: Change background color to simulate read-only state
                'color': '#666' // Optional: Change the text color to simulate read-only state
            });
        <?php } ?>

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
                            }
                            // else {
                            //     // suggestionsList.append('<li>No results found</li>');
                            //     PNotify.error({
                            //         title: 'Error!',
                            //         text: 'No Records Found!',
                            //         delay: 2000
                            //     });
                            // }
                        },
                    });
                }, 300); // Adjust the delay (e.g., 300ms) as needed
            } else {
                suggestionsList.empty(); // Clear suggestions when the input is empty
            }
        }

        // Event listener for autocomplete keyup on newly added rows
        $(document).on('keyup', '.autocomplete_member', function(e) {
            if (e.key === "ArrowUp" || e.key === "ArrowDown" || e.key === "ArrowLeft" || e.key === "ArrowRight") {
                return false; // Prevent default behavior for arrow keys
            }
            handleAutocompleteKeyup($(this), baseUrl);
        });

        $(document).on('keydown', '.autocomplete_member', function(e) {
            // console.log('autocomplete_member');
            const inputElement = $(this);
            const suggestionsList = inputElement.next('.suggestions');
            const suggestionItems = suggestionsList.find('li');

            if (e.key === 'ArrowDown') {
                const activeItem = suggestionsList.find('.active');
                const nextItem = activeItem.length ? activeItem.next() : suggestionItems.first();

                suggestionItems.removeClass('active');
                nextItem.addClass('active');
            } else if (e.key === 'ArrowUp') {
                const activeItem = suggestionsList.find('.active');
                const prevItem = activeItem.length ? activeItem.prev() : suggestionItems.last();

                suggestionItems.removeClass('active');
                prevItem.addClass('active');
            } else if (e.key === 'Enter') {
                const activeItem = suggestionsList.find('.active');
                if (activeItem.length) {
                    inputElement.val(activeItem.text());
                    suggestionsList.empty();
                }
            }
        });

        // Event delegation for click events on the suggestions list
        $(document).on('click', '.suggestions li', function() {
            const selectedName = $(this).text(); // Use const as selectedName is not reassigned
            const userInput = $(this).closest('div').find('.autocomplete_member'); // Find the closest input field
            userInput.val(selectedName); // Set the input field value
            $(this).closest('.suggestions').empty(); // Clear the suggestions list
        });
        <?php
        $sno = !empty($existing_data) ? count($existing_data) + 1 : 1;
        ?>
        let rowCount = <?= $sno + 1 ?>;

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

        function convertToMySQLDate(dateString) {
            const [day, month, year] = dateString.split('/');
            return `${year}-${month}-${day}`;
        }

        function updateCurrencyTable() {
            let tableHtml = '<table class="table table-bordered mt-3 text-end" style="width:400px">';
            tableHtml += '<thead><tr><th>Denomination</th><th>Count of Notes/Coins</th><th>Amount</th></tr></thead><tbody>';

            let grandTotal = 0; // Initialize a variable to store the total amount

            denominations.forEach(function(denom) {
                // console.log('denom', denom);
                const totalAmount = $(`input[name^="offerings"]`).filter(`[name*="[${denom.name}]"]`).toArray().reduce((sum, input) => {
                    const value = parseInt($(input).val(), 10) || 0;
                    return sum + (value * denom.value);
                }, 0);

                // Calculate Count of Notes/Coins
                const totalCount = $(`input[name^="offerings"]`).filter(`[name*="[${denom.name}]"]`).toArray().reduce((sum, input) => {
                    const value = parseInt($(input).val(), 10) || 0;
                    return sum + value;
                }, 0);

                // Determine the type (N for notes, C for coins)
                const typeSymbol = denom.name.toLowerCase().includes("coin") ? "C" : "N";

                // Only show rows with non-zero amounts
                if (totalAmount > 0) {
                    tableHtml += `<tr><td>₹${denom.value} ${typeSymbol}</td><td>${totalCount}</td><td>₹${totalAmount}</td></tr>`;
                    grandTotal += totalAmount; // Add to the grand total
                }
            });

            // Add the total amount row at the end
            tableHtml += `<tr><td colspan="2"><strong>Total Amount</strong></td><td><strong>₹${grandTotal}</strong></td></tr>`;

            tableHtml += '</tbody></table>';
            $('#currency-total-table').html(tableHtml); // Assuming there's a container with ID 'currency-total-table' to append the table
        }

        $(document).on('focus', 'input', function() {
            // bydefault all teh denomination are 0 , so to make it empty 
            if ($(this).attr('name')?.includes('denomination')) {
                $(this).val(''); // Clears the value of the input field
            }
        });

        // Add event listener to inputs for real-time total calculation
        $(document).on('input', 'input', function() {
            // console.log('testing..');
            const row = $(this).closest('tr');
            calculateTotal(row);
            updateCurrencyTable();
        });

        $('#service_id').on('change', function() {
            const serviceId = $('#service_id').val();
            const serviceDate = $('#service_date').val();
            const mysqlDate = convertToMySQLDate(serviceDate);

            if (serviceId && serviceDate) {
                const baseUrl = "<?php echo base_url(); ?>"; // Get the base URL from CodeIgniter
                window.location.href = baseUrl + 'offerings/index/' + serviceId + '/' + mysqlDate;
            }
        });


        // $('#service_id').on('change', function() {
        //     // Simulate read-only behavior by preventing any further interaction
        //     $('#service_date').prop('disabled', true);

        //     $(this).css({
        //         'pointer-events': 'none', // Disable interaction (simulates read-only)
        //         'background-color': '#f0f0f0', // Optional: Change background color to simulate read-only state
        //         'color': '#666' // Optional: Change the text color to simulate read-only state
        //     });
        //     // fetchExistingData();
        // });

        // function fetchExistingData() {
        //     // Get selected service_id and service_date values
        //     const serviceId = $('#service_id').val();
        //     const serviceDate = $('#service_date').val();

        //     if (!serviceId || !serviceDate) {
        //         PNotify.error({
        //             title: 'Error!',
        //             text: 'Please select both Service and Date!',
        //             delay: 2000
        //         });
        //         return;
        //     }

        //     // Perform the AJAX call
        //     $.ajax({
        //         url: '<?= site_url("offerings/fetchExistingData"); ?>', // Replace with the correct URL for your backend endpoint
        //         method: 'POST', // Use the appropriate HTTP method (GET/POST) based on your backend implementation
        //         data: {
        //             service_id: serviceId,
        //             service_date: serviceDate
        //         },
        //         dataType: 'json',
        //         success: function(response) {
        //             // Parse the response if necessary
        //             const data = typeof response === 'string' ? JSON.parse(response) : response;

        //             if (data.success) {
        //                 //$('.original_tr').hide(); //remove original row 

        //                 // Iterate over the response data and populate the table
        //                 data.data.forEach((item, index) => {

        //                     // Clone the existing row
        //                     const newRow = $('#offerings-container tr:first').clone();
        //                     //newRow.removeClass('original_tr');

        //                     // Populate the row with response data
        //                     newRow.find('.row-number').text(index + 1);
        //                     newRow.find('.serial_no').val(item.serial_no);
        //                     newRow.find('.autocomplete_member').val(item.full_name);
        //                     newRow.find('[name*="denomination_2000"]').val(item.denomination_2000);
        //                     newRow.find('[name*="denomination_500"]').val(item.denomination_500);
        //                     newRow.find('[name*="denomination_200"]').val(item.denomination_200);
        //                     newRow.find('[name*="denomination_100"]').val(item.denomination_100);
        //                     newRow.find('[name*="denomination_50"]').val(item.denomination_50);
        //                     newRow.find('[name*="denomination_20_notes"]').val(item.denomination_20_notes);
        //                     newRow.find('[name*="denomination_20_coins"]').val(item.denomination_20_coins);
        //                     newRow.find('[name*="denomination_10_notes"]').val(item.denomination_10_notes);
        //                     newRow.find('[name*="denomination_10_coins"]').val(item.denomination_10_coins);
        //                     newRow.find('[name*="denomination_5_notes"]').val(item.denomination_5_notes);
        //                     newRow.find('[name*="denomination_5_coins"]').val(item.denomination_5_coins);
        //                     newRow.find('[name*="denomination_2_notes"]').val(item.denomination_2_notes);
        //                     newRow.find('[name*="denomination_2_coins"]').val(item.denomination_2_coins);
        //                     newRow.find('[name*="denomination_1_notes"]').val(item.denomination_1_notes);
        //                     newRow.find('[name*="denomination_1_coins"]').val(item.denomination_1_coins);
        //                     newRow.find('.total-amount').text(item.total_amount);

        //                     // Append the populated row to the table body
        //                     $('#offerings-container').append(newRow);
        //                 });
        //             } 
        //             // else {
        //             //     alert(data.message || 'No data found.');
        //             // }
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('AJAX Error:', error);
        //             alert('An error occurred while fetching data.');
        //         }
        //     });
        // }

        function addNewRow() {
            const newRow = $('tbody tr:first').clone();

            newRow.find('input').not('.autocomplete_member').val(0); //excepet firt column
            newRow.find('.autocomplete_member').val(''); //set it to empty 

            newRow.find('input, button').prop('disabled', false).prop('readonly', false);
            newRow.find('button').removeAttr('disabled').removeClass('disabled');

            newRow.find('.total-amount').text('0'); // Set total to 0 for the new row

            newRow.find('input').each(function() {
                console.log('dddddddfxxx', $(this).attr('name'));
                const name = $(this).attr('name').replace('[1]', `[${rowCount}]`);
                $(this).attr('name', name);
            });

            newRow.find('.row-number').text(rowCount); // Set the row number based on rowCount
            newRow.find('.serial_no').val(rowCount);

            $('#offerings-container').append(newRow);
            rowCount++; // Increment the rowCount

            $('html, body').animate({
                scrollTop: $('#offerings-container').offset().top + $('#offerings-container').height()
            }, 500); // Smooth scroll to the bottom in 500ms

            $(window).on('wheel', {
                passive: true
            }, function(e) {
                var delta = e.originalEvent.deltaY; // Get the scroll amount in Y direction
                if (delta > 0) {
                    // console.log("Scrolling down");
                    // Add logic for scrolling down
                } else {
                    // console.log("Scrolling up");
                    // Add logic for scrolling up
                }
            });

        } //add row

        $(document).on('click', '.add-offering', function() {
            const row = $(this).closest('tr'); // Get the clicked row
            const data = {}; // Initialize data object to store values

            // Collect all input values from the row
            row.find('input').each(function() {
                const name = $(this).attr('name'); // Get the input name
                const value = $(this).val(); // Get the input value
                data[name] = value; // Add to the data object
            });

            const rowIndex = row.find('.row-number').text();
            console.log('current_rowIndex', rowIndex);
            data[`offerings[${rowIndex}][service_id]`] = $('#service_id').val();
            data[`offerings[${rowIndex}][service_date]`] = $('#service_date').val();

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
                    console.log(response);
                    if (response.success) {
                        PNotify.success({
                            title: 'Success!',
                            text: 'Offering added successfully.',
                            delay: 2000
                        });
                        addNewRow();
                        row.find('input, select').attr('readonly', true).prop('disabled', true);
                        row.find('.add-offering').prop('disabled', true).addClass('disabled');
                    } else {
                        PNotify.error({
                            title: 'Error!',
                            text: response.message,
                            delay: 2000
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    PNotify.error({
                        title: 'Error!',
                        text: error,
                        delay: 2000
                    });
                },
            });
        });
    });
</script>
<style>
    .suggestions li.active {
        background-color: #d3d3d3;
    }
</style>