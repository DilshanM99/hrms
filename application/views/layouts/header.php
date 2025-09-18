<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS - <?php echo isset($title) ? $title : 'Dashboard'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/heroicons@2.0.18/24/outline/js/heroicons.js"></script> <!-- Heroicons for icons -->
    <style>
        /* Custom styles for modern look */
        .sidebar { transition: width 0.3s ease; }
        .widget { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-radius: 0.5rem; }
        .table-sort-icon { display: inline-block; margin-left: 0.25rem; transition: transform 0.2s; }
        .table-sort-icon.asc { transform: rotate(0deg); }
        .table-sort-icon.desc { transform: rotate(180deg); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex pb-10">
    
    