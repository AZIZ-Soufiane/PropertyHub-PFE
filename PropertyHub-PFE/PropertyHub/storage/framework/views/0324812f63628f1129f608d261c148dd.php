<?php $__env->startSection('title', 'Users & Roles'); ?>
<?php $__env->startSection('page-title', 'Users & Roles'); ?>
<?php $__env->startSection('page-subtitle', 'Manage every account on the platform.'); ?>

<?php $__env->startSection('header-actions'); ?>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="inline-flex items-center gap-x-2 py-2.5 px-4 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-md shadow-primary-500/20 transition-all">
        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 4v16m8-8H4"/></svg>
        New user
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
    <?php
        $counts = [
            ['label' => 'All',          'value' => $users->total()],
            ['label' => 'Admins',       'value' => $users->where('role', 'admin')->count()],
            ['label' => 'Agents',       'value' => $users->where('role', 'agent')->count()],
            ['label' => 'Buyers',       'value' => $users->where('role', 'buyer')->count()],
        ];
    ?>
    <?php $__currentLoopData = $counts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-soft">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest"><?php echo e($c['label']); ?></p>
            <p class="mt-2 text-2xl font-black text-slate-800"><?php echo e(number_format($c['value'])); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="bg-white border border-slate-200 rounded-3xl shadow-soft overflow-hidden mt-2">
    <form method="GET" action="<?php echo e(route('admin.users.index')); ?>"
          class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center gap-3">
        <div class="relative flex-1 max-w-md">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search by name or email..."
                   class="w-full py-2.5 ps-11 pe-4 text-sm border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-all">
            <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                <svg class="size-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a href="<?php echo e(route('admin.users.index')); ?>"
               class="px-3 py-1.5 rounded-full text-xs font-bold transition-all <?php echo e(!request('role') ? 'bg-primary-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'); ?>">
                All
            </a>
            <?php $__currentLoopData = ['admin', 'agent', 'buyer']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('admin.users.index', array_merge(request()->all(), ['role' => $r]))); ?>"
                   class="px-3 py-1.5 rounded-full text-xs font-bold transition-all <?php echo e(request('role') === $r ? 'bg-primary-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'); ?>">
                    <?php echo e(ucfirst($r)); ?><?php echo e($r); ?>s
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <button type="submit" class="py-2.5 px-4 text-sm font-bold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition-all">
            Apply filters
        </button>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">User</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Role</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Joined</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $rmap = [
                            'admin' => 'bg-primary-100 text-primary-700',
                            'agent' => 'bg-emerald-100 text-emerald-700',
                            'buyer' => 'bg-slate-100 text-slate-600',
                        ];
                        $rpill = $rmap[$u->role] ?? 'bg-slate-100 text-slate-600';
                        $gradient = match($u->role) {
                            'admin' => 'from-primary-500 to-primary-700',
                            'agent' => 'from-emerald-500 to-emerald-700',
                            default => 'from-slate-500 to-slate-700',
                        };
                    ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full bg-gradient-to-br <?php echo e($gradient); ?> text-white flex items-center justify-center font-black text-sm shadow-sm">
                                    <?php echo e(strtoupper(substr($u->name, 0, 1))); ?>

                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800"><?php echo e($u->name); ?></p>
                                    <p class="text-xs text-slate-400"><?php echo e($u->email); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold <?php echo e($rpill); ?>">
                                <span class="size-1.5 rounded-full bg-current"></span>
                                <?php echo e(ucfirst($u->role)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-semibold text-slate-700"><?php echo e($u->created_at->format('M d, Y')); ?></p>
                            <p class="text-xs text-slate-400"><?php echo e($u->created_at->diffForHumans()); ?></p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-1">
                                <a href="<?php echo e(route('admin.users.show', $u)); ?>" class="size-8 inline-flex justify-center items-center text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all" title="View">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <a href="<?php echo e(route('admin.users.edit', $u)); ?>" class="size-8 inline-flex justify-center items-center text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <?php if($u->id !== auth()->id()): ?>
                                <form action="<?php echo e(route('admin.users.destroy', $u)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete this user?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="size-8 inline-flex justify-center items-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Delete">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($users->hasPages()): ?>
        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
            <p class="text-xs text-slate-400 font-semibold">
                Showing <?php echo e($users->firstItem()); ?> – <?php echo e($users->lastItem()); ?> of <?php echo e($users->total()); ?>

            </p>
            <div><?php echo e($users->links()); ?></div>
        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views\admin\users\index.blade.php ENDPATH**/ ?>