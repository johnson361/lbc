<?php
function generateDenominationTable($total_check_amount = 0, $total_2000 = 0, $total_500 = 0, $total_200 = 0, $total_100 = 0, $total_50 = 0, $total_20_notes = 0, $total_20_coins = 0, $total_10_notes = 0, $total_10_coins = 0, $total_5_notes = 0, $total_5_coins = 0, $total_2_notes = 0, $total_2_coins = 0, $total_1_notes = 0, $total_1_coins = 0, $filter = null)
{
    // Array of denominations and their corresponding values
    $denominations = [
        '₹2000' => ['total' => $total_2000],
        '₹500' => ['total' => $total_500],
        '₹200' => ['total' => $total_200],
        '₹100' => ['total' => $total_100],
        '₹50' => ['total' => $total_50],
        '₹20 Notes' => ['total' => $total_20_notes],
        '₹20 Coins' => ['total' => $total_20_coins],
        '₹10 Notes' => ['total' => $total_10_notes],
        '₹10 Coins' => ['total' => $total_10_coins],
        '₹5 Notes' => ['total' => $total_5_notes],
        '₹5 Coins' => ['total' => $total_5_coins],
        '₹2 Notes' => ['total' => $total_2_notes],
        '₹2 Coins' => ['total' => $total_2_coins],
        '₹1 Notes' => ['total' => $total_1_notes],
        '₹1 Coins' => ['total' => $total_1_coins],
    ];

    $count_notes_coins_header = 'Notes/Coins';
    // Apply filter if specified
    if ($filter === 'all-coins') {
        $denominations = array_filter($denominations, function ($key) {
            return strpos($key, 'Coins') !== false;
        }, ARRAY_FILTER_USE_KEY);
        $count_notes_coins_header = 'Coins';
    } elseif ($filter === 'all-notes') {
        $denominations = array_filter($denominations, function ($key) {
            return strpos($key, 'Coins') === false;
        }, ARRAY_FILTER_USE_KEY);
        $count_notes_coins_header = 'Notes';
    }

    $grandTotal = 0;
    $table = '<table class="table table-bordered table-striped table-hover text-end">
                <thead>
                    <tr>
                        <th>Denomination</th>
                        <th>Count of ' . $count_notes_coins_header . '</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>';

    foreach ($denominations as $denomination => $data) {
        if ($data['total'] == 0) {
            continue;  // Skip the current iteration and move to the next
        }

        $denom_value = (int)preg_replace('/\D/', '', $denomination);
        $amount = $denom_value * (int)$data['total'];

        $table .= "<tr>
                        <td>{$denomination}</td>
                        <td><strong>{$data['total']}</strong></td>
                        <td><strong>" . htmlspecialchars($amount) . "</strong></td>
                    </tr>";

        $grandTotal += $amount;
    }

    $table .= "<tr>
                    <td><strong>Total</strong></td>
                    <td></td>
                    <td><strong>" . htmlspecialchars($grandTotal) . "</strong></td>
                </tr>
            </tbody>
        </table>";

    return $table;
}

