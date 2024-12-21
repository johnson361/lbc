<div class="container mt-5">
    <h2>Edit Member</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= $user['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="<?= $user['email']; ?>" >
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" name="phone" id="phone" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits" value="<?= $user['phone']; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
