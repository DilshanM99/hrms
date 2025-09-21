<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Allowance: <?php echo html_escape($allowance['name']); ?></h1>

    <?php if (validation_errors()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <?php echo html_escape($this->session->flashdata('error')); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <?php echo html_escape($this->session->flashdata('success')); ?>
        </div>
    <?php endif; ?>

    <?php echo form_open('payroll/update_allowance/' . $allowance['id'], ['class' => 'space-y-4']); ?>
        <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>

        <!-- Allowance Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Allowance Name</label>
            <input type="text" name="name" id="name" value="<?php echo set_value('name', $allowance['name']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <!-- Allowance Type -->
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <select name="type" id="type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <option value="fixed" <?php echo set_select('type', 'fixed', $allowance['type'] === 'fixed'); ?>>Fixed</option>
                <option value="variable" <?php echo set_select('type', 'variable', $allowance['type'] === 'variable'); ?>>Variable</option>
            </select>
        </div>

        <!-- Default Amount -->
        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Default Amount</label>
            <input type="number" name="amount" id="amount" value="<?php echo set_value('amount', $allowance['amount']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" step="0.01" required>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?php echo set_value('description', $allowance['description']); ?></textarea>
        </div>

        <!-- Applicable Months for Variable Allowances -->
        <div id="months-section" style="display: <?php echo $allowance['type'] === 'variable' ? 'block' : 'none'; ?>;">
            <label class="block text-sm font-medium text-gray-700">Applicable Months (for variable allowances)</label>
            <div class="mt-2">
                <label class="flex items-center space-x-1">
                    <input type="checkbox" id="select_all_months" name="select_all_months" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" <?php echo set_checkbox('select_all_months', '1', count($allowance['months']) === 12); ?>>
                    <span class="text-sm text-gray-900">Select All Months</span>
                </label>
            </div>
            <div class="grid grid-cols-3 md:grid-cols-6 gap-2 mt-2">
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <label class="flex items-center space-x-1">
                        <input type="checkbox" name="months[]" value="<?php echo $month; ?>" class="month-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" <?php echo set_checkbox('months[]', $month, in_array($month, $allowance['months'])); ?>>
                        <span class="text-xs text-gray-900"><?php echo date('M', mktime(0, 0, 0, $month, 1)); ?></span>
                    </label>
                <?php endfor; ?>
            </div>
            <div class="mt-2">
                <label for="year" class="block text-sm font-medium text-gray-700">Year (optional)</label>
                <select name="year" id="year" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" <?php echo set_select('year', '', !$allowance['year']); ?>>No Specific Year</option>
                    <?php
                    $current_year = date('Y'); // 2025
                    for ($year = $current_year; $year <= $current_year + 10; $year++) {
                        echo "<option value='$year' " . set_select('year', $year, $allowance['year'] == $year) . ">$year</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Update Allowance
            </button>
            <a href="<?php echo site_url('payroll/allowances'); ?>" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back
            </a>
        </div>
    <?php echo form_close(); ?>

    <!-- Include jQuery and JavaScript for toggling months-section and select all -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        // Ensure jQuery is loaded and DOM is ready
        (function($) {
            $(document).ready(function() {
                // Debug: Log to console to confirm script is running
                console.log('edit_allowance.js: Document ready, binding events.');

                // Show/hide months-section based on type selection
                $('#type').on('change', function() {
                    var selectedType = $(this).val();
                    console.log('edit_allowance.js: Type changed to: ' + selectedType);
                    if (selectedType === 'variable') {
                        console.log('edit_allowance.js: Showing months-section');
                        $('#months-section').show();
                    } else {
                        console.log('edit_allowance.js: Hiding months-section');
                        $('#months-section').hide();
                    }
                });

                // Handle "Select All Months" checkbox
                $('#select_all_months').on('change', function() {
                    console.log('edit_allowance.js: Select All Months changed to: ' + this.checked);
                    $('.month-checkbox').prop('checked', this.checked);
                });

                // Ensure individual month checkboxes uncheck "Select All" if any is unchecked
                $('.month-checkbox').on('change', function() {
                    var allChecked = $('.month-checkbox').toArray().every(function(checkbox) {
                        return checkbox.checked;
                    });
                    console.log('edit_allowance.js: Month checkbox changed, all checked: ' + allChecked);
                    $('#select_all_months').prop('checked', allChecked);
                });

                // Trigger change on page load to handle pre-selected values
                $('#type').trigger('change');
            });
        })(jQuery);
    </script>
</div>