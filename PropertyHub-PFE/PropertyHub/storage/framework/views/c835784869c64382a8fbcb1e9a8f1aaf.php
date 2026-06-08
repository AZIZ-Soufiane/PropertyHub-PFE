<?php $__env->startSection('title', 'Appointments'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex-1 flex items-center gap-3 w-full">
            <div class="relative flex-1 max-w-sm">
                <input type="text"
                    class="py-2.5 px-4 ps-11 block w-full border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all border"
                    placeholder="Search appointments...">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                    <svg class="size-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="m21 21-4.3-4.3" />
                        <circle cx="10" cy="10" r="7" />
                    </svg>
                </div>
            </div>
            <select class="py-2.5 ps-4 pe-9 flex text-nowrap w-48 cursor-pointer bg-white border border-gray-200 text-gray-800 rounded-xl text-start text-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Client</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Property</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date & Time</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $st = $appt->status;
                        $map = [
                            'pending'   => 'bg-amber-100 text-amber-700',
                            'scheduled' => 'bg-blue-100 text-blue-700',
                            'confirmed' => 'bg-emerald-100 text-emerald-700',
                            'completed' => 'bg-teal-100 text-teal-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                        ];
                        $pill = $map[$st] ?? 'bg-gray-100 text-gray-700';
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800"><?php echo e(optional($appt->client)->name ?? 'Unknown'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e(optional($appt->property)->title ?? 'Deleted property'); ?><?php echo e(optional($appt->property)->city ? ', ' . optional($appt->property)->city : ''); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                            <?php echo e($appt->date_time->format('M d, Y')); ?> - <?php echo e($appt->date_time->format('h:i A')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold <?php echo e($pill); ?> uppercase">
                                <span class="size-1.5 rounded-full bg-current"></span><?php echo e(ucfirst($st)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end gap-2">
                                <a href="<?php echo e(route('agent.appointments.show', $appt)); ?>"
                                    class="py-1.5 px-3 bg-white border border-gray-200 text-gray-600 rounded-lg text-xs font-bold hover:bg-gray-50">Review</a>
                                <?php if(in_array($appt->status, ['pending', 'scheduled'])): ?>
                                    <form action="<?php echo e(route('agent.appointments.confirm', $appt)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button class="py-1.5 px-3 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold hover:bg-emerald-200">Accept</button>
                                    </form>
                                <?php endif; ?>
                                <?php if($appt->status !== 'cancelled'): ?>
                                    <form action="<?php echo e(route('agent.appointments.cancel', $appt)); ?>" method="POST" class="inline" onsubmit="return confirm('Cancel this appointment?')">
                                        <?php echo csrf_field(); ?>
                                        <button class="py-1.5 px-3 bg-red-100 text-red-700 rounded-lg text-xs font-bold hover:bg-red-200">Decline</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">No appointments yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<div class="mt-8 bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-sm font-black text-gray-700 uppercase tracking-widest">Calendar</h3>
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('agent.appointments.index', ['year' => $calendar['prevMonth']->year, 'month' => $calendar['prevMonth']->month])); ?>"
               class="size-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <span class="text-sm font-bold text-gray-700 min-w-[140px] text-center"><?php echo e($calendar['monthName']); ?> <?php echo e($calendar['year']); ?></span>
            <a href="<?php echo e(route('agent.appointments.index', ['year' => $calendar['nextMonth']->year, 'month' => $calendar['nextMonth']->month])); ?>"
               class="size-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-7 mb-2">
            <?php $__currentLoopData = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="text-center text-[10px] font-black text-gray-400 uppercase tracking-widest py-1"><?php echo e($d); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="grid grid-cols-7">
            <?php
                $totalCells = $calendar['startDow'] + $calendar['daysInMonth'];
                $totalCells = ceil($totalCells / 7) * 7;
            ?>
            <?php for($i = 0; $i < $totalCells; $i++): ?>
                <?php
                    $cellDay = $i - $calendar['startDow'] + 1;
                    $isValid = $cellDay >= 1 && $cellDay <= $calendar['daysInMonth'];
                    $dateKey = $isValid ? sprintf('%04d-%02d-%02d', $calendar['year'], $calendar['month'], $cellDay) : null;
                    $hasAppts = $dateKey && isset($calendar['appointments'][$dateKey]);
                    $apptCount = $hasAppts ? $calendar['appointments'][$dateKey]->count() : 0;
                    $isToday = $isValid && $dateKey === now()->format('Y-m-d');
                    $isSelected = $isValid && $dateKey === $calDate;
                ?>
                <div class="aspect-square p-1">
                    <?php if($isValid): ?>
                        <a href="<?php echo e(route('agent.appointments.index', ['year' => $calendar['year'], 'month' => $calendar['month'], 'cal_date' => $dateKey])); ?>"
                           class="size-full rounded-xl flex flex-col items-center justify-center text-sm transition-all
                                  <?php echo e($isSelected ? 'ring-2 ring-primary-500 bg-primary-100 text-primary-800 font-bold' : ''); ?>

                                  <?php echo e(!$isSelected && $isToday ? 'ring-2 ring-primary-300' : ''); ?>

                                  <?php echo e($hasAppts ? 'bg-primary-50 text-primary-700 font-bold hover:bg-primary-100' : 'text-gray-500 hover:bg-gray-50'); ?>">
                            <span><?php echo e($cellDay); ?></span>
                            <?php if($apptCount > 0): ?>
                                <span class="text-[9px] font-bold text-primary-500 -mt-0.5"><?php echo e($apptCount); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php else: ?>
                        <div class="size-full"></div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>

        
        <?php if($calDate): ?>
            <div class="mt-6 border-t border-gray-100 pt-4">
                <h4 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-3">Appointments for <?php echo e($calDate); ?></h4>
                <?php $__empty_1 = true; $__currentLoopData = $selectedDateAppts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between py-3 px-4 rounded-xl hover:bg-gray-50 transition-colors border border-gray-100 mb-2">
                        <div class="flex items-start gap-4">
                            <div class="text-center min-w-[60px]">
                                <p class="text-sm font-black text-gray-700"><?php echo e($appt->date_time->format('h:i A')); ?></p>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800"><?php echo e(optional($appt->client)->name ?? 'N/A'); ?></p>
                                <p class="text-xs text-gray-400"><?php echo e(optional($appt->client)->email ?? ''); ?></p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <?php echo e(optional($appt->property)->title ?? 'Deleted'); ?>

                                    <?php if(optional($appt->property)->city): ?> — <?php echo e($appt->property->city); ?> <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="py-0.5 px-2 rounded-full text-[9px] font-bold uppercase whitespace-nowrap
                                <?php echo e(match($appt->status) {
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'scheduled' => 'bg-blue-100 text-blue-700',
                                    'confirmed' => 'bg-emerald-100 text-emerald-700',
                                    'completed' => 'bg-teal-100 text-teal-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                }); ?>"><?php echo e($appt->status); ?></span>
                            <a href="<?php echo e(route('agent.appointments.show', $appt)); ?>"
                               class="text-xs font-bold text-primary-500 hover:text-primary-600 transition-colors whitespace-nowrap">View Details</a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-400 py-2">No appointments this day.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/agent/appointments/index.blade.php ENDPATH**/ ?>