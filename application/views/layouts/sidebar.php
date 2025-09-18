<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<nav class="sidebar w-64 bg-white shadow-md flex-shrink-0">
    <div class="p-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">EMS</h2>
    </div>
    <ul class="flex-1 px-2 py-4 space-y-1">
        <li>
            <a href="<?php echo site_url('employee'); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 group">
                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Employees
            </a>
        </li>
        <?php if ($this->session->userdata('role') === 'Admin' || $this->session->userdata('role') === 'HR'): ?>
            <li>
                <a href="<?php echo site_url('employee/masters/departments'); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Departments
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('employee/masters/designations'); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Designations
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('payroll'); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Payroll Runs
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('payroll/allowances'); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h-3m3 0h3m-9 6h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Allowances
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('payroll/deductions'); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Deductions
                </a>
            </li>
        <?php endif; ?>
        <li>
            <a href="<?php echo site_url('auth/logout'); ?>" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 group">
                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </a>
        </li>
    </ul>
</nav>