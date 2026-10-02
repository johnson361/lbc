<!-- application/views/layouts/navbar.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= site_url('Offg'); ?>">CBC Services</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?= ($this->uri->segment(1) == 'Offg' && $this->uri->segment(2) == '') ? 'active' : '' ?>"
                        href="<?= site_url('Offg'); ?>">Offerings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($this->uri->segment(1) == 'Offg' && $this->uri->segment(2) == 'summary') ? 'active' : '' ?>"
                        href="<?= site_url('Offg/summary'); ?>">Summary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($this->uri->segment(1) == 'Reports' && $this->uri->segment(2) == 'offerings') ? 'active' : '' ?>"
                        href="<?= site_url('Reports/offerings'); ?>">Report</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($this->uri->segment(1) == 'users') ? 'active' : '' ?>"
                        href="<?= site_url('users'); ?>">Members</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($this->uri->segment(1) == 'deposit') ? 'active' : '' ?>"
                        href="<?= site_url('deposit'); ?>">Deposit</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($this->uri->segment(1) == 'Cheque') ? 'active' : '' ?>"
                        href="<?= site_url('Cheque'); ?>">Cheque</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($this->uri->segment(1) == 'edifice') ? 'active' : '' ?>"
                        href="<?= site_url('edifice'); ?>">Edifice</a>
                </li>

                <?php if ($this->session->userdata('user_id') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($this->uri->segment(1) == 'services') ? 'active' : '' ?>"
                            href="<?= site_url('services'); ?>">Services</a>
                    </li>
                <?php } ?>

                <?php if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == 2) { ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($this->uri->segment(1) == 'sms') ? 'active' : '' ?>"
                            href="<?= site_url('sms'); ?>">SMS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= ($this->uri->segment(1) == 'Expenditure') ? 'active' : '' ?>"
                            href="<?= site_url('Expenditure'); ?>">Expenditure</a>
                    </li>
                <?php } ?>

                <li class="nav-item">
                    <a class="nav-link <?= ($this->uri->segment(1) == 'Souvenir') ? 'active' : '' ?>"
                        href="<?= site_url('Souvenir'); ?>">Souvenir</a>
                </li>
            </ul>


            <div style="width: 100%;">
                <!-- <div style="float: right;">
                    <?php echo $this->session->userdata('name'); ?>
                    <a class="nav-link " href="<?= site_url('auth/logout'); ?>">Logout</a>
                </div> -->
                <div style="float: right; display: flex; align-items: center; gap: 10px;">
                    <span> <?php echo $this->session->userdata('name'); ?></span>
                    <a href="<?= site_url('auth/logout'); ?>" class="btn btn-primary ">Logout</a>
                </div>

            </div>


        </div>
    </div>
</nav>