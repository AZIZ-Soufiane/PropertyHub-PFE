<?php $__env->startSection('title', 'Appointments'); ?>
<?php $__env->startSection('page-title', 'Appointments'); ?>
<?php $__env->startSection('page-subtitle', 'All appointment requests across managed properties'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>


<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
    <?php
        $statItems = [
            ['label' => 'Total',     'value' => $stats['total'],     'color' => 'slate'],
            ['label' => 'Pending',   'value' => $stats['pending'],   'color' => 'amber'],
            ['label' => 'Confirmed', 'value' => $stats['confirmed'], 'color' => 'emerald'],
            ['label' => 'Completed', 'value' => $stats['completed'], 'color' => 'teal'],
            ['label' => 'Cancelled', 'value' => $stats['cancelled'], 'color' => 'red'],
            ['label' => 'Today',     'value' => $stats['today'],     'color' => 'primary'],
        ];
    ?>
    <?php $__currentLoopData = $statItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest"><?php echo e($s['label']); ?></p>
            <p class="mt-1 text-3xl font-black text-slate-800"><?php echo e($s['value']); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="bg-white border border-slate-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="<?php echo e(route('admin.appointments.index')); ?>"
               class="py-1.5 px-4 rounded-xl text-xs font-bold transition-all <?php echo e(!$status ? 'bg-primary-500 text-white shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'); ?>">
                All
            </a>
            <?php $__currentLoopData = ['pending','scheduled','confirmed','completed','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('admin.appointments.index', ['status' => $s])); ?>"
                   class="py-1.5 px-4 rounded-xl text-xs font-bold capitalize transition-all <?php echo e($status === $s ? 'bg-primary-500 text-white shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'); ?>">
                    <?php echo e($s); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Client</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Property</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Agent</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Date & Time</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $st = $appt->status;
                        $pill = match($st) {
                            'pending'   => 'bg-amber-100 text-amber-700',
                            'scheduled' => 'bg-blue-100 text-blue-700',
                            'confirmed' => 'bg-emerald-100 text-emerald-700',
                            'completed' => 'bg-teal-100 text-teal-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            default     => 'bg-slate-100 text-slate-700',
                        };
                    ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-bold text-slate-800"><?php echo e(optional($appt->client)->name ?? 'N/A'); ?></p>
                            <p class="text-xs text-slate-400"><?php echo e(optional($appt->client)->email); ?></p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            <?php echo e(optional($appt->property)->title ?? 'Deleted property'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            <?php echo e(optional($appt->agent)->name ?? '—'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                            <?php echo e($appt->date_time->format('M d, Y')); ?><br>
                            <span class="text-xs font-semibold"><?php echo e($appt->date_time->format('h:i A')); ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold <?php echo e($pill); ?> uppercase">
                                <span class="size-1.5 rounded-full bg-current"></span><?php echo e(ucfirst($st)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end gap-2">
                                <a href="<?php echo e(route('admin.appointments.show', $appt)); ?>"
                                   class="py-1.5 px-3 bg-white border border-slate-200 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-50">
                                    View
                                </a>
                                <?php if(in_array($st, ['pending', 'scheduled'])): ?>
                                    <form action="<?php echo e(route('admin.appointments.confirm', $appt)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button class="py-1.5 px-3 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold hover:bg-emerald-200">Confirm</button>
                                    </form>
                                <?php endif; ?>
                                <?php if($st === 'confirmed'): ?>
                                    <form action="<?php echo e(route('admin.appointments.complete', $appt)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button class="py-1.5 px-3 bg-teal-100 text-teal-700 rounded-lg text-xs font-bold hover:bg-teal-200">Complete</button>
                                    </form>
                                <?php endif; ?>
                                <?php if($st !== 'cancelled'): ?>
                                    <form action="<?php echo e(route('admin.appointments.cancel', $appt)); ?>" method="POST" class="inline"
                                          onsubmit="return confirm('Cancel this appointment?')">
                                        <?php echo csrf_field(); ?>
                                        <button class="py-1.5 px-3 bg-red-100 text-red-700 rounded-lg text-xs font-bold hover:bg-red-200">Cancel</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">No appointments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($appointments->hasPages()): ?>
        <div class="px-6 py-4 border-t border-slate-100">
            <?php echo e($appointments->appends(request()->query())->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/admin/appointments/index.blade.php ENDPATH**/ ?>