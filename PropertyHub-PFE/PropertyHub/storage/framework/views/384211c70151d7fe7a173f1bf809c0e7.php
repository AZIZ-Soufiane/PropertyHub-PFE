<?php $__env->startSection('title', isset($user) && $user->exists ? 'Edit User' : 'New User'); ?>
<?php $__env->startSection('page-title', isset($user) && $user->exists ? 'Edit user' : 'Create new user'); ?>
<?php $__env->startSection('page-subtitle', isset($user) && $user->exists ? 'Update account information and permissions.' : 'Add a new member to the platform.'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $isEdit = isset($user) && $user->exists;
    $action = $isEdit ? route('admin.users.update', $user) : route('admin.users.store');
    $cur = old('role', $user->role ?? 'buyer');
?>

<form action="<?php echo e($action); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php if($isEdit): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        
        <div class="lg:col-span-2 space-y-6">

            <?php if($errors->any()): ?>
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm font-semibold">
                    <ul class="list-disc list-inside space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="bg-white border border-slate-200 rounded-3xl shadow-soft p-6">
                <div class="flex items-center gap-3 mb-5">
                    <span class="size-10 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                    <div>
                        <h3 class="font-black text-slate-800">Profile</h3>
                        <p class="text-xs text-slate-400">Basic identity information.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-xs font-bold text-slate-700 uppercase tracking-wide">Full name *</label>
                        <input type="text" name="name" value="<?php echo e(old('name', $user->name ?? '')); ?>" required
                               class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-all"
                               placeholder="e.g. John Doe">
                    </div>
                    <div>
                        <label class="block mb-2 text-xs font-bold text-slate-700 uppercase tracking-wide">Email *</label>
                        <input type="email" name="email" value="<?php echo e(old('email', $user->email ?? '')); ?>" required
                               class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-all"
                               placeholder="john@example.com">
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-3xl shadow-soft p-6">
                <div class="flex items-center gap-3 mb-5">
                    <span class="size-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <div>
                        <h3 class="font-black text-slate-800">Credentials</h3>
                        <p class="text-xs text-slate-400"><?php echo e($isEdit ? 'Leave blank to keep current password.' : 'Choose a strong password.'); ?></p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-xs font-bold text-slate-700 uppercase tracking-wide">Password <?php echo e($isEdit ? '(optional)' : '*'); ?></label>
                        <input type="password" name="password" <?php echo e($isEdit ? '' : 'required'); ?> minlength="8"
                               class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block mb-2 text-xs font-bold text-slate-700 uppercase tracking-wide">Confirm password</label>
                        <input type="password" name="password_confirmation" <?php echo e($isEdit ? '' : 'required'); ?>

                               class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-all">
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-3xl shadow-soft p-6">
                <div class="flex items-center gap-3 mb-5">
                    <span class="size-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </span>
                    <div>
                        <h3 class="font-black text-slate-800">Role &amp; permissions</h3>
                        <p class="text-xs text-slate-400">What this account is allowed to do.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-xs font-bold text-slate-700 uppercase tracking-wide">Role *</label>
                        <select name="role" required
                                class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-all">
                            <option value="buyer"  <?php if($cur === 'buyer'): echo 'selected'; endif; ?>>Buyer</option>
                            <option value="agent"  <?php if($cur === 'agent'): echo 'selected'; endif; ?>>Agent</option>
                            <option value="admin"  <?php if($cur === 'admin'): echo 'selected'; endif; ?>>Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-xs font-bold text-slate-700 uppercase tracking-wide">License # <span class="text-slate-400 font-normal">(agents)</span></label>
                        <input type="text" name="license_number" value="<?php echo e(old('license_number', $user->license_number ?? '')); ?>"
                               class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-all"
                               placeholder="e.g. AG-12345">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="<?php echo e(route('admin.users.index')); ?>" class="py-3 px-6 text-sm font-bold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition-all">Cancel</a>
                <button type="submit" class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-md shadow-primary-500/20 transition-all">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <?php echo e($isEdit ? 'Save changes' : 'Create user'); ?>

                </button>
            </div>
        </div>

        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 border border-primary-200 rounded-3xl p-6">
                <div class="size-12 rounded-2xl grad-primary flex items-center justify-center text-white shadow-lg shadow-primary-500/20">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3 class="mt-4 font-black text-slate-800">Role permissions</h3>
                <p class="text-xs text-slate-500 mt-1">A quick reminder of what each role can do.</p>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li class="flex items-start gap-2">
                        <span class="size-5 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-[10px] font-black mt-0.5">B</span>
                        <div>
                            <p class="font-bold text-slate-800">Buyer</p>
                            <p class="text-xs text-slate-500">Browse, favorite, book viewings.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="size-5 rounded-full bg-emerald-200 text-emerald-700 flex items-center justify-center text-[10px] font-black mt-0.5">A</span>
                        <div>
                            <p class="font-bold text-slate-800">Agent</p>
                            <p class="text-xs text-slate-500">Manage own listings &amp; appointments.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="size-5 rounded-full bg-primary-200 text-primary-700 flex items-center justify-center text-[10px] font-black mt-0.5">★</span>
                        <div>
                            <p class="font-bold text-slate-800">Admin</p>
                            <p class="text-xs text-slate-500">Full access incl. user management.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-primary-600 transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                Back to all users
            </a>
        </div>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/admin/users/create.blade.php ENDPATH**/ ?>