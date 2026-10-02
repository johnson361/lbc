<div class="container mt-5">

    <h2 class="mb-4">Send Messages</h2>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Send Offering SMS</h4>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo site_url('sms/send_offering_sms'); ?>">
                    <div class="mb-3">
                        <label for="service_date" class="form-label">Select Service Date (Last 1 Month)</label>
                        <select name="service_date" id="service_date" class="form-select" required>
                            <option value="">-- Select Date --</option>
                            <?php foreach ($service_dates as $row): ?>
                                <option value="<?php echo $row['service_date']; ?>">
                                    <?php echo date('d-M-Y', strtotime($row['service_date'])); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Send Messages</button>
                </form>
            </div>
        </div>
    </div>

</div>