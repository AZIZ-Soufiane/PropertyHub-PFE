<?php $__env->startSection('title', 'Users & Roles'); ?>
<?php $__env->startSection('page-title', 'Users & Roles'); ?>
<?php $__env->startSection('page-subtitle', 'Manage every account on the platform.'); ?>


<?php $__env->startSection('content'); ?>
<?php
    $errorEditId = $errors->any() ? old('user_id') : null;
    $editErrorData = $errorEditId ? [
        'id' => (int) old('user_id'),
        'name' => old('name', ''),
        'email' => old('email', ''),
        'role' => old('role', ''),
        'license_number' => old('license_number', ''),
    ] : null;
?>
<div x-data="userManager(<?php echo e($errors->any() && !old('user_id') ? 'true' : 'false'); ?>, <?php echo e($editErrorData ? 'true' : 'false'); ?>, <?php echo e($editErrorData ? json_encode($editErrorData) : 'null'); ?>)" @open-create-user.window="showCreateModal = true">


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
                    <?php echo e(ucfirst($r)); ?>s
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <button type="submit" class="py-2.5 px-4 text-sm font-bold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition-all">
            Apply filters
        </button>

        <button type="button" @click="$dispatch('open-create-user')" class="md:ms-auto inline-flex items-center gap-x-2 py-2.5 px-4 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-md shadow-primary-500/20 transition-all">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 4v16m8-8H4"/></svg>
            New user
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
                                <button type="button" @click="viewUser = JSON.parse($el.getAttribute('data-user')); showViewModal = true" data-user='<?php echo e(json_encode([
                                    'id' => $u->id,
                                    'name'  => $u->name,
                                    'email' => $u->email,
                                    'role'  => $u->role,
                                    'initial' => strtoupper(substr($u->name, 0, 1)),
                                    'created_at'     => $u->created_at->format('M d, Y · H:i'),
                                    'updated_at'     => $u->updated_at->diffForHumans(),
                                    'email_verified' => $u->email_verified_at ? true : false,
                                    'license_number' => $u->license_number ?? '',
                                ])); ?>' class="size-8 inline-flex justify-center items-center text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all" title="View">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <button type="button" @click="editUser = JSON.parse($el.getAttribute('data-edit-user')); showEditModal = true" data-edit-user='<?php echo e(json_encode([
                                    'id' => $u->id,
                                    'name'  => $u->name,
                                    'email' => $u->email,
                                    'role'  => $u->role,
                                    'license_number' => $u->license_number ?? '',
                                ])); ?>' class="size-8 inline-flex justify-center items-center text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
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


<div x-show="showViewModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showViewModal = false" x-show="showViewModal" x-transition.opacity></div>
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0 lg:ps-64">
        <div x-show="showViewModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all w-full sm:my-8 sm:max-w-lg">
            <div class="flex justify-between items-center py-4 px-6 border-b border-slate-100 bg-white">
                <h3 class="font-black text-slate-800 text-xl">User Details</h3>
                <button type="button" @click="showViewModal = false" class="size-10 inline-flex justify-center items-center rounded-xl text-slate-400 hover:bg-slate-100 transition-all"><svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M18 6 6 18M6 6l12 12" /></svg></button>
            </div>
            <div class="p-8 overflow-y-auto max-h-[70vh] bg-white">
                <template x-if="viewUser">
                    <div>
                        <div class="text-center">
                            <div class="size-20 mx-auto rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-black text-3xl shadow-lg" x-text="viewUser.initial"></div>
                            <h2 class="mt-4 text-xl font-black text-slate-800" x-text="viewUser.name"></h2>
                            <p class="text-sm text-slate-400" x-text="viewUser.email"></p>
                            <span class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold"
                                  :class="viewUser.role === 'admin' ? 'bg-primary-100 text-primary-700' : viewUser.role === 'agent' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600'">
                                <span class="size-1.5 rounded-full bg-current"></span>
                                <span x-text="viewUser.role.charAt(0).toUpperCase() + viewUser.role.slice(1)"></span>
                            </span>
                        </div>
                        <div class="mt-8 border-t border-slate-100 pt-6">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                <div>
                                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">User ID</dt>
                                    <dd class="mt-1 text-sm font-mono font-bold text-slate-800" x-text="'#' + String(viewUser.id).padStart(4, '0')"></dd>
                                </div>
                                <div>
                                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Joined</dt>
                                    <dd class="mt-1 text-sm font-bold text-slate-800" x-text="viewUser.created_at"></dd>
                                </div>
                                <div>
                                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Last updated</dt>
                                    <dd class="mt-1 text-sm font-bold text-slate-800" x-text="viewUser.updated_at"></dd>
                                </div>
                                <div>
                                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email verified</dt>
                                    <dd class="mt-1 text-sm font-bold text-slate-800">
                                        <span x-show="viewUser.email_verified" class="inline-flex items-center gap-1.5 text-emerald-600">
                                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                            Verified
                                        </span>
                                        <span x-show="!viewUser.email_verified" class="text-slate-500">Not verified</span>
                                    </dd>
                                </div>
                                <div x-show="viewUser.license_number" class="sm:col-span-2">
                                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">License number</dt>
                                    <dd class="mt-1 text-sm font-bold text-slate-800 font-mono" x-text="viewUser.license_number"></dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </template>
            </div>
            <div class="bg-slate-50/50 flex justify-end gap-3 py-4 px-6 border-t border-slate-100">
                <button type="button" @click="showViewModal = false" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50">Close</button>
            </div>
        </div>
    </div>
