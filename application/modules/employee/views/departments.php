<!-- <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> -->
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="container mx-auto px-4 py-8 pb-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Departments Management</h1>
                <a href="<?php echo site_url('employee/masters/create_department'); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Department
                </a>
            </div>

            <!-- Search Form -->
            <form method="get" action="<?php echo site_url('employee/masters/departments'); ?>" class="flex flex-col md:flex-row gap-2 mb-4">
                <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>
                <input type="text" name="search" value="<?php echo html_escape($search); ?>" placeholder="Search by name or description..." class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Search
                </button>
                <button type="button" onclick="clearFilters()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Clear
                </button>
            </form>

            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <?php echo html_escape($this->session->flashdata('success')); ?>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <?php echo html_escape($this->session->flashdata('error')); ?>
                </div>
            <?php endif; ?>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="toggleSort('id')">
                                ID
                                <span class="table-sort-icon <?php echo $sort === 'id' ? ($order === 'asc' ? 'asc' : 'desc') : ''; ?>">▼</span>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="toggleSort('name')">
                                Name
                                <span class="table-sort-icon <?php echo $sort === 'name' ? ($order === 'asc' ? 'asc' : 'desc') : ''; ?>">▼</span>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($departments)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No departments found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($departments as $department): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo html_escape($department['id']); ?></td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo html_escape($department['name']); ?></td>
                                    <td class="px-4 py-4 text-sm text-gray-900"><?php echo html_escape($department['description']) ?: '-'; ?></td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="<?php echo site_url('employee/masters/edit_department/' . $department['id']); ?>" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <a href="<?php echo site_url('employee/masters/delete_department/' . $department['id']); ?>" class="text-red-600 hover:text-red-900" title="Delete" onclick="return confirm('Are you sure?')">
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

    function clearFilters() {
        window.location.href = '<?php echo site_url('employee/masters/departments'); ?>';
    }
</script>