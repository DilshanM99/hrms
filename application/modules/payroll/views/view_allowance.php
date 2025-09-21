<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">View Allowance</h1>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <?php echo html_escape($this->session->flashdata('success')); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <?php echo html_escape($this->session->flashdata('error')); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white p-6 border border-gray-200 rounded-lg">
        <!-- Allowance Name -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Allowance Name</label>
            <p class="mt-1 text-sm text-gray-900"><?php echo html_escape($allowance['name']); ?></p>
        </div>

        <!-- Allowance Type -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Type</label>
            <p class="mt-1 text-sm text-gray-900"><?php echo ucfirst($allowance['type']); ?></p>
        </div>

        <!-- Default Amount -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Default Amount</label>
            <p class="mt-1 text-sm text-gray-900">Rs <?php echo number_format($allowance['amount'], 2); ?></p>
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <p class="mt-1 text-sm text-gray-900"><?php echo html_escape($allowance['description']) ?: '-'; ?></p>
        </div>

        <!-- Applicable Months for Variable Allowances -->
        <?php if ($allowance['type'] === 'variable'): ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Applicable Months</label>
                <p class="mt-1 text-sm text-gray-900">
                    <?php
                    if (!empty($allowance['months'])) {
                        $month_names = array_map(function($month) {
                            return date('M', mktime(0, 0, 0, $month, 1));
                        }, $allowance['months']);
                        echo count($month_names) === 12 ? 'All Months' : implode(', ', $month_names);
                    } else {
                        echo '-';
                    }
                    ?>
                </p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Year (optional)</label>
                <p class="mt-1 text-sm text-gray-900"><?php echo $allowance['year'] ? html_escape($allowance['year']) : 'No Specific Year'; ?></p>
            </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="flex space-x-4">
            <a href="<?php echo site_url('payroll/edit_allowance/' . $allowance['id']); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Update
            </a>
            <a href="<?php echo site_url('payroll/allowances'); ?>" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back
            </a>
        </div>
    </div>
</div>