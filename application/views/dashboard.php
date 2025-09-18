<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="flex-1 p-6 bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-sm text-gray-600">Welcome, <?php echo html_escape($this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name')); ?> (<?php echo html_escape($this->session->userdata('role')); ?>)</p>
    </div>

    <!-- Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-indigo-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Total Employees</h3>
                    <p class="text-2xl font-bold text-gray-700"><?php echo $total_employees; ?></p>
                </div>
            </div>
        </div>
        <?php if ($this->session->userdata('role') === 'Admin' || $this->session->userdata('role') === 'HR'): ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-indigo-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Total Departments</h3>
                        <p class="text-2xl font-bold text-gray-700"><?php echo $total_departments; ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-indigo-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Total Designations</h3>
                        <p class="text-2xl font-bold text-gray-700"><?php echo $total_designations; ?></p>
                    </div>
                </div>
            </div>
            <!-- <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-indigo-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Active Payroll Runs</h3>
                        <p class="text-2xl font-bold text-gray-700"><?php echo $active_payroll_runs; ?></p>
                    </div>
                </div>
            </div> -->
        <?php endif; ?>
    </div>

    <!-- Quick Links -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="<?php echo site_url('employee'); ?>" class="bg-indigo-600 text-white px-4 py-3 rounded-md hover:bg-indigo-700 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Manage Employees
            </a>
            <?php if ($this->session->userdata('role') === 'Admin' || $this->session->userdata('role') === 'HR'): ?>
                <a href="<?php echo site_url('employee/masters/departments'); ?>" class="bg-indigo-600 text-white px-4 py-3 rounded-md hover:bg-indigo-700 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Manage Departments
                </a>
                <a href="<?php echo site_url('employee/masters/designations'); ?>" class="bg-indigo-600 text-white px-4 py-3 rounded-md hover:bg-indigo-700 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Manage Designations
                </a>
                <a href="<?php echo site_url('payroll'); ?>" class="bg-indigo-600 text-white px-4 py-3 rounded-md hover:bg-indigo-700 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Manage Payroll
                </a>
                <a href="<?php echo site_url('payroll/allowances'); ?>" class="bg-indigo-600 text-white px-4 py-3 rounded-md hover:bg-indigo-700 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h-3m3 0h3m-9 6h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Manage Allowances
                </a>
                <a href="<?php echo site_url('payroll/deductions'); ?>" class="bg-indigo-600 text-white px-4 py-3 rounded-md hover:bg-indigo-700 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Manage Deductions
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Activity -->
    <!-- <?php if ($this->session->userdata('role') === 'Admin' || $this->session->userdata('role') === 'HR'): ?>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Payroll Runs</h2>
            <?php if (empty($recent_payroll_runs)): ?>
                <p class="text-gray-500">No recent payroll runs.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Run Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($recent_payroll_runs as $run): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo date('Y-m-d', strtotime($run['run_date'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo date('Y-m-d', strtotime($run['period_start'])); ?> to <?php echo date('Y-m-d', strtotime($run['period_end'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ucfirst($run['status']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="<?php echo site_url('payroll/view_run/' . $run['id']); ?>" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?> -->
</div>
<script>
    // Initialize Feather icons
    feather.replace();
</script>