<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="container mx-auto px-4 py-8 pb-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Employee Management</h1>
                <a href="<?= site_url('employee/create') ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Employee
                </a>
            </div>

            <!-- Search Form -->
            <form method="get" action="<?= site_url('employee') ?>" class="mb-6">
                <div class="flex space-x-2">
                    <input type="text" name="search" value="<?= html_escape($search) ?>" placeholder="Search by name or email..." class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <input type="hidden" name="sort" value="<?= html_escape($sort) ?>">
                    <input type="hidden" name="order" value="<?= html_escape($order) ?>">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                    <a href="<?= site_url('employee') ?>" class="flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                </div>
            </form>

            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?= html_escape($this->session->flashdata('success')) ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= html_escape($this->session->flashdata('error')) ?></div>
            <?php endif; ?>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="toggleSort('id')">
                                ID <span class="table-sort-icon <?php echo $sort === 'id' ? ($order === 'asc' ? 'asc' : 'desc') : ''; ?>">▼</span>
                            </th> -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="toggleSort('first_name')">
                                Name <span class="table-sort-icon <?php echo $sort === 'first_name' ? ($order === 'asc' ? 'asc' : 'desc') : ''; ?>">▼</span>
                            </th>
                            <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="toggleSort('last_name')">
                                Last Name <span class="table-sort-icon <?php echo $sort === 'last_name' ? ($order === 'asc' ? 'asc' : 'desc') : ''; ?>">▼</span>
                            </th> -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="toggleSort('email')">
                                Email <span class="table-sort-icon <?php echo $sort === 'email' ? ($order === 'asc' ? 'asc' : 'desc') : ''; ?>">▼</span>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="toggleSort('salary')">
                                Salary <span class="table-sort-icon <?php echo $sort === 'salary' ? ($order === 'asc' ? 'asc' : 'desc') : ''; ?>">▼</span>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (empty($employees)): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No employees found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($employees as $employee): ?>
                                <tr>
                                    <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo html_escape($employee['id']); ?></td> -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo strtoupper(substr(html_escape($employee['first_name']), 0, 1)) . '. ' . html_escape($employee['last_name']); ?></td>
                                    <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo html_escape($employee['last_name']); ?></td> -->
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo html_escape($employee['email']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo html_escape($employee['phone']) ?: '-'; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rs <?php echo number_format($employee['salary'], 2); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="<?php echo site_url('employee/profile/' . $employee['id']); ?>" class="text-indigo-600 hover:text-indigo-900" title="View Profile">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="<?php echo site_url('employee/edit/' . $employee['id']); ?>" class="text-indigo-600 hover:text-indigo-900" title="Edit Employee">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <a href="<?php echo site_url('employee/delete/' . $employee['id']); ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')" title="Delete Employee">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<script>
    function toggleSort(column) {
        const currentOrder = '<?php echo html_escape($order); ?>';
        const newOrder = (currentOrder === 'asc' && column === '<?php echo html_escape($sort); ?>') ? 'desc' : 'asc';
        const params = new URLSearchParams(window.location.search);
        params.set('sort', column);
        params.set('order', newOrder);
        window.location.search = params.toString();
    }
</script>