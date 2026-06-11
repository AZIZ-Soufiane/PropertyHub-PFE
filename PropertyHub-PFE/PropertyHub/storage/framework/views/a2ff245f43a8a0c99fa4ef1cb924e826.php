<?php $__env->startSection('title', 'My Properties'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="propertyManager(<?php echo e(!old('_method') && $errors->any() ? 'true' : 'false'); ?>)" class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex-1 flex items-center gap-3 w-full">
            <div class="relative flex-1 max-w-sm">
                <input type="text"
                    class="py-2.5 px-4 ps-11 block w-full border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all border"
                    placeholder="Search your properties...">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                    <svg class="size-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="m21 21-4.3-4.3" />
                        <circle cx="10" cy="10" r="7" />
                    </svg>
                </div>
            </div>
            <select class="py-2.5 ps-4 pe-9 flex text-nowrap w-48 cursor-pointer bg-white border border-gray-200 text-gray-800 rounded-xl text-start text-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                <option value="">All Status</option>
                <option value="approved">Published</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        <button type="button" @click="showCreateModal = true"
            class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-sm transition-all whitespace-nowrap">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path d="M12 4v16m8-8H4" />
            </svg>
            Add New Property
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/60">
                <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Property</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Type</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Price</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $statusName = optional($property->statusRelation)->name ?? 'pending';
                        $pillMap = [
                            'approved' => 'bg-emerald-100 text-emerald-700',
                            'pending'  => 'bg-amber-100 text-amber-700',
                            'rejected' => 'bg-red-100 text-red-700',
                        ];
                        $pill = $pillMap[$statusName] ?? 'bg-gray-100 text-gray-700';
                    ?>
                    <tr x-data="propertyEditor(<?php echo e(old('property_id') == $property->id && $errors->any() ? 'true' : 'false'); ?>)" class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <img class="size-10 rounded-xl object-cover" src="<?php echo e($property->image_url); ?>" alt="">
                                <div>
                                    <p class="text-sm font-bold text-gray-800"><?php echo e($property->title); ?></p>
                                    <p class="text-xs text-gray-400 font-medium"><?php echo e($property->city); ?>, <?php echo e($property->country); ?></p>
                                    <?php if($property->admin_note): ?>
                                        <p class="text-[10px] text-rose-600 font-extrabold uppercase mt-1 tracking-wide" title="<?php echo e($property->admin_note); ?>">
                                            Note: <?php echo e(Str::limit($property->admin_note, 45)); ?>

                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo e(ucfirst($property->type)); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold <?php echo e($pill); ?> uppercase">
                                <span class="size-1.5 rounded-full bg-current"></span><?php echo e(ucfirst($statusName)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">$<?php echo e(number_format($property->price)); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="<?php echo e(route('properties.show', $property)); ?>"
                                    class="size-8 inline-flex justify-center items-center text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all" title="View">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>
                                <button type="button" @click="showEditModal = true"
                                    class="size-8 inline-flex justify-center items-center text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </button>
                                <form action="<?php echo e(route('agent.properties.destroy', $property)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="button"
                                        @click="$store.confirm.ask('Delete property &quot;<?php echo e($property->title); ?>&quot;? This action cannot be undone.', $el.closest('form'))"
                                        class="size-8 inline-flex justify-center items-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Delete">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <!-- Edit Property Modal -->
                            <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
                                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showEditModal = false" x-show="showEditModal" x-transition.opacity></div>
                                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0 lg:ps-64">
                                    <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all w-full sm:my-8 sm:max-w-4xl font-sans">
                                        <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-white">
                                            <div>
                                                <h2 class="text-2xl font-black text-gray-800">Edit Listing</h2>
                                            </div>
                                            <button type="button" @click="showEditModal = false" class="size-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors">
                                                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                        <form action="<?php echo e(route('agent.properties.update', $property)); ?>" method="POST" enctype="multipart/form-data" class="bg-white">
                                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="property_id" value="<?php echo e($property->id); ?>">
                                            <div class="p-8 space-y-6 overflow-y-auto max-h-[70vh]">
                                                <?php if($property->admin_note): ?>
                                                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-sm font-medium">
                                                        <p class="font-extrabold text-[10px] uppercase tracking-wider text-amber-600 mb-1">Feedback from Admin</p>
                                                        <?php echo e($property->admin_note); ?>

                                                    </div>
                                                <?php endif; ?>
                                                <?php if(old('property_id') == $property->id && $errors->any()): ?>
                                                    <div class="mb-4 p-4 rounded-xl bg-rose-50 text-rose-700 text-sm font-semibold">
                                                        <ul class="list-disc list-inside"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($err); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                                    <div class="sm:col-span-2">
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">Property Title</label>
                                                        <input type="text" name="title" value="<?php echo e(old('title', $property->title)); ?>" required class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">Price ($)</label>
                                                        <input type="number" name="price" value="<?php echo e(old('price', $property->price)); ?>" required min="0" step="0.01" class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">Property Type</label>
                                                        <select name="type" required class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($category->slug); ?>" <?php if(old('type', $property->type) === $category->slug): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">Bedrooms</label>
                                                        <input type="number" name="bedrooms" value="<?php echo e(old('bedrooms', $property->bedrooms)); ?>" required min="0" class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">Bathrooms</label>
                                                        <input type="number" name="bathrooms" value="<?php echo e(old('bathrooms', $property->bathrooms)); ?>" required min="0" class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">Total Area (sq ft)</label>
                                                        <input type="number" name="area" value="<?php echo e(old('area', $property->area)); ?>" required min="0" class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">Country</label>
                                                        <input type="text" name="country" value="<?php echo e(old('country', $property->country)); ?>" required class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">City</label>
                                                        <input type="text" name="city" value="<?php echo e(old('city', $property->city)); ?>" required class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">Address</label>
                                                        <input type="text" name="address" value="<?php echo e(old('address', $property->address)); ?>" class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                                                    </div>
                                                    <div class="sm:col-span-2">
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">Description</label>
                                                        <textarea name="description" rows="4" required class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500"><?php echo e(old('description', $property->description)); ?></textarea>
                                                    </div>
                                                    <div class="sm:col-span-2">
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">Features (comma-separated)</label>
                                                        <input type="text" name="features" value="<?php echo e(old('features', is_array($property->features) ? implode(', ', $property->features) : $property->features)); ?>" class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                                                    </div>
                                                    <div class="sm:col-span-2">
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">Current Images</label>
                                                        <div class="flex flex-wrap gap-3">
                                                            <?php $hasImages = false; ?>
                                                            <?php $__currentLoopData = $property->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(is_array($gallery->image_urls)): ?>
                                                                    <?php $__currentLoopData = $gallery->image_urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php $hasImages = true; ?>
                                                                        <div class="relative group size-20 rounded-xl overflow-hidden bg-slate-100 border border-slate-200" x-show="!deletedImages.includes('<?php echo e($url); ?>')">
                                                                            <img src="<?php echo e($url); ?>" class="size-full object-cover">
                                                                            <button type="button" @click="deletedImages.push('<?php echo e($url); ?>')" class="absolute inset-0 bg-rose-600/80 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white transition-opacity" title="Delete image">
                                                                                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                                            </button>
                                                                        </div>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if(!$hasImages): ?>
                                                                <p class="text-xs text-slate-400 font-medium italic">No uploaded images yet.</p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="sm:col-span-2">
                                                        <label class="block mb-2 text-sm font-bold text-gray-700">Upload New Photos</label>
                                                        <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-slate-500 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-500 hover:file:bg-primary-100">
                                                    </div>
                                                    <div class="hidden">
                                                        <template x-for="img in deletedImages" :key="img">
                                                            <input type="hidden" name="delete_images[]" :value="img">
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pt-6 pb-6 px-8 flex justify-end gap-x-3 border-t border-gray-100">
                                                <button type="button" @click="showEditModal = false" class="py-3 px-6 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition-all">Cancel</button>
                                                <button type="submit" class="py-3 px-6 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-lg shadow-primary-600/20 transition-all">Update Listing</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                            No properties yet. <a href="<?php echo e(route('agent.properties.create')); ?>" class="text-primary-600 font-semibold">Create your first listing</a>.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
        <p class="text-xs text-gray-400 font-semibold">Showing <?php echo e($properties->count()); ?> properties</p>
        <button type="button" @click="showCreateModal = true" class="text-xs font-bold text-primary-600 hover:text-primary-700">Add New Property</button>
    </div>
    
    <!-- Create Property Modal -->
    <div x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showCreateModal = false" x-show="showCreateModal" x-transition.opacity></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0 lg:ps-64">
            <div x-show="showCreateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all w-full sm:my-8 sm:max-w-4xl font-sans">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-white">
                    <div>
                        <h2 class="text-2xl font-black text-gray-800">Create New Listing</h2>
                    </div>
                    <button type="button" @click="showCreateModal = false" class="size-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="<?php echo e(route('agent.properties.store')); ?>" method="POST" enctype="multipart/form-data" class="bg-white">
                    <?php echo csrf_field(); ?>
                    <div class="p-8 space-y-6 overflow-y-auto max-h-[70vh]">
                        <?php if(!old('property_id') && $errors->any()): ?>
                            <div class="mb-4 p-4 rounded-xl bg-rose-50 text-rose-700 text-sm font-semibold">
                                <ul class="list-disc list-inside"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($err); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                            </div>
                        <?php endif; ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-sm font-bold text-gray-700">Property Title</label>
                                <input type="text" name="title" value="<?php echo e(old('title')); ?>" required class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">Price ($)</label>
                                <input type="number" name="price" value="<?php echo e(old('price')); ?>" required min="0" step="0.01" class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">Property Type</label>
                                <select name="type" required class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->slug); ?>" <?php if(old('type') === $category->slug): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">Bedrooms</label>
                                <input type="number" name="bedrooms" value="<?php echo e(old('bedrooms')); ?>" required min="0" class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">Bathrooms</label>
                                <input type="number" name="bathrooms" value="<?php echo e(old('bathrooms')); ?>" required min="0" class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">Total Area (sq ft)</label>
                                <input type="number" name="area" value="<?php echo e(old('area')); ?>" required min="0" class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">Country</label>
                                <input type="text" name="country" value="<?php echo e(old('country')); ?>" required class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">City</label>
                                <input type="text" name="city" value="<?php echo e(old('city')); ?>" required class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">Address</label>
                                <input type="text" name="address" value="<?php echo e(old('address')); ?>" class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-sm font-bold text-gray-700">Description</label>
                                <textarea name="description" rows="4" required class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500"><?php echo e(old('description')); ?></textarea>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-sm font-bold text-gray-700">Features (comma-separated)</label>
                                <input type="text" name="features" value="<?php echo e(old('features')); ?>" class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-sm font-bold text-gray-700">Upload Photos</label>
                                <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-slate-500 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-500 hover:file:bg-primary-100">
                            </div>
                        </div>
                    </div>
                    <div class="pt-6 pb-6 px-8 flex justify-end gap-x-3 border-t border-gray-100">
                        <button type="button" @click="showCreateModal = false" class="py-3 px-6 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition-all">Cancel</button>
                        <button type="submit" class="py-3 px-6 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-lg shadow-primary-600/20 transition-all">Publish Listing</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/agent/properties/index.blade.php ENDPATH**/ ?>