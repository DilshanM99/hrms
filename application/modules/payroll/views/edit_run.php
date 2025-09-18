<!-- <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Edit Payroll Run</h3>
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
        <?php echo form_open('payroll/update_run/' . $payroll_run['id'], ['class' => 'grid grid-cols-1 md:grid-cols-2 gap-6']); ?>
            <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>
            <div>
                <label for="run_date" class="block text-sm font-medium text-gray-700">Run Date</label>
                <?php echo form_input(['name' => 'run_date', 'id' => 'run_date', 'type' => 'date', 'value' => set_value('run_date', $payroll_run['run_date']), 'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm', 'required' => TRUE]); ?>
            </div>
            <div>
                <label for="period_start" class="block text-sm font-medium text-gray-700">Period Start</label>
                <?php echo form_input(['name' => 'period_start', 'id' => 'period_start', 'type' => 'date', 'value' => set_value('period_start', $payroll_run['period_start']), 'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm', 'required' => TRUE]); ?>
            </div>
            <div>
                <label for="period_end" class="block text-sm font-medium text-gray-700">Period End</label>
                <?php echo form_input(['name' => 'period_end', 'id' => 'period_end', 'type' => 'date', 'value' => set_value('period_end', $payroll_run['period_end']), 'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm', 'required' => TRUE]); ?>
            </div>
            <div class="md:col-span-2 flex space-x-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center">
                    <i data-feather="save" class="w-4 h-4 mr-1"></i>
                    Update
                </button>
                <a href="<?php echo site_url('payroll'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 flex items-center">
                    <i data-feather="x" class="w-4 h-4 mr-1"></i>
                    Cancel
                </a>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>