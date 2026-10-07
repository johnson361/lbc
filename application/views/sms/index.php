<div class="container mt-5">

    

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Send Offering SMS/Whatsapp</h4>
            </div>
            <div class="card-body">
                <h2 class="mb-4">SMS</h2>
                <form method="post" action="<?php echo site_url('sms/send_offering_sms'); ?>">
                    <div class="mb-3">
                        <label for="service_date_sms" class="form-label">Select Service Date (Last 1 Month)</label>
                        <select name="service_date" id="service_date_sms" class="form-select" required>
                            <option value="">-- Select Date --</option>
                            <?php foreach ($sms_service_dates as $row): ?>
                                <option value="<?php echo $row['service_date']; ?>">
                                    <?php echo date('d-M-Y', strtotime($row['service_date'])); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Send Messages</button>
                </form>

                <hr>
                <h2 class="mb-4 mt-10">WhatsApp</h2>
                <form method="post" action="<?php echo site_url('sms/send_offering_whatsapp'); ?>">
                    <div class="mb-3">
                        <label for="service_date_whatsapp" class="form-label">Select Service Date (Last 1 Month)</label>
                        <select name="service_date" id="service_date_whatsapp" class="form-select" required>
                            <option value="">-- Select Date --</option>
                            <?php foreach ($whatsapp_service_dates as $row): ?>
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