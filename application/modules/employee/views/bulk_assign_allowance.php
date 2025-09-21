<!-- <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Bulk Assign Allowance</h1>

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

    <?php echo form_open('employee/bulk_assign_allowance', ['class' => 'space-y-4']); ?>
        <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>

        <div>
            <label for="allowance_id" class="block text-sm font-medium text-gray-700">Select Allowance</label>
            <select name="allowance_id" id="allowance_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <option value="">Choose an allowance</option>
                <?php foreach ($allowances as $allowance): ?>
                    <option value="<?php echo $allowance['id']; ?>" data-type="<?php echo $allowance['type']; ?>"><?php echo html_escape($allowance['name']); ?> (<?php echo ucfirst($allowance['type']); ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Select Employees</label>
            <div class="border border-gray-300 rounded-md p-3">
                <?php foreach ($employees as $employee): ?>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="employee_ids[]" value="<?php echo $employee['id']; ?>" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-gray-900"><?php echo html_escape($employee['first_name'] . ' ' . $employee['last_name']); ?> (<?php echo html_escape($employee['email']); ?>)</span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="months-section" style="display: none;">
            <label class="block text-sm font-medium text-gray-700">Applicable Months (for variable allowances)</label>
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

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Assign Allowance</button>
    <?php echo form_close(); ?>

    <script>
        $(document).ready(function() {
            $('#allowance_id').change(function() {
                var type = $('option:selected', this).data('type');
                if (type === 'variable') {
                    $('#months-section').show();
                } else {
                    $('#months-section').hide();
                }
            });
        });
    </script>
</div> -->

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="container mx-auto px-4 py-8 pb-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Bulk Assign Allowances</h1>
                <a href="<?php echo site_url('employee'); ?>" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors duration-200" title="Return to employee list">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Back to Employees
                </a>
            </div>

            <!-- Display validation errors -->
            <?php if (validation_errors()): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif; ?>
            <!-- Display error flash messages -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <?php echo html_escape($this->session->flashdata('error')); ?>
                </div>
            <?php endif; ?>
            <!-- Display success flash messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <?php echo html_escape($this->session->flashdata('success')); ?>
                </div>
            <?php endif; ?>

            <?php echo form_open('employee/store_bulk_assign', ['class' => 'space-y-6']); ?>
                <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>
                
                <!-- Allowances Multi-Select -->
                <div>
                    <label for="allowance_ids" class="block text-sm font-medium text-gray-700 mb-1">Allowances</label>
                    <div class="flex items-center space-x-4">
                        <select name="allowance_ids[]" id="allowance_ids" multiple class="select2 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required aria-label="Select Allowances">
                            <?php foreach ($allowances as $allowance): ?>
                                <option value="<?php echo $allowance['id']; ?>" <?php echo set_select('allowance_ids[]', $allowance['id']); ?>><?php echo html_escape($allowance['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="flex space-x-2">
                            <button type="button" id="select-all-allowances" class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200" title="Select all allowances">
                                Select All
                            </button>
                            <button type="button" id="clear-allowances" class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors duration-200" title="Clear all allowances">
                                Clear
                            </button>
                        </div>
                    </div>
                    <?php echo form_error('allowance_ids[]', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
                </div>

                <!-- Departments Multi-Select -->
                <div>
                    <label for="department_ids" class="block text-sm font-medium text-gray-700 mb-1">Departments</label>
                    <div class="flex items-center space-x-4">
                        <select name="department_ids[]" id="department_ids" multiple class="select2 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-label="Select Departments">
                            <?php foreach ($departments as $department): ?>
                                <option value="<?php echo $department['id']; ?>" <?php echo set_select('department_ids[]', $department['id']); ?>><?php echo html_escape($department['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="flex space-x-2">
                            <button type="button" id="select-all-departments" class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200" title="Select all departments">
                                Select All
                            </button>
                            <button type="button" id="clear-departments" class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors duration-200" title="Clear all departments">
                                Clear
                            </button>
                        </div>
                    </div>
                    <?php echo form_error('department_ids[]', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
                </div>

                <!-- Designations Multi-Select -->
                <div>
                    <label for="designation_ids" class="block text-sm font-medium text-gray-700 mb-1">Designations</label>
                    <div class="flex items-center space-x-4">
                        <select name="designation_ids[]" id="designation_ids" multiple class="select2 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-label="Select Designations">
                            <?php foreach ($designations as $designation): ?>
                                <option value="<?php echo $designation['id']; ?>" data-department-id="<?php echo $designation['department_id']; ?>" <?php echo set_select('designation_ids[]', $designation['id']); ?>><?php echo html_escape($designation['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="flex space-x-2">
                            <button type="button" id="select-all-designations" class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200" title="Select all designations">
                                Select All
                            </button>
                            <button type="button" id="clear-designations" class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors duration-200" title="Clear all designations">
                                Clear
                            </button>
                        </div>
                    </div>
                    <?php echo form_error('designation_ids[]', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
                </div>

                <!-- Employees Multi-Select -->
                <div>
                    <label for="employee_ids" class="block text-sm font-medium text-gray-700 mb-1">Employees</label>
                    <div class="flex items-center space-x-4">
                        <select name="employee_ids[]" id="employee_ids" multiple class="select2 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-label="Select Employees">
                            <?php foreach ($employees as $employee): ?>
                                <option value="<?php echo $employee['id']; ?>" <?php echo set_select('employee_ids[]', $employee['id']); ?>><?php echo html_escape($employee['first_name'] . ' ' . $employee['last_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="flex space-x-2">
                            <button type="button" id="select-all-employees" class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200" title="Select all employees">
                                Select All
                            </button>
                            <button type="button" id="clear-employees" class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors duration-200" title="Clear all employees">
                                Clear
                            </button>
                        </div>
                    </div>
                    <?php echo form_error('employee_ids[]', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
                </div>

                <!-- Consolidated Amount, Start Date, and Expire Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Allowance Details</label>
                    <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                        <div class="flex-1">
                            <input type="number" name="amount" id="amount" value="<?php echo set_value('amount'); ?>" placeholder="Amount (optional)" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-label="Allowance Amount">
                            <?php echo form_error('amount', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
                        </div>
                        <div class="flex-1">
                            <input type="date" name="start_date" id="start_date" value="<?php echo set_value('start_date'); ?>" placeholder="Start Date (optional)" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-label="Start Date">
                            <?php echo form_error('start_date', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
                        </div>
                        <div class="flex-1">
                            <input type="date" name="expire_date" id="expire_date" value="<?php echo set_value('expire_date'); ?>" placeholder="Expire Date (optional)" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-label="Expire Date">
                            <?php echo form_error('expire_date', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex space-x-4">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center transition-colors duration-200" title="Assign selected allowances">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Assign Allowances
                    </button>
                    <a href="<?php echo site_url('employee'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 flex items-center transition-colors duration-200" title="Cancel and return to employees">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Cancel
                    </a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </main>
</div>

<!-- Include jQuery and Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 for all multi-select dropdowns
        $('#allowance_ids, #department_ids, #designation_ids, #employee_ids').select2({
            placeholder: "Select options",
            allowClear: true,
            width: '100%',
            theme: 'default',
            closeOnSelect: false // Keep dropdown open for multiple selections
        });

        // Select All for Allowances
        $('#select-all-allowances').click(function() {
            $('#allowance_ids').find('option').prop('selected', true);
            $('#allowance_ids').trigger('change');
        });

        // Clear Allowances
        $('#clear-allowances').click(function() {
            $('#allowance_ids').val(null).trigger('change');
        });

        // Select All for Departments
        $('#select-all-departments').click(function() {
            $('#department_ids').find('option').prop('selected', true);
            $('#department_ids').trigger('change');
        });

        // Clear Departments
        $('#clear-departments').click(function() {
            $('#department_ids').val(null).trigger('change');
        });

        // Select All for Designations
        $('#select-all-designations').click(function() {
            $('#designation_ids').find('option').prop('selected', true);
            $('#designation_ids').trigger('change');
        });

        // Clear Designations
        $('#clear-designations').click(function() {
            $('#designation_ids').val(null).trigger('change');
        });

        // Select All for Employees
        $('#select-all-employees').click(function() {
            $('#employee_ids').find('option').prop('selected', true);
            $('#employee_ids').trigger('change');
        });

        // Clear Employees
        $('#clear-employees').click(function() {
            $('#employee_ids').val(null).trigger('change');
        });

        // Dynamic designation filtering based on department selection
        var designations = <?php echo json_encode($designations); ?>;
        $('#department_ids').on('change', function() {
            var selectedDepartments = $(this).val() || [];
            var $designationDropdown = $('#designation_ids');
            
            // Clear existing options
            $designationDropdown.val(null).trigger('change');
            $designationDropdown.find('option').remove();
            
            // Add filtered designations
            var filteredDesignations = designations.filter(function(designation) {
                return selectedDepartments.includes(designation.department_id.toString());
            });
            
            $.each(filteredDesignations, function(index, designation) {
                $designationDropdown.append(
                    $('<option></option>').val(designation.id).text(designation.name).attr('data-department-id', designation.department_id)
                );
            });

            // If no designations, fetch from server
            if (filteredDesignations.length === 0 && selectedDepartments.length > 0) {
                $.get('<?php echo site_url('employee/get_designations_by_department'); ?>', 
                    { department_id: selectedDepartments }, 
                    function(data) {
                        $.each(data, function(index, designation) {
                            $designationDropdown.append(
                                $('<option></option>').val(designation.id).text(designation.name).attr('data-department-id', designation.department_id)
                            );
                        });
                        $designationDropdown.trigger('change');
                    }, 'json'
                );
            }
        });

        // Trigger department change on page load if departments are pre-selected
        $('#department_ids').trigger('change');

        // Add hover tooltips (optional for better UX)
        $('button[title], a[title]').each(function() {
            $(this).on('mouseenter', function() {
                // Could add a custom tooltip implementation if needed
            });
        });
    });
</script>

