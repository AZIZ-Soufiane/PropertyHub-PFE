<?php $__env->startSection('title', 'Messages'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-800">My Messages</h1>
        <p class="text-sm text-gray-500 mt-1">Conversations with agents.</p>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
    <div class="divide-y divide-gray-100">
        <?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $contact = $msg->sender_id === auth()->id() ? $msg->receiver : $msg->sender; ?>
            <a href="<?php echo e(route('buyer.messages.show', $contact)); ?>"
                class="flex items-center gap-x-4 p-5 hover:bg-gray-50 transition-colors group">
                <div class="size-12 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold flex-shrink-0 group-hover:ring-2 ring-primary-500/50 transition-all">
                    <?php echo e(strtoupper(substr($contact->name ?? '?', 0, 1))); ?>

                </div>
                <div class="grow min-w-0">
                    <div class="flex justify-between items-center mb-1">
                        <h4 class="text-sm font-bold text-gray-800 truncate"><?php echo e($contact->name ?? 'Unknown'); ?></h4>
                        <span class="text-[10px] font-medium text-gray-400 uppercase flex-shrink-0"><?php echo e($msg->created_at->diffForHumans(null, true)); ?></span>
                    </div>
                    <p class="text-xs text-gray-500 truncate">
                        <?php if($msg->sender_id === auth()->id()): ?> <span class="text-gray-400">You:</span> <?php endif; ?>
                        <?php echo e($msg->content); ?>

                    </p>
                </div>
                <svg class="size-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-12 text-center">
                <svg class="size-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <p class="text-sm font-medium text-gray-500">No conversations yet.</p>
                <p class="text-xs text-gray-400 mt-1">Book an appointment and message the agent directly.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.buyer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/buyer/messages/index.blade.php ENDPATH**/ ?>