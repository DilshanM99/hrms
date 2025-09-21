<!-- <div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="container mx-auto px-4 py-8 pb-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Create Allowance</h1>
            </div>



            <div class="p-6">
                <?php if (validation_errors()): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
                        <i data-feather="alert-triangle" class="w-4 h-4 mr-2"></i>
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
                        <i data-feather="alert-triangle" class="w-4 h-4 mr-2"></i>
                        <?php echo html_escape($this->session->flashdata('error')); ?>
                    </div>
                <?php endif; ?>
                <?php echo form_open('payroll/store_allowance', ['class' => 'grid grid-cols-1 md:grid-cols-2 gap-6']); ?>
                <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <?php echo form_input(['name' => 'name', 'id' => 'name', 'value' => set_value('name'), 'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm', 'required' => TRUE]); ?>
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <?php echo form_dropdown('type', ['fixed' => 'Fixed', 'variable' => 'Variable'], set_value('type'), ['id' => 'type', 'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm', 'required' => TRUE]); ?>
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <?php echo form_input(['name' => 'amount', 'id' => 'amount', 'type' => 'number', 'step' => '0.01', 'value' => set_value('amount'), 'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm', 'required' => TRUE]); ?>
                </div>
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description
                        (Optional)</label>
                    <?php echo form_textarea(['name' => 'description', 'id' => 'description', 'value' => set_value('description'), 'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm', 'rows' => 4]); ?>
                </div>
                <div class="md:col-span-2 flex space-x-4">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center">
                        Create
                    </button>
                    <a href="<?php echo site_url('payroll/allowances'); ?>"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 flex items-center">
                        Cancel
                    </a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </main>
</div> -->


<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Create Allowance</h1>

    <?php if (validation_errors()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo html_escape($this->session->flashdata('error')); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo html_escape($this->session->flashdata('success')); ?>
        </div>
    <?php endif; ?>

    <?php echo form_open('payroll/store_allowance', ['class' => 'space-y-4']); ?>
        <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>

        <!-- Allowance Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Allowance Name</label>
            <input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <!-- Allowance Type -->
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <select name="type" id="type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <option value="fixed" <?php echo set_select('type', 'fixed'); ?>>Fixed</option>
                <option value="variable" <?php echo set_select('type', 'variable'); ?>>Variable</option>
            </select>
        </div>

        <!-- Default Amount -->
        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Default Amount</label>
            <input type="number" name="amount" id="amount" value="<?php echo set_value('amount'); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" step="0.01" required>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?php echo set_value('description'); ?></textarea>
        </div>

        <!-- Applicable Months for Variable Allowances -->
        <div id="months-section" style="display: none;">
            <label class="block text-sm font-medium text-gray-700">Applicable Months (for variable allowances)</label>
            <div class="mt-2">
                <label class="flex items-center space-x-1">
                    <input type="checkbox" id="select_all_months" name="select_all_months" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" <?php echo set_checkbox('select_all_months', '1'); ?>>
                    <span class="text-sm text-gray-900">Select All Months</span>
                </label>
            </div>
            <div class="grid grid-cols-3 md:grid-cols-6 gap-2 mt-2">
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <label class="flex items-center space-x-1">
                        <input type="checkbox" name="months[]" value="<?php echo $month; ?>" class="month-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" <?php echo set_checkbox('months[]', $month); ?>>
                        <span class="text-xs text-gray-900"><?php echo date('M', mktime(0, 0, 0, $month, 1)); ?></span>
                    </label>
                <?php endfor; ?>
            </div>
            <div class="mt-2">
                <label for="year" class="block text-sm font-medium text-gray-700">Year (optional)</label>
                <select name="year" id="year" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" <?php echo set_select('year', ''); ?>>No Specific Year</option>
                    <?php
                    $current_year = date('Y'); // 2025
                    for ($year = $current_year; $year <= $current_year + 10; $year++) {
                        echo "<option value='$year' " . set_select('year', $year) . ">$year</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Create Allowance</button>
            <a href="<?php echo site_url('payroll/allowances'); ?>" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancel</a>
        </div>
    <?php echo form_close(); ?>

    <!-- Include jQuery and JavaScript for toggling months-section and select all -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        // Ensure jQuery is loaded and DOM is ready
        (function($) {
            $(document).ready(function() {
                // Debug: Log to console to confirm script is running
                console.log('create_allowance.js: Document ready, binding events.');

                // Show/hide months-section based on type selection
                $('#type').on('change', function() {
                    var selectedType = $(this).val();
                    console.log('create_allowance.js: Type changed to: ' + selectedType);
                    if (selectedType === 'variable') {
                        console.log('create_allowance.js: Showing months-section');
                        $('#months-section').show();
                    } else {
                        console.log('create_allowance.js: Hiding months-section');
                        $('#months-section').hide();
                    }
                });

                // Handle "Select All Months" checkbox
                $('#select_all_months').on('change', function() {
                    console.log('create_allowance.js: Select All Months changed to: ' + this.checked);
                    $('.month-checkbox').prop('checked', this.checked);
                });

                // Ensure individual month checkboxes uncheck "Select All" if any is unchecked
                $('.month-checkbox').on('change', function() {
                    var allChecked = $('.month-checkbox').toArray().every(function(checkbox) {
                        return checkbox.checked;
                    });
                    console.log('create_allowance.js: Month checkbox changed, all checked: ' + allChecked);
                    $('#select_all_months').prop('checked', allChecked);
                });

                // Trigger change on page load to handle pre-selected values
                $('#type').trigger('change');
            });
        })(jQuery);
    </script>
</div>