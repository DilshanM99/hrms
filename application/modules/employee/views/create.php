<!-- <div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Add New Employee</h1>

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

            <?php echo form_open('employee/store', ['class' => 'space-y-6 w-full']); ?>
                <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <?php echo form_input([
                            'name' => 'first_name',
                            'id' => 'first_name',
                            'value' => set_value('first_name'),
                            'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md 
                                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm',
                            'required' => TRUE
                        ]); ?>
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <?php echo form_input([
                            'name' => 'last_name',
                            'id' => 'last_name',
                            'value' => set_value('last_name'),
                            'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md 
                                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm',
                            'required' => TRUE
                        ]); ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <?php echo form_input([
                            'name' => 'email',
                            'id' => 'email',
                            'type' => 'email',
                            'value' => set_value('email'),
                            'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md 
                                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm',
                            'required' => TRUE
                        ]); ?>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone (Optional)</label>
                        <?php echo form_input([
                            'name' => 'phone',
                            'id' => 'phone',
                            'value' => set_value('phone'),
                            'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md 
                                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'
                        ]); ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                        <?php echo form_input([
                            'name' => 'salary',
                            'id' => 'salary',
                            'type' => 'number',
                            'step' => '0.01',
                            'value' => set_value('salary'),
                            'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md 
                                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm',
                            'required' => TRUE
                        ]); ?>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <?php echo form_submit([
                        'name' => 'submit',
                        'value' => 'Save',
                        'class' => 'inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700'
                    ]); ?>
                    <a href="<?php echo site_url('employee'); ?>" 
                       class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </main>
</div> -->


<!-- <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> -->
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="container mx-auto px-4 py-8 pb-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Create Employee</h1>
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
            <?php echo form_open('employee/store', ['class' => 'grid grid-cols-1 md:grid-cols-2 gap-6']); ?>
                <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>
                <div class="col-span-1">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name" value="<?php echo set_value('first_name'); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="col-span-1">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name" value="<?php echo set_value('last_name'); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="col-span-1">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="col-span-1">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" value="<?php echo set_value('phone'); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="col-span-1">
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                    <select name="department_id" id="department_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="">Select Department</option>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?php echo $department['id']; ?>" <?php echo set_select('department_id', $department['id']); ?>><?php echo html_escape($department['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-span-1">
                    <label for="designation_id" class="block text-sm font-medium text-gray-700">Designation</label>
                    <select name="designation_id" id="designation_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="">Select Designation</option>
                        <?php foreach ($designations as $designation): ?>
                            <option value="<?php echo $designation['id']; ?>" <?php echo set_select('designation_id', $designation['id']); ?>><?php echo html_escape($designation['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-span-1">
                    <label for="salary" class="block text-sm font-medium text-gray-700">Basic Salary</label>
                    <input type="number" name="salary" id="salary" value="<?php echo set_value('salary'); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <!-- Allowances -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Allowances</label>
                    <div id="allowances-container" class="space-y-4">
                        <?php for ($i = 0; $i < 2; $i++): ?>
                            <div class="flex items-center space-x-4 allowance-row">
                                <div class="flex-1">
                                    <select name="allowances[<?php echo $i; ?>][id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Select Allowance</option>
                                        <?php foreach ($allowances as $allowance): ?>
                                            <option value="<?php echo $allowance['id']; ?>" <?php echo set_select("allowances[$i][id]", $allowance['id']); ?>><?php echo html_escape($allowance['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <input type="number" name="allowances[<?php echo $i; ?>][amount]" placeholder="Amount (leave blank for default)" value="<?php echo set_value("allowances[$i][amount]"); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="flex-1">
                                    <input type="date" name="allowances[<?php echo $i; ?>][start_date]" value="<?php echo set_value("allowances[$i][start_date]"); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="flex-1">
                                    <input type="date" name="allowances[<?php echo $i; ?>][expire_date]" value="<?php echo set_value("allowances[$i][expire_date]"); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <button type="button" class="remove-row text-red-600 hover:text-red-900" title="Remove">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        <?php endfor; ?>
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
                        <?php for ($i = 0; $i < 2; $i++): ?>
                            <div class="flex items-center space-x-4 deduction-row">
                                <div class="flex-1">
                                    <select name="deductions[<?php echo $i; ?>][id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Select Deduction</option>
                                        <?php foreach ($deductions as $deduction): ?>
                                            <option value="<?php echo $deduction['id']; ?>" <?php echo set_select("deductions[$i][id]", $deduction['id']); ?>><?php echo html_escape($deduction['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <input type="number" name="deductions[<?php echo $i; ?>][amount]" placeholder="Amount (leave blank for default)" value="<?php echo set_value("deductions[$i][amount]"); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="flex-1">
                                    <input type="date" name="deductions[<?php echo $i; ?>][start_date]" value="<?php echo set_value("deductions[$i][start_date]"); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="flex-1">
                                    <input type="date" name="deductions[<?php echo $i; ?>][expire_date]" value="<?php echo set_value("deductions[$i][expire_date]"); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <button type="button" class="remove-row text-red-600 hover:text-red-900" title="Remove">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <button type="button" id="add-deduction" class="mt-2 inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Deduction
                    </button>
                </div>

                <div class="col-span-2 flex space-x-4">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Create
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
        let allowanceIndex = 2;
        let deductionIndex = 2;

        $('#add-allowance').click(function() {
            $('#allowances-container').append(`
                <div class="flex items-center space-x-4 allowance-row">
                    <div class="flex-1">
                        <select name="allowances[${allowanceIndex}][id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select Allowance</option>
                            <?php foreach ($allowances as $allowance): ?>
                                <option value="<?php echo $allowance['id']; ?>"><?php echo html_escape($allowance['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex-1">
                        <input type="number" name="allowances[${allowanceIndex}][amount]" placeholder="Amount (leave blank for default)" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex-1">
                        <input type="date" name="allowances[${allowanceIndex}][start_date]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex-1">
                        <input type="date" name="allowances[${allowanceIndex}][expire_date]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <button type="button" class="remove-row text-red-600 hover:text-red-900" title="Remove">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `);
            allowanceIndex++;
        });

        $('#add-deduction').click(function() {
            $('#deductions-container').append(`
                <div class="flex items-center space-x-4 deduction-row">
                    <div class="flex-1">
                        <select name="deductions[${deductionIndex}][id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select Deduction</option>
                            <?php foreach ($deductions as $deduction): ?>
                                <option value="<?php echo $deduction['id']; ?>"><?php echo html_escape($deduction['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex-1">
                        <input type="number" name="deductions[${deductionIndex}][amount]" placeholder="Amount (leave blank for default)" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex-1">
                        <input type="date" name="deductions[${deductionIndex}][start_date]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex-1">
                        <input type="date" name="deductions[${deductionIndex}][expire_date]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <button type="button" class="remove-row text-red-600 hover:text-red-900" title="Remove">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `);
            deductionIndex++;
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('.allowance-row, .deduction-row').remove();
        });
    });
</script>