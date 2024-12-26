<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centenary Baptist Church Service Management</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
    <link rel="stylesheet" href="<?php echo base_url('node_modules/bootstrap/dist/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('node_modules/@pnotify/core/dist/PNotify.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('node_modules/@pnotify/core/dist/BrightTheme.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('node_modules/flatpickr/dist/flatpickr.min.css'); ?>">
    <script src="<?php echo base_url('node_modules/jquery/dist/jquery.min.js'); ?>"></script>
</head>
<body>
    <div class="">
        <?php $this->load->view($page_content); ?>
    </div>
    <script src="<?php echo base_url('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/@pnotify/core/dist/PNotify.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/@pnotify/animate/dist/PNotifyAnimate.js'); ?>"></script>
</body>
<script src="<?php echo base_url('node_modules/flatpickr/dist/flatpickr.min.js'); ?>"></script>

</html>