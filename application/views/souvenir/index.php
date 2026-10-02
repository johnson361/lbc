<style>
    @media print {
        .page-break {
            page-break-before: always;
            /* or page-break-after: always; */
            break-before: always;
            /* modern browsers */
        }
    }
</style>
<div class="container mt-5">

    <h2 class="mb-4">Souvenir Payments 2025 Data</h2>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <div class="row" style="margin-bottom: 30px;">
        <h3>📊 Committee Collection Summary</h3>
        <table class="table table-bordered table-striped" id="statsTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-end">Pages/Online</th>
                    <th class="text-end">Pages/Cash</th>
                    <th class="text-end">Pages/Cheque</th>
                    <th class="text-end">Pages/Total</th>
                    <th class="text-end">Collected Cash</th>
                    <th class="text-end">Pending Collection</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // --- 1. DEFINE STATIC COLLECTED CASH ARRAY HERE ---
                // Using array_change_key_case for robust, case-insensitive matching.
                $raw_static_collected_cash =  [
                    'J.P.ANANTHANATH' => 50000,
                    'SANTHOSH SISTER' => 6000,
                    'SANTHOSH THOLAKOPPULA' => 0,
                    'RATHNAKAR' => 50000,
                    'P.AZARIAH' => 0,
                    'SWAMYNADHAN' => 0,
                    'VARA' => 5000,
                    'P A SUDHIR' => 10000,
                ];

                // Convert all keys to UPPERCASE for reliable lookup
                $static_collected_cash = array_change_key_case($raw_static_collected_cash, CASE_UPPER);
                // ---------------------------------------------------------------


                // 2. Initializing Grand Totals
                $grand_total = 0;
                $grand_online = 0;
                $grand_cash = 0;
                $grand_cheque = 0;
                $grand_pages_count = 0;
                $grand_online_count = 0;
                $grand_cash_count = 0;
                $grand_cheque_count = 0;
                $grand_collected_cash = 0;
                $grand_pending_cash = 0;

                if (!empty($member_stats)):
                    foreach ($member_stats as $stat):
                        // Accumulate totals for the existing data columns
                        $grand_total += $stat['Total'];
                        $grand_online += $stat['Online_Total'];
                        $grand_cash += $stat['Cash_Total'];
                        $grand_cheque += $stat['Cheque_Total'];
                        $grand_pages_count += $stat['Pages_Count'];
                        $grand_online_count += $stat['Online_Count'];
                        $grand_cash_count += $stat['Cash_Count'];
                        $grand_cheque_count += $stat['Cheque_Count'];

                        // 3. Perform Collected/Pending Cash Calculation
                        $name = $stat['Name'];
                        $lookup_name = strtoupper($name);

                        $collected_cash = $static_collected_cash[$lookup_name] ?? 0;
                        $pending_cash = $stat['Cash_Total'] - $collected_cash;

                        // Accumulate grand totals for new columns
                        $grand_collected_cash += $collected_cash;
                        $grand_pending_cash += $pending_cash;

                        // Determine styling for Pending Cash
                        $pending_style = ($pending_cash > 0) ? 'style="color: red; font-weight: bold;"' : '';
                ?>
                        <tr>
                            <td><?php echo $name; ?></td>

                            <td class="text-end">
                                <?php echo $stat['Online_Count'] . ' (' . number_format($stat['Online_Total']) . ')'; ?>
                            </td>

                            <td class="text-end">
                                <?php echo $stat['Cash_Count'] . ' (' . number_format($stat['Cash_Total']) . ')'; ?>
                            </td>

                            <td class="text-end">
                                <?php echo $stat['Cheque_Count'] . ' (' . number_format($stat['Cheque_Total']) . ')'; ?>
                            </td>

                            <td class="text-end" style="font-weight: bold;">
                                <?php echo $stat['Pages_Count'] . ' (' . number_format($stat['Total']) . ')'; ?>
                            </td>

                            <td class="text-end">
                                <?php echo number_format($collected_cash); ?>
                            </td>

                            <td class="text-end" <?php echo $pending_style; ?>>
                                <?php echo number_format($pending_cash); ?>
                            </td>

                        </tr>
                <?php
                    endforeach;
                endif;
                ?>
            </tbody>
            <tfoot>
                <tr style="font-weight: bold; background-color: #f0f0f0;">
                    <td>Grand Total</td>

                    <td class="text-end">
                        <?php echo $grand_online_count . ' (' . number_format($grand_online) . ')'; ?>
                    </td>

                    <td class="text-end">
                        <?php echo $grand_cash_count . ' (' . number_format($grand_cash) . ')'; ?>
                    </td>

                    <td class="text-end">
                        <?php echo $grand_cheque_count . ' (' . number_format($grand_cheque) . ')'; ?>
                    </td>

                    <td class="text-end">
                        <?php echo $grand_pages_count . ' (' . number_format($grand_total) . ')'; ?>
                    </td>

                    <td class="text-end">
                        <?php echo number_format($grand_collected_cash); ?>
                    </td>

                    <?php
                    $grand_pending_style = ($grand_pending_cash > 0) ? 'style="color: red; font-weight: bold;"' : '';
                    ?>
                    <td class="text-end" <?php echo $grand_pending_style; ?>>
                        <?php echo number_format($grand_pending_cash); ?>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>
    <hr>
    <div class="page-break"></div>
    <div class="row" style="margin-bottom: 30px;">
        <h3>📈 Ad & Page Distribution Summary</h3>

        <div class="col-md-6">
            <h4>Page Size Counts</h4>
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>Page Size</th>
                        <th class="text-end">Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_page_count = 0; ?>
                    <?php if (!empty($page_size_stats)): ?>
                        <?php foreach ($page_size_stats as $stat): $total_page_count += $stat['count']; ?>
                            <tr>
                                <td><?php echo $stat['page_size']; ?></td>
                                <td class="text-end"><?php echo $stat['count']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr style="font-weight: bold; background-color: #e9ecef;">
                        <td>Total Entries</td>
                        <td class="text-end"><?php echo $total_page_count; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-md-6">
            <h4>Ad Type Counts</h4>
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>Type of Ad</th>
                        <th class="text-end">Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_ad_count = 0; ?>
                    <?php if (!empty($ad_type_stats)): ?>
                        <?php foreach ($ad_type_stats as $stat): $total_ad_count += $stat['count']; ?>
                            <tr>
                                <td><?php echo $stat['type_of_ad']; ?></td>
                                <td class="text-end"><?php echo $stat['count']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr style="font-weight: bold; background-color: #e9ecef;">
                        <td>Total Entries</td>
                        <td class="text-end"><?php echo $total_ad_count; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="page-break"></div>
    <hr>
    <h3>📋 Detailed Payments Log</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Receipt No.</th>
                <th>Amount</th>
                <th>Payment Mode</th>
                <!--<th>UTR/Ref No.</th>-->
                <th>Payment Date</th>
                <th>Name/Entity</th>
                <!--<th>Ad Type</th>-->
                <!--<th>Page Size</th>-->
                <th>Committee Member</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($payments)): ?>
                <?php
                $i = 1;
                foreach ($payments as $row): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['book_receipt_number']; ?></td>
                        <td><?php echo number_format($row['amount']); ?></td>
                        <td><?php echo $row['payment_mode']; ?></td>
                        <!--<td><?php echo $row['utr_cheque_reference_number']; ?></td>-->
                        <td><?php echo $row['payment_date']; ?></td>
                        <td><?php echo $row['name_of_person_entity']; ?></td>
                        <!--<td><?php echo $row['type_of_ad']; ?></td>-->
                        <!--<td><?php echo $row['page_size']; ?></td>-->
                        <td><?php echo $row['committee_member']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                    </tr>
                <?php
                    $i++;
                endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11">No data found. Ensure your database connection and table name are correct.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>