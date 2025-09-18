
<!-- <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> -->
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="container mx-auto px-4 py-8 pb-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Edit Employee: <?php echo html_escape($employee['first_name'] . ' ' . $employee['last_name']); ?></h1>
                <a href="<?php echo site_url('employee'); ?>" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Back to Employees
                </a>
            </div>

            <!-- Flash Messages -->
            <?php if (validation_errors()): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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

            <!-- Form -->
            <?php echo form_open('employee/update/' . $employee['id'], ['class' => 'grid grid-cols-1 md:grid-cols-2 gap-6']); ?>
                <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>
                <div class="col-span-1">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name" value="<?php echo set_value('first_name', $employee['first_name']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="col-span-1">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name" value="<?php echo set_value('last_name', $employee['last_name']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="col-span-1">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo set_value('email', $employee['email']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="col-span-1">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" value="<?php echo set_value('phone', $employee['phone']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="col-span-1">
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                    <select name="department_id" id="department_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="">Select Department</option>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?php echo $department['id']; ?>" <?php echo set_select('department_id', $department['id'], $department['id'] == $employee['department_id']); ?>><?php echo html_escape($department['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-span-1">
                    <label for="designation_id" class="block text-sm font-medium text-gray-700">Designation</label>
                    <select name="designation_id" id="designation_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="">Select Designation</option>
                        <?php foreach ($designations as $designation): ?>
                            <option value="<?php echo $designation['id']; ?>" <?php echo set_select('designation_id', $designation['id'], $designation['id'] == $employee['designation_id']); ?>><?php echo html_escape($designation['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-span-1">
                    <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                    <input type="number" name="salary" id="salary" value="<?php echo set_value('salary', $employee['salary']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <!-- Allowances -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Allowances</label>
                    <div id="allowances-container" class="space-y-4">
                        <?php foreach ($employee_allowances as $allowance): ?>
                            <div class="flex items-center space-x-4 allowance-row">
                                <div class="flex-1">
                                    <select name="allowances[<?php echo $allowance['allowance_id']; ?>][id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Select Allowance</option>
                                        <?php foreach ($allowances as $a): ?>
                                            <option value="<?php echo $a['id']; ?>" <?php echo set_select("allowances[{$allowance['allowance_id']}][id]", $a['id'], $a['id'] == $allowance['allowance_id']); ?>><?php echo html_escape($a['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <input type="number" name="allowances[<?php echo $allowance['allowance_id']; ?>][amount]" placeholder="Amount (leave blank for default)" value="<?php echo set_value("allowances[{$allowance['allowance_id']}][amount]", $allowance['amount']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="flex-1">
                                    <input type="date" name="allowances[<?php echo $allowance['allowance_id']; ?>][start_date]" value="<?php echo set_value("allowances[{$allowance['allowance_id']}][start_date]", $allowance['start_date']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="flex-1">
                                    <input type="date" name="allowances[<?php echo $allowance['allowance_id']; ?>][expire_date]" value="<?php echo set_value("allowances[{$allowance['allowance_id']}][expire_date]", $allowance['expire_date']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <button type="button" class="remove-row text-red-600 hover:text-red-900" title="Remove">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($employee_allowances)): ?>
                            <div class="flex items-center space-x-4 allowance-row">
                                <div class="flex-1">
                                    <select name="allowances[new_0][id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Select Allowance</option>
                                        <?php foreach ($allowances as $a): ?>
                                            <option value="<?php echo $a['id']; ?>" <?php echo set_select("allowances[new_0][id]", $a['id']); ?>><?php echo html_escape($a['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <input type="number" name="allowances[new_0][amount]" placeholder="Amount (leave blank for default)" value="<?php echo set_value("allowances[new_0][amount]"); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="flex-1">
                                    <input type="date" name="allowances[new_0][start_date]" value="<?php echo set_value("allowances[new_0][start_date]"); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="flex-1">
                                    <input type="date" name="allowances[new_0][expire_date]" value="<?php echo set_value("allowances[new_0][expire_date]"); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <button type="button" class="remove-row text-red-600 hover:text-red-900" title="Remove">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" id="add-allowance" class="mt-2 inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Allowance
                    </button>
                </div>

                <!-- Deductions -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deductions</label>
                    <div id="deductions-container" class="space-y-4">
                        <?php foreach ($employee_deductions as $deduction): ?>
                            <div class="flex items-center space-x-4 deduction-row">
                                <div class="flex-1">
                                    <select name="deductions[<?php echo $deduction['deduction_id']; ?>][id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Select Deduction</option>
                                        <?php foreach ($deductions as $d): ?>
                                            <option value="<?php echo $d['id']; ?>" <?php echo set_select("deductions[{$deduction['deduction_id']}][id]", $d['id'], $d['id'] == $deduction['deduction_id']); ?>><?php echo html_escape($d['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <input type="number" name="deductions[<?php echo $deduction['deduction_id']; ?>][amount]" placeholder="Amount (leave blank for default)" value="<?php echo set_value("deductions[{$deduction['deduction_id']}][amount]", $deduction['amount']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="flex-1">
                                    <input type="date" name="deductions[<?php echo $deduction['deduction_id']; ?>][start_date]" value="<?php echo set_value("deductions[{$deduction['deduction_id']}][start_date]", $deduction['start_date']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="flex-1">
                                    <input type="date" name="deductions[<?php echo $deduction['deduction_id']; ?>][expire_date]" value="<?php echo set_value("deductions[{$deduction['deduction_id']}][expire_date]", $deduction['expire_date']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <button type="button" class="remove-row text-red-600 hover:text-red-900" title="Remove">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($employee_deductions)): ?>
                            <div class="flex items-center space-x-4 deduction-row">
                                <div class="flex-1">
                                    <select name="deductions[new_0][id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Select Deduction</option>
                                        <?php foreach ($deductions as $d): ?>
                                            <option value="<?php echo $d['id']; ?>" <?php echo set_select("deductions[new_0][id]", $d['id']); ?>><?php echo html_escape($d['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <input type="number" name="deductions[new_0][amount]" placeholder="Amount (leave blank for default)" value="<?php echo set_value("deductions[new_0][amount]"); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="flex-1">
                                    <input type="date" name="deductions[new_0][start_date]" value="<?php echo set_value("deductions[new_0][start_date]"); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="flex-1">
                                    <input type="date" name="deductions[new_0][expire_date]" value="<?php echo set_value("deductions[new_0][expire_date]"); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <button type="button" class="remove-row text-red-600 hover:text-red-900" title="Remove">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" id="add-deduction" class="mt-2 inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Deduction
                    </button>
                </div>

                <div class="col-span-2 flex space-x-4">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Update
                    </button>
                    <a href="<?php echo site_url('employee'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Cancel
                    </a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </main>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let allowanceIndex = <?php echo count($employee_allowances) ?: 0; ?>;
        let deductionIndex = <?php echo count($employee_deductions) ?: 0; ?>;

        $('#add-allowance').click(function() {
            allowanceIndex++;
            $('#allowances-container').append(`
                <div class="flex items-center space-x-4 allowance-row">
                    <div class="flex-1">
                        <select name="allowances[new_${allowanceIndex}][id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select Allowance</option>
                            <?php foreach ($allowances as $a): ?>
                                <option value="<?php echo $a['id']; ?>"><?php echo html_escape($a['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex-1">
                        <input type="number" name="allowances[new_${allowanceIndex}][amount]" placeholder="Amount (leave blank for default)" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex-1">
                        <input type="date" name="allowances[new_${allowanceIndex}][start_date]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex-1">
                        <input type="date" name="allowances[new_${allowanceIndex}][expire_date]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <button type="button" class="remove-row text-red-600 hover:text-red-900" title="Remove">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `);
        });

        $('#add-deduction').click(function() {
            deductionIndex++;
            $('#deductions-container').append(`
                <div class="flex items-center space-x-4 deduction-row">
                    <div class="flex-1">
                        <select name="deductions[new_${deductionIndex}][id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select Deduction</option>
                            <?php foreach ($deductions as $d): ?>
                                <option value="<?php echo $d['id']; ?>"><?php echo html_escape($d['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex-1">
                        <input type="number" name="deductions[new_${deductionIndex}][amount]" placeholder="Amount (leave blank for default)" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex-1">
                        <input type="date" name="deductions[new_${deductionIndex}][start_date]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex-1">
                        <input type="date" name="deductions[new_${deductionIndex}][expire_date]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <button type="button" class="remove-row text-red-600 hover:text-red-900" title="Remove">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `);
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('.allowance-row, .deduction-row').remove();
        });
    });
</script>