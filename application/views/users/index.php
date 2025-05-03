
<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.dataTables.min.css'); ?>">

<div class="container mt-5">
    <h2>Member List</h2>
    <a href="<?= site_url('users/create'); ?>" class="btn btn-primary mb-3">Add New Member</a>
    <table class="table table-bordered table-striped" id="datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['phone'] ?></td>
                    <td>
                        <a href="<?= site_url('users/edit/'.$user['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <!-- <a href="<?= site_url('users/delete/'.$user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a> -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>

jquery.dataTables.min.js
<script>
	$(document).ready( function () {
		$('#datatable').DataTable({
			pageLength: 500
		});
	} );
</script>