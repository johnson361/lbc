    <div class="container mt-5">
        <h2>Create Service</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="language_id" class="form-label">Language</label>
                <select name="language_id" id="language_id" class="form-select" required>
                    <?php foreach ($languages as $language): ?>
                        <option value="<?= $language['id'] ?>"><?= $language['language_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="offering_type_id" class="form-label">Offering Type</label>
                <select name="offering_type_id" id="offering_type_id" class="form-select" required>
                    <?php foreach ($offering_types as $offering): ?>
                        <option value="<?= $offering['id'] ?>"><?= $offering['offering_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="service_slot" class="form-label">Service Slot</label>
                <select name="service_slot" id="service_slot" class="form-select" required>
                    <option value="7 am">7 am</option>
                    <option value="10 am">10 am</option>
                    <option value="4 pm">4 pm</option>
                    <option value="7 pm">7 pm</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>