function generateGrandTotalTable($grand_total_check_amount = 0, $grand_total_2000 = 0, $grand_total_500 = 0, $grand_total_200 = 0, $grand_total_100 = 0, $grand_total_50 = 0, $grand_total_20_notes = 0, $grand_total_20_coins = 0, $grand_total_10_notes = 0, $grand_total_10_coins = 0, $grand_total_5_notes = 0, $grand_total_5_coins = 0, $grand_total_2_notes = 0, $grand_total_2_coins = 0, $grand_total_1_notes = 0, $grand_total_1_coins = 0, $grand_total_amount = 0, $filter = null)
{
    $denominations = [
        '₹2000' => $grand_total_2000,
        '₹500' => $grand_total_500,
        '₹200' => $grand_total_200,
        '₹100' => $grand_total_100,
        '₹50' => $grand_total_50,
        '₹20 Notes' => $grand_total_20_notes,
        '₹20 Coins' => $grand_total_20_coins,
        '₹10 Notes' => $grand_total_10_notes,
        '₹10 Coins' => $grand_total_10_coins,
        '₹5 Notes' => $grand_total_5_notes,
        '₹5 Coins' => $grand_total_5_coins,
        '₹2 Notes' => $grand_total_2_notes,
        '₹2 Coins' => $grand_total_2_coins,
        '₹1 Notes' => $grand_total_1_notes,
        '₹1 Coins' => $grand_total_1_coins,
    ];

    $count_notes_coins_header = 'Notes/Coins';
    if ($filter === 'all-coins') {
        $denominations = array_filter($denominations, function ($key) {
            return strpos($key, 'Coins') !== false;
        }, ARRAY_FILTER_USE_KEY);
        $count_notes_coins_header = 'Coins';
    } else if ($filter === 'all-notes') {
        $denominations = array_filter($denominations, function ($key) {
            return strpos($key, 'Coins') === false;
        }, ARRAY_FILTER_USE_KEY);
        $count_notes_coins_header = 'Notes';
    } 

    $table = '<table class="table table-bordered table-striped table-hover text-end" >
                <thead>
                    <tr>
                        <th>Denomination</th>
                        <th>Count of ' . $count_notes_coins_header . '</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>';

    $grand_total_amount = 0;
    foreach ($denominations as $denomination => $total) {
        if (!empty($total)) {
            $denom_value = (int)preg_replace('/\D/', '', $denomination);
            $amount = $total * $denom_value;

            $table .= "<tr>
                            <td>{$denomination}</td>
                            <td><strong>{$total}</strong></td>
                            <td><strong>{$amount}</strong></td>
                        </tr>";
            $grand_total_amount += $amount;
        }
    }

    if ($filter == 'include-check') {
        $table .= "<tr>
                        <td >Check Total</td>
                        <td colspan='2'><strong>{$grand_total_check_amount}</strong></td>
                    </tr>";
        $grand_total_amount += $grand_total_check_amount;
    }

    if (!empty($grand_total_amount)) {
        $table .= "<tr>
                        <td><strong>Grand Total</strong></td>
                        <td></td>
                        <td><strong>{$grand_total_amount}</strong></td>
                    </tr>";
    }

    $table .= '</tbody></table>';

    return $table;
}
?>

