<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="container mx-auto px-4 py-8 pb-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Payroll Run Details</h1>
            </div>

            <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Run Date</label>
                <p class="text-sm text-gray-900"><?php echo date('F j, Y', strtotime($payroll_run['run_date'])); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Period</label>
                <p class="text-sm text-gray-900"><?php echo date('M j', strtotime($payroll_run['period_start'])) . ' - ' . date('M j, Y', strtotime($payroll_run['period_end'])); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <p class="text-sm text-gray-900"><?php echo ucfirst($payroll_run['status']); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Total Gross</label>
                <p class="text-sm text-gray-900">$<?php echo number_format($payroll_run['total_gross'], 2); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Total Deductions</label>
                <p class="text-sm text-gray-900">$<?php echo number_format($payroll_run['total_deductions'], 2); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Total Net</label>
                <p class="text-sm text-gray-900">$<?php echo number_format($payroll_run['total_net'], 2); ?></p>
            </div>
        </div>
        <h4 class="text-lg font-semibold mb-4">Employee Details</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gross Salary</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Allowance</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Deduction</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Salary</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($payroll_details)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No employee details found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($payroll_details as $detail): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo html_escape($detail['first_name'] . ' ' . $detail['last_name']); ?></td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">$<?php echo number_format($detail['gross_salary'], 2); ?></td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">$<?php echo number_format($detail['total_allowance'], 2); ?></td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">$<?php echo number_format($detail['total_deduction'], 2); ?></td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">$<?php echo number_format($detail['net_salary'], 2); ?></td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ucfirst($detail['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex space-x-4">
            <a href="<?php echo site_url('payroll'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 flex items-center">
                <!-- <i data-feather="arrow-left" class="w-4 h-4 mr-1"></i> -->
                Back
            </a>
        </div>
    </div>
        </div>
    </main>
</div>