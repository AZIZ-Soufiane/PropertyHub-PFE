<?php $__env->startSection('title', 'Categories'); ?>
<?php $__env->startSection('page-title', 'Categories'); ?>
<?php $__env->startSection('page-subtitle', 'Manage property types and categories'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="categoryManager()">

    
    <?php if(session('success')): ?>
        <div class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-slate-500 font-semibold"><?php echo e($categories->count()); ?> categories</p>
        <button type="button" @click="openCreateModal()"
                class="py-2.5 px-5 bg-primary-500 text-white rounded-xl font-bold text-sm shadow-sm hover:bg-primary-600 whitespace-nowrap transition-all">
            + Add Category
        </button>
    </div>

    
    <div class="bg-white border border-slate-200 shadow-sm rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/60">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Name</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Slug</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-bold text-slate-800"><?php echo e($category->name); ?></p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <code class="text-xs text-slate-400 font-mono bg-slate-100 px-2 py-1 rounded-lg"><?php echo e($category->slug); ?></code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($category->is_active): ?>
                                    <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase">
                                        <span class="size-1.5 rounded-full bg-emerald-500"></span>Active
                                    </span>
                                <?php else: ?>
                                    <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 uppercase">
                                        <span class="size-1.5 rounded-full bg-slate-400"></span>Inactive
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <button type="button" @click="openEditModal(<?php echo e($category->id); ?>, '<?php echo e(addslashes($category->name)); ?>', <?php echo e($category->is_active ? 'true' : 'false'); ?>)"
                                            class="size-8 inline-flex justify-center items-center text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-all"
                                            title="Edit">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </button>
                                    <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button"
                                                @click="$store.confirm.ask('Delete category &quot;<?php echo e($category->name); ?>&quot;? Properties using it will keep their current type.', $el.closest('form'))"
                                                class="size-8 inline-flex justify-center items-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all"
                                                title="Delete">
                                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">No categories yet. Create one to get started.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showModal = false" x-show="showModal" x-transition.opacity></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0 lg:ps-64">
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all w-full sm:my-8 sm:max-w-lg font-sans">

                <div class="flex justify-between items-center py-4 px-6 border-b border-slate-100 bg-white">
                    <h3 class="font-black text-slate-800 text-xl" x-text="editing ? 'Edit Category' : 'New Category'"></h3>
                    <button type="button" @click="showModal = false"
                            class="size-10 inline-flex justify-center items-center rounded-xl text-slate-400 hover:bg-slate-100 transition-all">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M18 6 6 18M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form :action="editing ? `/admin/categories/${editId}` : '<?php echo e(route('admin.categories.store')); ?>'"
                      method="POST" class="bg-white">
                    <?php echo csrf_field(); ?>
                    <template x-if="editing">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Category Name</label>
                            <input type="text" name="name" x-model="formName" required
                                   class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all"
                                   placeholder="e.g. Commercial, Townhouse">
                        </div>
                        <template x-if="editing">
                            <div>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" x-model="formActive"
                                           class="size-4 rounded border-slate-300 text-primary-500 focus:ring-primary-500">
                                    <span class="text-sm font-bold text-slate-700">Active</span>
                                </label>
                            </div>
                        </template>
                    </div>
                    <div class="bg-slate-50/50 flex justify-end items-center gap-x-3 py-5 px-8 border-t border-slate-100">
                        <button type="button" @click="showModal = false"
                                class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-slate-200 bg-white text-slate-800 hover:bg-slate-50 transition-all">Cancel</button>
                        <button type="submit"
                                class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-primary-500 text-white hover:bg-primary-600 transition-all shadow-xl shadow-primary-500/20"
                                x-text="editing ? 'Update Category' : 'Create Category'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>