<div class="container-fluid">
    <h3 style="text-align:center">Offerings Summary for <?php echo $service_date = (new DateTime($service_date))->format('d-m-Y') ?></h3>
    <label style="float: right;" class="service_date_div">
        <input type="date" id="service_date" name="service_date" class="form-control" placeholder="dd/mm/yyyy">
    </label>
    <?php
    // Initialize grand totals for all services
    $grand_total_check_amount = 0;
    $grand_total_2000 = 0;
    $grand_total_500 = 0;
    $grand_total_200 = 0;
    $grand_total_100 = 0;
    $grand_total_50 = 0;
    $grand_total_20_notes = 0;
    $grand_total_20_coins = 0;
    $grand_total_10_notes = 0;
    $grand_total_10_coins = 0;
    $grand_total_5_notes = 0;
    $grand_total_5_coins = 0;
    $grand_total_2_notes = 0;
    $grand_total_2_coins = 0;
    $grand_total_1_notes = 0;
    $grand_total_1_coins = 0;
    $grand_total_amount = 0;
    ?>
    <?php if (!empty($summary_data)): ?>


        <?php foreach ($summary_data as $item): ?>
            <!-- Header Section -->
            <div class="mt-4 service-header">Service: <?= htmlspecialchars($item['header']['service_name']) ?></div>
            <!-- Detail Table -->
            <?php if (!empty($item['details'])): ?>
                <?php
                // Initialize totals for each denomination for this service
                $total_check_amount = 0;
                $total_2000 = 0;
                $total_500 = 0;
                $total_200 = 0;
                $total_100 = 0;
                $total_50 = 0;
                $total_20_notes = 0;
                $total_20_coins = 0;
                $total_10_notes = 0;
                $total_10_coins = 0;
                $total_5_notes = 0;
                $total_5_coins = 0;
                $total_2_notes = 0;
                $total_2_coins = 0;
                $total_1_notes = 0;
                $total_1_coins = 0;
                $total_amount = 0;
                ?>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-end">SNo</th>
                            <th>Name</th>
                            <th class="text-end">CHK</th>
                            <th class="text-end">2000</th>
                            <th class="text-end">500</th>
                            <th class="text-end">200</th>
                            <th class="text-end">100</th>
                            <th class="text-end">50</th>
                            <th class="text-end">20 N</th>
                            <th class="text-end">20 C</th>
                            <th class="text-end">10 N</th>
                            <th class="text-end">10 C</th>
                            <th class="text-end">5 N</th>
                            <th class="text-end">5 C</th>
                            <th class="text-end">2 N</th>
                            <th class="text-end">2 C</th>
                            <th class="text-end">1 N</th>
                            <th class="text-end">1 C</th>
                            <th class="text-end">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($item['details'] as $detail): ?>
                            <tr>
                                <td class="text-end"><span><?= htmlspecialchars($detail['serial_no']) ?></span></td>
                                <td><span><?= htmlspecialchars($detail['full_name']) ?></span></td>
                                <td class="text-end"><span><?= htmlspecialchars($detail['check_amount']) ?></span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_2000'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_2000']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_500'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_500']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_200'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_200']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_100'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_100']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_50'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_50']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_20_notes'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_20_notes']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_20_coins'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_20_coins']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_10_notes'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_10_notes']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_10_coins'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_10_coins']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_5_notes'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_5_notes']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_5_coins'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_5_coins']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_2_notes'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_2_notes']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_2_coins'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_2_coins']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_1_notes'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_1_notes']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['denomination_1_coins'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['denomination_1_coins']) ?>
                                    </span></td>
                                <td class="text-end"><span class="<?= $detail['total_amount'] == 0 ? 'd-none' : '' ?>">
                                        <?= htmlspecialchars($detail['total_amount']) ?>
                                    </span></td>
                            </tr>
                            <?php
                            // Add to service totals
                            $total_check_amount += $detail['check_amount'];
                            $total_2000 += $detail['denomination_2000'];
                            $total_500 += $detail['denomination_500'];
                            $total_200 += $detail['denomination_200'];
                            $total_100 += $detail['denomination_100'];
                            $total_50 += $detail['denomination_50'];
                            $total_20_notes += $detail['denomination_20_notes'];
                            $total_20_coins += $detail['denomination_20_coins'];
                            $total_10_notes += $detail['denomination_10_notes'];
                            $total_10_coins += $detail['denomination_10_coins'];
                            $total_5_notes += $detail['denomination_5_notes'];
                            $total_5_coins += $detail['denomination_5_coins'];
                            $total_2_notes += $detail['denomination_2_notes'];
                            $total_2_coins += $detail['denomination_2_coins'];
                            $total_1_notes += $detail['denomination_1_notes'];
                            $total_1_coins += $detail['denomination_1_coins'];
                            $total_amount += $detail['total_amount'];

                            // Add to grand totals
                            $grand_total_check_amount += $detail['check_amount'];
                            $grand_total_2000 += $detail['denomination_2000'];
                            $grand_total_500 += $detail['denomination_500'];
                            $grand_total_200 += $detail['denomination_200'];
                            $grand_total_100 += $detail['denomination_100'];
                            $grand_total_50 += $detail['denomination_50'];
                            $grand_total_20_notes += $detail['denomination_20_notes'];
                            $grand_total_20_coins += $detail['denomination_20_coins'];
                            $grand_total_10_notes += $detail['denomination_10_notes'];
                            $grand_total_10_coins += $detail['denomination_10_coins'];
                            $grand_total_5_notes += $detail['denomination_5_notes'];
                            $grand_total_5_coins += $detail['denomination_5_coins'];
                            $grand_total_2_notes += $detail['denomination_2_notes'];
                            $grand_total_2_coins += $detail['denomination_2_coins'];
                            $grand_total_1_notes += $detail['denomination_1_notes'];
                            $grand_total_1_coins += $detail['denomination_1_coins'];
                            $grand_total_amount += $detail['total_amount'];

                            ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-end"><strong>Total</strong></td>
                            <td></td>
                            <td class="text-end"><span class="<?= $total_check_amount == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_check_amount) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_2000 == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_2000) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_500 == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_500) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_200 == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_200) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_100 == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_100) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_50 == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_50) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_20_notes == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_20_notes) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_20_coins == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_20_coins) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_10_notes == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_10_notes) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_10_coins == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_10_coins) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_5_notes == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_5_notes) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_5_coins == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_5_coins) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_2_notes == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_2_notes) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_2_coins == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_2_coins) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_1_notes == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_1_notes) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_1_coins == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_1_coins) ?></strong></span></td>
                            <td class="text-end"><span class="<?= $total_amount == 0 ? 'd-none' : '' ?>"><strong><?= htmlspecialchars($total_amount) ?></strong></span></td>
                        </tr>
                    </tfoot>
                </table>

                <?php /*
                <!--
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-end">SNo</th>
                            <th>Name</th>
                            <?php
                            // Generate a list of columns dynamically based on all items
                            $columns = [
                                'denomination_2000' => '2000',
                                'denomination_500' => '500',
                                'denomination_200' => '200',
                                'denomination_100' => '100',
                                'denomination_50' => '50',
                                'denomination_20_notes' => '20 N',
                                'denomination_20_coins' => '20 C',
                                'denomination_10_notes' => '10 N',
                                'denomination_10_coins' => '10 C',
                                'denomination_5_notes' => '5 N',
                                'denomination_5_coins' => '5 C',
                                'denomination_2_notes' => '2 N',
                                'denomination_2_coins' => '2 C',
                                'denomination_1_notes' => '1 N',
                                'denomination_1_coins' => '1 C',
                                'total_amount' => 'Total Amount'
                            ];

                            // Determine which columns should appear based on data
                            $activeColumns = [];
                            foreach ($columns as $key => $label) {
                                foreach ($item['details'] as $detail) {
                                    if (!empty($detail[$key])) {
                                        $activeColumns[$key] = $label;
                                        break;
                                    }
                                }
                            }

                            // Render the active columns
                            foreach ($activeColumns as $label) {
                                echo "<th class=\"text-end\">$label</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($item['details'] as $detail): ?>
                            <tr>
                                <td class="text-end"><?= htmlspecialchars($detail['serial_no']) ?></td>
                                <td><?= htmlspecialchars($detail['full_name']) ?></td>
                                <?php
                                // Render data for active columns
                                foreach ($activeColumns as $key => $label) {
                                    $value = !empty($detail[$key]) ? htmlspecialchars($detail[$key]) : '';
                                    echo "<td class=\"text-end\">$value</td>";
                                }
                                ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php */ ?>

                <div class="row">
                    <div class="col-md-4">
                        <!-- <div class="service-header">Coins</div> -->
                        <?php echo generateDenominationTable($total_check_amount, $total_2000, $total_500, $total_200, $total_100, $total_50, $total_20_notes, $total_20_coins, $total_10_notes, $total_10_coins, $total_5_notes, $total_5_coins, $total_2_notes, $total_2_coins, $total_1_notes, $total_1_coins, 'all-coins'); ?>
                    </div>
                    <div class="col-md-4">
                        <!-- <div class="service-header">Notes</div> -->
                        <?php echo generateDenominationTable($total_check_amount, $total_2000, $total_500, $total_200, $total_100, $total_50, $total_20_notes, $total_20_coins, $total_10_notes, $total_10_coins, $total_5_notes, $total_5_coins, $total_2_notes, $total_2_coins, $total_1_notes, $total_1_coins, 'all-notes'); ?>
                    </div>
                    <div class="col-md-4">
                        <!-- <div class="service-header">Coins and Notes</div> -->
                        <?php
                        echo generateDenominationTable($total_check_amount, $total_2000, $total_500, $total_200, $total_100, $total_50, $total_20_notes, $total_20_coins, $total_10_notes, $total_10_coins, $total_5_notes, $total_5_coins, $total_2_notes, $total_2_coins, $total_1_notes, $total_1_coins);
                        ?>
                    </div>
                </div>

            <?php else: ?>
                <p>No details found for this service.</p>
            <?php endif; ?>
            <div class="page-break"></div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No offerings found for the selected date.</p>
    <?php endif; ?>


    <div class="mt-5 service-header" style="font-size: 25px; background-color: gainsboro;">
        Final Denomination Summary for <?php echo $service_date; ?>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?php
            echo generateGrandTotalTable($grand_total_check_amount, $grand_total_2000, $grand_total_500, $grand_total_200, $grand_total_100, $grand_total_50, $grand_total_20_notes, $grand_total_20_coins, $grand_total_10_notes, $grand_total_10_coins, $grand_total_5_notes, $grand_total_5_coins, $grand_total_2_notes, $grand_total_2_coins, $grand_total_1_notes, $grand_total_1_coins, $grand_total_amount, 'all-coins');
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo generateGrandTotalTable($grand_total_check_amount, $grand_total_2000, $grand_total_500, $grand_total_200, $grand_total_100, $grand_total_50, $grand_total_20_notes, $grand_total_20_coins, $grand_total_10_notes, $grand_total_10_coins, $grand_total_5_notes, $grand_total_5_coins, $grand_total_2_notes, $grand_total_2_coins, $grand_total_1_notes, $grand_total_1_coins, $grand_total_amount, 'all-notes');
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo generateGrandTotalTable($grand_total_check_amount, $grand_total_2000, $grand_total_500, $grand_total_200, $grand_total_100, $grand_total_50, $grand_total_20_notes, $grand_total_20_coins, $grand_total_10_notes, $grand_total_10_coins, $grand_total_5_notes, $grand_total_5_coins, $grand_total_2_notes, $grand_total_2_coins, $grand_total_1_notes, $grand_total_1_coins, $grand_total_amount);
            ?>
        </div>

        <div class="col-md-12">
            <?php
            echo generateGrandTotalTable($grand_total_check_amount, $grand_total_2000, $grand_total_500, $grand_total_200, $grand_total_100, $grand_total_50, $grand_total_20_notes, $grand_total_20_coins, $grand_total_10_notes, $grand_total_10_coins, $grand_total_5_notes, $grand_total_5_coins, $grand_total_2_notes, $grand_total_2_coins, $grand_total_1_notes, $grand_total_1_coins, $grand_total_amount, 'include-check');
            ?>
        </div>
    </div>

</div>
<style>
    .service-header {
        font-size: 19px;
        text-align: center;
        font-weight: 600;
    }

    table th:nth-child(2),
    table td:nth-child(2) {
        width: 200px;
        /* Set the desired fixed width */
        word-wrap: break-word;
    }
</style>
<script>
    function convertToMySQLDate(dateString) {
        const [day, month, year] = dateString.split('/');
        return `${year}-${month}-${day}`;
    }
    $(document).ready(function() {
        $('#service_date').on('change', function() {
            console.log('change');
            const serviceDate = $('#service_date').val();
            console.log('change', serviceDate);

            if (serviceDate) {
                const baseUrl = "<?php echo base_url(); ?>"; // Get the base URL from CodeIgniter
                window.location.href = baseUrl + 'Offg/summary/' + serviceDate;
            }

        });
    });
</script>