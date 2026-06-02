<?php $__env->startSection('title', $user->name); ?>
<?php $__env->startSection('page-title', $user->name); ?>
<?php $__env->startSection('page-subtitle', 'Account details and management.'); ?>

<?php $__env->startSection('content'); ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    
    <div class="lg:col-span-1">
        <div class="bg-white border border-slate-200 rounded-3xl shadow-soft overflow-hidden">
            <div class="grad-primary h-24 relative">
                <div class="absolute inset-0 opacity-20" style="background:radial-gradient(circle at 80% 20%, white 0%, transparent 50%);"></div>
            </div>
            <div class="px-6 pb-6 -mt-12 text-center">
                <div class="size-24 mx-auto rounded-3xl bg-white p-1.5 shadow-lg">
                    <div class="size-full rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-black text-4xl">
                        <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                    </div>
                </div>
                <h2 class="mt-4 text-xl font-black text-slate-800"><?php echo e($user->name); ?></h2>
                <p class="text-sm text-slate-400"><?php echo e($user->email); ?></p>

                <?php
                    $rmap = [
                        'admin' => 'bg-primary-100 text-primary-700',
                        'agent' => 'bg-emerald-100 text-emerald-700',
                        'buyer' => 'bg-slate-100 text-slate-600',
                    ];
                    $rpill = $rmap[$user->role] ?? 'bg-slate-100 text-slate-600';
                ?>
                <span class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold <?php echo e($rpill); ?>">
                    <span class="size-1.5 rounded-full bg-current"></span>
                    <?php echo e(ucfirst($user->role)); ?>

                </span>

                <div class="mt-5 grid grid-cols-2 gap-2 text-left">
                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-primary-600 text-white text-sm font-bold hover:bg-primary-700 shadow-md shadow-primary-500/20 transition-all">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                    <?php if($user->id !== auth()->id()): ?>
                    <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" onsubmit="return confirm('Permanently delete this user?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-rose-50 text-rose-700 text-sm font-bold hover:bg-rose-100 transition-all">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            Delete
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-slate-200 rounded-3xl shadow-soft p-6">
            <h3 class="font-black text-slate-800 mb-4">Account information</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">User ID</dt>
                    <dd class="mt-1 text-sm font-mono font-bold text-slate-800">#<?php echo e(str_pad($user->id, 4, '0', STR_PAD_LEFT)); ?></dd>
                </div>
                <div>
                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Joined</dt>
                    <dd class="mt-1 text-sm font-bold text-slate-800"><?php echo e($user->created_at->format('M d, Y · H:i')); ?></dd>
                </div>
                <div>
                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Last updated</dt>
                    <dd class="mt-1 text-sm font-bold text-slate-800"><?php echo e($user->updated_at->diffForHumans()); ?></dd>
                </div>
                <div>
                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email verified</dt>
                    <dd class="mt-1 text-sm font-bold text-slate-800">
                        <?php if($user->email_verified_at): ?>
                            <span class="inline-flex items-center gap-1.5 text-emerald-600">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                Verified
                            </span>
                        <?php else: ?>
                            <span class="text-slate-500">Not verified</span>
                        <?php endif; ?>
                    </dd>
                </div>
                <?php if($user->license_number): ?>
                <div class="sm:col-span-2">
                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">License number</dt>
                    <dd class="mt-1 text-sm font-bold text-slate-800 font-mono"><?php echo e($user->license_number); ?></dd>
                </div>
                <?php endif; ?>
            </dl>
        </div>

        <a href="<?php echo e(route('admin.users.index')); ?>" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-primary-600 transition-colors">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
            Back to all users
        </a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views\admin\users\show.blade.php ENDPATH**/ ?>