</div>


<div x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showCreateModal = false" x-show="showCreateModal" x-transition.opacity></div>
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0 lg:ps-64">
        <div x-show="showCreateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all w-full sm:my-8 sm:max-w-lg">
            <div class="flex justify-between items-center py-4 px-6 border-b border-slate-100 bg-white">
                <h3 class="font-black text-slate-800 text-xl">New User</h3>
                <button type="button" @click="showCreateModal = false" class="size-10 inline-flex justify-center items-center rounded-xl text-slate-400 hover:bg-slate-100 transition-all"><svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M18 6 6 18M6 6l12 12" /></svg></button>
            </div>
            <form action="<?php echo e(route('admin.users.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="p-8 overflow-y-auto max-h-[70vh] bg-white space-y-6">
                    <?php if(!old('user_id') && $errors->any()): ?>
                        <div class="p-4 rounded-xl bg-rose-50 text-rose-700 text-sm font-semibold">
                            <ul class="list-disc list-inside"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($err); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                        </div>
                    <?php endif; ?>
                    <div class="space-y-4">
                        <div>
                            <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Full name *</label>
                            <input type="text" name="name" value="<?php echo e(old('name')); ?>" required class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none">
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Email *</label>
                            <input type="email" name="email" value="<?php echo e(old('email')); ?>" required class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none">
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Password *</label>
                            <input type="password" name="password" required minlength="8" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none">
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Confirm password *</label>
                            <input type="password" name="password_confirmation" required class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none">
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Role *</label>
                            <select name="role" required class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none">
                                <option value="agent" <?php if(old('role') === 'agent'): echo 'selected'; endif; ?>>Agent</option>
                                <option value="admin" <?php if(old('role') === 'admin'): echo 'selected'; endif; ?>>Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">License # (agents)</label>
                            <input type="text" name="license_number" value="<?php echo e(old('license_number')); ?>" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none">
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50/50 flex justify-end gap-3 py-4 px-6 border-t border-slate-100">
                    <button type="button" @click="showCreateModal = false" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50">Cancel</button>
                    <button type="submit" class="py-2.5 px-5 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-sm">Create user</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showEditModal = false" x-show="showEditModal" x-transition.opacity></div>
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0 lg:ps-64">
        <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all w-full sm:my-8 sm:max-w-lg">
            <div class="flex justify-between items-center py-4 px-6 border-b border-slate-100 bg-white">
                <h3 class="font-black text-slate-800 text-xl">Edit User</h3>
                <button type="button" @click="showEditModal = false" class="size-10 inline-flex justify-center items-center rounded-xl text-slate-400 hover:bg-slate-100 transition-all"><svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M18 6 6 18M6 6l12 12" /></svg></button>
            </div>
            <template x-if="editUser">
                <form :action="'/admin/users/' + editUser.id" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="user_id" :value="editUser.id">
                    <div class="p-8 overflow-y-auto max-h-[70vh] bg-white space-y-6">
                        <?php if($errors->any() && old('user_id')): ?>
                            <div class="p-4 rounded-xl bg-rose-50 text-rose-700 text-sm font-semibold">
                                <ul class="list-disc list-inside"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($err); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                            </div>
                        <?php endif; ?>
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Full name *</label>
                                <input type="text" name="name" x-model="editUser.name" required class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none">
                            </div>
                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Email *</label>
                                <input type="email" name="email" x-model="editUser.email" required class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none">
                            </div>
                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Password (Optional)</label>
                                <input type="password" name="password" minlength="8" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none">
                            </div>
                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Confirm password</label>
                                <input type="password" name="password_confirmation" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none">
                            </div>
                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Role *</label>
                                <select name="role" x-model="editUser.role" required class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none">
                                    <option value="agent">Agent</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">License # (agents)</label>
                                <input type="text" name="license_number" x-model="editUser.license_number" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none">
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50/50 flex justify-end gap-3 py-4 px-6 border-t border-slate-100">
                        <button type="button" @click="showEditModal = false" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="py-2.5 px-5 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-sm">Save Changes</button>
                    </div>
                </form>
            </template>
        </div>
    </div>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/admin/users/index.blade.php ENDPATH**/ ?>