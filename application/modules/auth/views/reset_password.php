<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Reset Password</h2>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="bg-green-500 text-white p-2 rounded mb-4"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="bg-red-500 text-white p-2 rounded mb-4"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <?php echo form_open('auth/reset_post', ['class' => 'space-y-4']); ?>
            <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full p-2 border rounded" required>
                <?php echo form_error('password', '<div class="text-red-500 text-sm mt-1">', '</div>'); ?>
            </div>
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="mt-1 block w-full p-2 border rounded" required>
                <?php echo form_error('confirm_password', '<div class="text-red-500 text-sm mt-1">', '</div>'); ?>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Reset Password</button>
        <?php echo form_close(); ?>
        <p class="mt-4 text-center"><a href="<?php echo site_url('auth'); ?>" class="text-blue-500 hover:underline">Back to Login</a></p>
    </div>
</body>
</html>