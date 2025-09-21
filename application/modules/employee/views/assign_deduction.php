<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Assign Deduction to Employee</h1>

    <?php if (validation_errors()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?php echo form_open('employee/assign_deduction/' . ($employee ? $employee['id'] : ''), ['class' => 'space-y-4']); ?>
        <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>

        <div>
            <label for="employee_id" class="block text-sm font-medium text-gray-700">Select Employee</label>
            <select name="employee_id" id="employee_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <option value="">Choose an employee</option>
                <?php foreach ($employees as $emp): ?>
                    <option value="<?php echo $emp['id']; ?>" <?php echo $employee && $emp['id'] == $employee['id'] ? 'selected' : ''; ?>><?php echo html_escape($emp['first_name'] . ' ' . $emp['last_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="deduction_id" class="block text-sm font-medium text-gray-700">Select Deduction</label>
            <select name="deduction_id" id="deduction_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <option value="">Choose a deduction</option>
                <?php foreach ($deductions as $deduction): ?>
                    <option value="<?php echo $deduction['id']; ?>"><?php echo html_escape($deduction['name']); ?> (<?php echo ucfirst($deduction['type']); ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="months-section" style="display: none;">
            <label class="block text-sm font-medium text-gray-700">Applicable Months (for variable deductions)</label>
            <div class="grid grid-cols-3 md:grid-cols-6 gap-2">
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <label class="flex items-center space-x-1">
                        <input type="checkbox" name="months[]" value="<?php echo $month; ?>" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs text-gray-900"><?php echo date('M', mktime(0, 0, 0, $month, 1)); ?></span>
                    </label>
                <?php endfor; ?>
            </div>
            <div class="mt-2">
                <label for="year" class="text-sm font-medium text-gray-700">Year (optional)</label>
                <input type="number" name="year" id="year" min="2000" max="2100" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Assign Deduction</button>
    <?php echo form_close(); ?>

    <script>
        $('#deduction_id').change(function() {
            var deductionId = $(this).val();
            if (deductionId) {
                // Fetch deduction type via AJAX or pre-load
                $('#months-section').show();
            } else {
                $('#months-section').hide();
            }
        });
    </script>
</div>