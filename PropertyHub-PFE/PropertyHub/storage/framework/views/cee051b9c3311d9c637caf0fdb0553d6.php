<?php
$stats = $stats ?? [];
$user = Auth::user();
?>

<section class="lg:ps-64">
    <header class="sticky top-0 z-40 bg-white border-b border-gray-200 py-4 px-6 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-gray-800">Agent Dashboard</h1>
            <p class="text-xs text-gray-400 font-semibold">Welcome back, <?php echo e($user->name); ?></p>
        </div>
        <div class="flex items-center gap-4">
            <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm">
                <?php echo e(substr($user->name, 0, 1)); ?>

            </div>
        </div>
    </header>
</section>
<?php echo $__env->make('layouts.agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views\layouts\agent-header.blade.php ENDPATH**/ ?>