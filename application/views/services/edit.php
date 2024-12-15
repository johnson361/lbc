<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Service</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $service['id'] ?>">

            <div class="mb-3">
                <label for="language_id" class="form-label">Language</label>
                <select name="language_id" id="language_id" class="form-select" required>
                    <?php foreach ($languages as $language): ?>
                        <option value="<?= $language['id'] ?>" <?= ($language['id'] == $service['language_id']) ? 'selected' : '' ?>>
                            <?= $language['language_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="offering_type_id" class="form-label">Offering Type</label>
                <select name="offering_type_id" id="offering_type_id" class="form-select" required>
                    <?php foreach ($offering_types as $offering): ?>
                        <option value="<?= $offering['id'] ?>" <?= ($offering['id'] == $service['offering_type_id']) ? 'selected' : '' ?>>
                            <?= $offering['offering_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="service_slot" class="form-label">Service Slot</label>
                <select name="service_slot" id="service_slot" class="form-select" required>
                    <option value="Morning" <?= ($service['service_slot'] == 'Morning') ? 'selected' : '' ?>>Morning</option>
                    <option value="Evening" <?= ($service['service_slot'] == 'Evening') ? 'selected' : '' ?>>Evening</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Service</button>
        </form>
    </div>
</body>
</html>
