<div class="container-fluid">
    <h3 style="text-align:center">Offerings Summary for <?= (new DateTime($service_date))->format('d-m-Y') ?></h3>

    <?php if (!empty($summary_data)): ?>
        <?php
        // Initialize grand totals for all services
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

        <?php foreach ($summary_data as $item): ?>
            <!-- Header Section -->
            <div class="mt-4 service-header">Service: <?= htmlspecialchars($item['header']['service_name']) ?></div>
            <!-- Detail Table -->
            <?php if (!empty($item['details'])): ?>
                <?php
                // Initialize totals for each denomination for this service
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
                            <tr >
                                <td class="text-end"><span><?= htmlspecialchars($detail['serial_no']) ?></span></td>
                                <td><span><?= htmlspecialchars($detail['full_name']) ?></span></td>
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
                            $grand_total_2000 += $detail['denomination_2000'];
                            $grand_total_500 += $detail['denomination_500'];
                            $grand_total_200 += $total_200; // Ensure $total_200 is computed within the loop
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
            <?php else: ?>
                <p>No details found for this service.</p>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No offerings found for the selected date.</p>
    <?php endif; ?>


    <div class="mt-5 service-header">Final Denomination Summary</Summary>
    </div>
    <table class="table table-bordered table-striped table-hover text-end" style=" width: 500;">
        <thead>
            <tr>
                <th>Denomination</th>
                <th>Count of Notes/Coins</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($grand_total_2000)): ?>
                <tr>
                    <td>₹2000</td>
                    <td><strong><?= $grand_total_2000 ?></strong></td>
                    <td><strong><?= $grand_total_2000 * 2000 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_500)): ?>
                <tr>
                    <td>₹500</td>
                    <td><strong><?= $grand_total_500 ?></strong></td>
                    <td><strong><?= $grand_total_500 * 500 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_200)): ?>
                <tr>
                    <td>₹200</td>
                    <td><strong><?= $grand_total_200 ?></strong></td>
                    <td><strong><?= $grand_total_200 * 200 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_100)): ?>
                <tr>
                    <td>₹100</td>
                    <td><strong><?= $grand_total_100 ?></strong></td>
                    <td><strong><?= $grand_total_100 * 100 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_50)): ?>
                <tr>
                    <td>₹50</td>
                    <td><strong><?= $grand_total_50 ?></strong></td>
                    <td><strong><?= $grand_total_50 * 50 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_20_notes)): ?>
                <tr>
                    <td>₹20 Notes</td>
                    <td><strong><?= $grand_total_20_notes ?></strong></td>
                    <td><strong><?= $grand_total_20_notes * 20 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_20_coins)): ?>
                <tr>
                    <td>₹20 Coins</td>
                    <td><strong><?= $grand_total_20_coins ?></strong></td>
                    <td><strong><?= $grand_total_20_coins * 20 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_10_notes)): ?>
                <tr>
                    <td>₹10 Notes</td>
                    <td><strong><?= $grand_total_10_notes ?></strong></td>
                    <td><strong><?= $grand_total_10_notes * 10 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_10_coins)): ?>
                <tr>
                    <td>₹10 Coins</td>
                    <td><strong><?= $grand_total_10_coins ?></strong></td>
                    <td><strong><?= $grand_total_10_coins * 10 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_5_notes)): ?>
                <tr>
                    <td>₹5 Notes</td>
                    <td><strong><?= $grand_total_5_notes ?></strong></td>
                    <td><strong><?= $grand_total_5_notes * 5 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_5_coins)): ?>
                <tr>
                    <td>₹5 Coins</td>
                    <td><strong><?= $grand_total_5_coins ?></strong></td>
                    <td><strong><?= $grand_total_5_coins * 5 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_2_notes)): ?>
                <tr>
                    <td>₹2 Notes</td>
                    <td><strong><?= $grand_total_2_notes ?></strong></td>
                    <td><strong><?= $grand_total_2_notes * 2 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_2_coins)): ?>
                <tr>
                    <td>₹2 Coins</td>
                    <td><strong><?= $grand_total_2_coins ?></strong></td>
                    <td><strong><?= $grand_total_2_coins * 2 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_1_notes)): ?>
                <tr>
                    <td>₹1 Notes</td>
                    <td><strong><?= $grand_total_1_notes ?></strong></td>
                    <td><strong><?= $grand_total_1_notes * 1 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_1_coins)): ?>
                <tr>
                    <td>₹1 Coins</td>
                    <td><strong><?= $grand_total_1_coins ?></strong></td>
                    <td><strong><?= $grand_total_1_coins * 1 ?></strong></td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($grand_total_amount)): ?>
                <tr>
                    <td><strong>Grand Total</strong></td>
                    <td></td>
                    <td><strong><?= $grand_total_amount ?></strong></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

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