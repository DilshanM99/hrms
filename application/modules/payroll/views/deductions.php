<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="container mx-auto px-4 py-8 pb-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Deductions Management</h1>
                <a href="<?= site_url('payroll/create_deduction') ?>"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Deduction
                </a>
            </div>

            <!-- Search Form -->
            <form method="get" action="<?php echo site_url('payroll/deductions'); ?>"
                class="flex flex-col md:flex-row gap-2 mb-4">
                <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>
                <input type="text" name="search" value="<?php echo html_escape($search); ?>"
                    placeholder="Search by name or description..."
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center">
                    <!-- <i data-feather="search" class="w-4 h-4 mr-1"></i> -->
                    Search
                </button>
                <button type="button" onclick="clearFilters()"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 flex items-center">
                    <!-- <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> -->
                    Clear
                </button>
            </form>

            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
                    <i data-feather="check-circle" class="w-4 h-4 mr-2"></i>
                    <?php echo html_escape($this->session->flashdata('success')); ?>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
                    <i data-feather="alert-triangle" class="w-4 h-4 mr-2"></i>
                    <?php echo html_escape($this->session->flashdata('error')); ?>
                </div>
            <?php endif; ?>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <!-- <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="toggleSort('id')">
                            ID
                            <span class="ml-1">
                                <?php if ($sort === 'id'): ?>
                                    <i data-feather="<?php echo $order === 'asc' ? 'chevron-up' : 'chevron-down'; ?>" class="w-4 h-4 inline"></i>
                                <?php endif; ?>
                            </span>
                        </th> -->
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                onclick="toggleSort('name')">
                                Name
                                <span
                                    class="table-sort-icon <?php echo $sort === 'first_name' ? ($order === 'asc' ? 'asc' : 'desc') : ''; ?>">▼</span>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($deductions)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No deductions found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($deductions as $deduction): ?>
                                <tr class="hover:bg-gray-50">
                                    <!-- <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo html_escape($deduction['id']); ?></td> -->
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo html_escape($deduction['name']); ?>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo ucfirst($deduction['type']); ?>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        $<?php echo number_format($deduction['amount'], 2); ?></td>
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        <?php echo html_escape($deduction['description']) ?: '-'; ?>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="<?php echo site_url('payroll/edit_deduction/' . $deduction['id']); ?>"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            <!-- <i data-feather="edit-3" class="w-4 h-4 mr-1"></i> -->
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="<?php echo site_url('payroll/delete_deduction/' . $deduction['id']); ?>"
                                            class="text-red-600 hover:text-red-900 "
                                            onclick="return confirm('Are you sure?')">
                                            <!-- <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> -->
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>

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