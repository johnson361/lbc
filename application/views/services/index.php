<!-- application/views/services/index.php -->
<div class="container mt-3">
    <h2>Services List</h2>
    <a href="<?= site_url('services/create'); ?>" class="btn btn-primary mb-3">Add New Service</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Language</th>
                <th>Offering Type</th>
                <th>Service Slot</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?= $service['id'] ?></td>
                    <td><?= $service['language_name'] ?></td>
                    <td><?= $service['offering_name'] ?></td>
                    <td><?= $service['service_slot'] ?></td>
                    <td>
                        <a href="<?= site_url('services/edit/'.$service['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= site_url('services/delete/'.$service['id']) ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
