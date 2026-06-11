<?php $__env->startSection('title', 'My Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-800">Welcome back, <?php echo e(auth()->user()->name); ?></h1>
        <p class="text-sm text-gray-500 mt-1">Here's an overview of your appointments and messages.</p>
    </div>
    <a href="<?php echo e(route('properties.index')); ?>"
        class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-sm transition-all">
        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
        Browse Properties
    </a>
</div>


<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Total Appointments</p>
        <h3 class="text-3xl font-black text-gray-800"><?php echo e($stats['total']); ?></h3>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Pending</p>
        <div class="flex items-center gap-x-2">
            <h3 class="text-3xl font-black text-gray-800"><?php echo e($stats['pending']); ?></h3>
            <span class="text-xs font-bold py-1 px-2 bg-amber-100 text-amber-700 rounded-lg">Awaiting</span>
        </div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Confirmed</p>
        <div class="flex items-center gap-x-2">
            <h3 class="text-3xl font-black text-gray-800"><?php echo e($stats['confirmed']); ?></h3>
            <span class="text-xs font-bold py-1 px-2 bg-emerald-100 text-emerald-800 rounded-lg">Confirmed</span>
        </div>
    </div>
    <a href="<?php echo e(route('buyer.favorites.index')); ?>" class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5 hover:border-rose-200 hover:bg-rose-50/30 transition-all group">
        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2 group-hover:text-rose-400 transition-colors">Saved Properties</p>
        <div class="flex items-center gap-x-2">
            <h3 class="text-3xl font-black text-gray-800"><?php echo e($stats['favorites']); ?></h3>
            <svg class="size-5 text-rose-400" fill="currentColor" viewBox="0 0 24 24"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
        </div>
    </a>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">My Appointments</h2>
            <a href="<?php echo e(route('buyer.appointments.index')); ?>" class="text-sm font-semibold text-primary-600 hover:text-primary-700">View All</a>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $statusColors = [
                    'pending'   => 'bg-amber-100 text-amber-800',
                    'confirmed' => 'bg-emerald-100 text-emerald-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                    'scheduled' => 'bg-blue-100 text-blue-800',
                ];
                $statusColor = $statusColors[$appt->status] ?? 'bg-gray-100 text-gray-800';
            ?>
            <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5 hover:border-primary-300 transition-all">
                <div class="flex justify-between items-start mb-3">
                    <div class="space-y-1">
                        <h3 class="font-bold text-gray-800"><?php echo e($appt->date_time->format('D, M d, Y')); ?></h3>
                        <p class="text-sm text-gray-500"><?php echo e($appt->date_time->format('H:i')); ?></p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-bold <?php echo e($statusColor); ?>"><?php echo e(ucfirst($appt->status)); ?></span>
                </div>
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-sm font-bold text-gray-800"><?php echo e(optional($appt->property)->title ?? 'Property deleted'); ?></p>
                    <?php if($appt->agent): ?>
                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                            <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Agent: <?php echo e($appt->agent->name); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center text-sm text-gray-500">
                No appointments yet. <a href="<?php echo e(route('properties.index')); ?>" class="text-primary-600 font-semibold">Browse properties</a> to book one.
            </div>
        <?php endif; ?>
    </div>

    
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Recent Messages</h2>
            <a href="<?php echo e(route('buyer.messages.index')); ?>" class="text-sm font-semibold text-primary-600 hover:text-primary-700">Open Inbox</a>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $recentMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php 
                        $contact = $msg->contact;
                        $latest = $msg->latest_message;
                    ?>
                    <a href="<?php echo e(route('buyer.messages.show', $contact)); ?>"
                        class="flex items-center gap-x-4 p-4 hover:bg-gray-50 transition-colors group">
                        <div class="size-11 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold flex-shrink-0 group-hover:ring-2 ring-primary-500/50 transition-all">
                            <?php echo e(strtoupper(substr($contact->name ?? '?', 0, 1))); ?>

                        </div>
                        <div class="grow min-w-0">
                            <div class="flex justify-between items-center mb-0.5">
                                <h4 class="text-sm font-bold text-gray-800 truncate"><?php echo e($contact->name ?? 'Unknown'); ?></h4>
                                <span class="text-[10px] font-medium text-gray-400 uppercase flex-shrink-0"><?php echo e($latest ? $latest->created_at->diffForHumans(null, true) : ''); ?></span>
                            </div>
                            <p class="text-xs text-gray-500 truncate"><?php echo e($latest->content ?? 'No messages yet.'); ?></p>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-8 text-center text-sm text-gray-500">No messages yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.buyer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/buyer/dashboard.blade.php ENDPATH**/ ?>