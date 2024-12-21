<!-- application/views/layouts/navbar.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= site_url('dashboard'); ?>">Church Services</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= site_url('services'); ?>">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('offerings'); ?>">Offerings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('users'); ?>">Members</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

