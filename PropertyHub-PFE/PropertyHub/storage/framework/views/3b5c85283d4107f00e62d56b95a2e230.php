<?php $__env->startSection('title', 'Appointment Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6">
    <a href="<?php echo e(route('agent.appointments.index')); ?>" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path d="m15 18-6-6 6-6" />
        </svg>
        Back to Appointments
    </a>

    <?php
        $st = $appointment->status;
        $map = [
            'pending'   => ['bg-amber-100 text-amber-700', 'bg-amber-500'],
            'scheduled' => ['bg-blue-100 text-blue-700', 'bg-blue-500'],
            'confirmed' => ['bg-emerald-100 text-emerald-700', 'bg-emerald-500'],
            'completed' => ['bg-teal-100 text-teal-700', 'bg-teal-500'],
            'cancelled' => ['bg-red-100 text-red-700', 'bg-red-500'],
        ];
        [$pill, $dot] = $map[$st] ?? ['bg-gray-100 text-gray-700', 'bg-gray-500'];
    ?>

    <div class="bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h1 class="text-lg font-bold text-gray-900">Appointment Details</h1>
            <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold uppercase <?php echo e($pill); ?>">
                <span class="size-1.5 rounded-full <?php echo e($dot); ?>"></span><?php echo e(ucfirst($st)); ?>

            </span>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-5">
                <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest">Client Information</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Name</label>
                        <p class="text-sm font-bold text-gray-800 mt-0.5"><?php echo e(optional($appointment->client)->name ?? 'Unknown'); ?></p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Email</label>
                        <p class="text-sm text-gray-600 mt-0.5"><?php echo e(optional($appointment->client)->email ?? '—'); ?></p>
                    </div>
                    <?php if(optional($appointment->client)->phone): ?>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Phone</label>
                        <p class="text-sm text-gray-600 mt-0.5"><?php echo e($appointment->client->phone); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="space-y-5">
                <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest">Property Details</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Property</label>
                        <p class="text-sm font-bold text-gray-800 mt-0.5"><?php echo e(optional($appointment->property)->title ?? 'Not specified'); ?></p>
                    </div>
                    <?php if(optional($appointment->property)->city): ?>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Location</label>
                        <p class="text-sm text-gray-600 mt-0.5"><?php echo e($appointment->property->city); ?><?php echo e($appointment->property->address ? ', ' . $appointment->property->address : ''); ?></p>
                    </div>
                    <?php endif; ?>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Price</label>
                        <p class="text-sm font-bold text-primary-600 mt-0.5"><?php echo e(optional($appointment->property)->price ? 'DH ' . number_format($appointment->property->price, 0, ',', ' ') : '—'); ?></p>
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest">Date & Time</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Scheduled Date</label>
                        <p class="text-sm font-bold text-gray-800 mt-0.5"><?php echo e($appointment->date_time->format('l, F d, Y')); ?></p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Time</label>
                        <p class="text-sm text-gray-600 mt-0.5"><?php echo e($appointment->date_time->format('h:i A')); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(in_array($appointment->status, ['pending', 'scheduled'])): ?>
    <div class="bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-900">Actions</h2>
        </div>
        <div class="p-6 flex items-center gap-3">
            <form action="<?php echo e(route('agent.appointments.confirm', $appointment)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button class="py-2.5 px-5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-colors">Accept Appointment</button>
            </form>
            <form action="<?php echo e(route('agent.appointments.cancel', $appointment)); ?>" method="POST" onsubmit="return confirm('Cancel this appointment?')">
                <?php echo csrf_field(); ?>
                <button class="py-2.5 px-5 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">Decline</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views\agent\appointments\show.blade.php ENDPATH**/ ?>