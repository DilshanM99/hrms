<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="container mx-auto px-4 py-8 pb-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Create Deduction</h1>
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
        <?php echo form_open('payroll/store_deduction', ['class' => 'grid grid-cols-1 md:grid-cols-2 gap-6']); ?>
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
                <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                <?php echo form_textarea(['name' => 'description', 'id' => 'description', 'value' => set_value('description'), 'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm', 'rows' => 4]); ?>
            </div>
            <div class="md:col-span-2 flex space-x-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center">
                    <!-- <i data-feather="plus" class="w-4 h-4 mr-1"></i> -->
                    Create
                </button>
                <a href="<?php echo site_url('payroll/deductions'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 flex items-center">
                    <!-- <i data-feather="x" class="w-4 h-4 mr-1"></i> -->
                    Cancel
                </a>
            </div>
        <?php echo form_close(); ?>
    </div>
        </div>
    </main>
</div>
