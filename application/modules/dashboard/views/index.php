<?php $this->load->view('layouts/header', ['title' => 'Dashboard']); ?>
<div class="flex flex-1 overflow-hidden">
    <?php $this->load->view('layouts/sidebar'); ?>
    <main class="flex-1 overflow-y-auto">
        <div class="container mx-auto px-4 py-4">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Dashboard Overview</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <div class="bg-white p-4 rounded-lg shadow widget flex flex-col items-center">
                    <svg class="h-8 w-8 text-indigo-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="text-md font-medium text-gray-700">Total Employees</h3>
                    <p class="text-2xl font-bold text-gray-900"><?php echo html_escape($employee_count); ?></p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow widget flex flex-col items-center">
                    <svg class="h-8 w-8 text-indigo-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zm0 4c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zm0 4c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2z" />
                    </svg>
                    <h3 class="text-md font-medium text-gray-700">Average Salary</h3>
                    <p class="text-2xl font-bold text-gray-900">$<?php echo number_format($average_salary, 2); ?></p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow widget">
                    <h3 class="text-md font-medium text-gray-700 mb-2">Recent Employees</h3>
                    <ul class="space-y-1 text-sm">
                        <?php if (empty($recent_employees)): ?>
                            <li class="text-gray-500">No recent employees.</li>
                        <?php else: ?>
                            <?php foreach ($recent_employees as $employee): ?>
                                <li class="text-gray-900"><?php echo html_escape($employee['first_name'] . ' ' . $employee['last_name']); ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</div>
<?php $this->load->view('layouts/footer'); ?>