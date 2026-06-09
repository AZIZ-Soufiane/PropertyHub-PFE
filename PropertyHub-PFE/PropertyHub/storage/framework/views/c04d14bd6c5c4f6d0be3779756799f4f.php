<?php $__env->startSection('title', 'Properties Management'); ?>
<?php $__env->startSection('page-title', 'Properties'); ?>
<?php $__env->startSection('page-subtitle', 'Review and manage all property listings'); ?>



<?php $__env->startSection('content'); ?>
<div x-data="{ showCreateModal: <?php echo e(!old('_method') && $errors->any() ? 'true' : 'false'); ?> }">

    
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="flex flex-col bg-white border border-slate-200 shadow-sm rounded-2xl p-5 hover:shadow-md transition-all">
            <div class="flex items-center gap-x-4 mb-3">
                <div class="size-11 flex justify-center items-center rounded-xl bg-primary-50 text-primary-500">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </div>
                <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Total</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800"><?php echo e($stats['total']); ?></h3>
            <span class="text-xs font-bold text-slate-500 mt-2">Avg price $<?php echo e(number_format($stats['average_price'])); ?></span>
        </div>

        <div class="flex flex-col bg-white border border-slate-200 shadow-sm rounded-2xl p-5 hover:shadow-md transition-all">
            <div class="flex items-center gap-x-4 mb-3">
                <div class="size-11 flex justify-center items-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>
                <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Approved</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800"><?php echo e($stats['approved']); ?></h3>
            <span class="text-xs font-bold text-emerald-600 mt-2">Live listings</span>
        </div>

        <div class="flex flex-col bg-white border border-slate-200 shadow-sm rounded-2xl p-5 hover:shadow-md transition-all">
            <div class="flex items-center gap-x-4 mb-3">
                <div class="size-11 flex justify-center items-center rounded-xl bg-amber-50 text-amber-600">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Pending</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800"><?php echo e($stats['pending']); ?></h3>
            <span class="text-xs font-bold text-amber-600 mt-2">Awaiting review</span>
        </div>

        <div class="flex flex-col bg-white border border-slate-200 shadow-sm rounded-2xl p-5 hover:shadow-md transition-all">
            <div class="flex items-center gap-x-4 mb-3">
                <div class="size-11 flex justify-center items-center rounded-xl bg-rose-50 text-rose-600">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="m15 9-6 6M9 9l6 6" />
                    </svg>
                </div>
                <p class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Rejected</p>
            </div>
            <h3 class="text-3xl font-black text-slate-800"><?php echo e($stats['rejected']); ?></h3>
            <span class="text-xs font-bold text-rose-600 mt-2">Not approved</span>
        </div>
    </div>

    
    <div class="flex flex-col bg-white border border-slate-200 shadow-sm rounded-3xl overflow-hidden mt-8">
        <form method="GET" action="<?php echo e(route('admin.properties.index')); ?>"
              class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex flex-1 items-center gap-3 w-full">
                <div class="relative flex-1 max-w-sm">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                           class="py-2.5 px-4 ps-11 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all"
                           placeholder="Search title, city, agent...">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                        <svg class="size-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                    </div>
                </div>

                <select name="status" data-hs-select='{
                        "placeholder": "All Status",
                        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2.5 ps-4 pe-9 flex text-nowrap w-48 cursor-pointer bg-white border border-slate-200 text-slate-800 rounded-xl text-start text-sm hover:bg-slate-50 focus:outline-none focus:bg-slate-50",
                        "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden overflow-y-auto",
                        "optionClasses": "hs-selected:bg-slate-100 py-2 px-4 w-full text-sm text-slate-800 cursor-pointer hover:bg-slate-100 rounded-lg focus:outline-none focus:bg-slate-100",
                        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-primary-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-slate-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                    }' class="hidden">
                    <option value="">All Status</option>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status); ?>" <?php if(request('status') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <button type="submit" class="py-2.5 px-4 text-sm font-bold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition-all">
                    Filter
                </button>
            </div>
            <button type="button" @click="showCreateModal = true"
                    class="py-2.5 px-5 bg-primary-500 text-white rounded-xl font-bold text-sm shadow-sm hover:bg-primary-600 whitespace-nowrap transition-all">
                + Add Property
            </button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/60">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Property</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Agent</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__empty_1 = true; $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr x-data="{ showEditModal: <?php echo e(old('property_id') == $property->id && $errors->any() ? 'true' : 'false'); ?> }" class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 bg-slate-200 rounded-lg overflow-hidden flex-shrink-0">
                                        <img src="<?php echo e($property->image_url); ?>" alt="<?php echo e($property->title); ?>" class="size-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-slate-800 truncate"><?php echo e($property->title); ?></p>
                                        <p class="text-xs text-slate-400 font-medium">$<?php echo e(number_format($property->price)); ?> · <?php echo e($property->city ?: $property->location); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-slate-700 font-medium"><?php echo e($property->agent?->name ?? '—'); ?></p>
                                <p class="text-xs text-slate-400"><?php echo e($property->agent?->email); ?></p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $st = $property->status;
                                    $tone = match($st) {
                                        'approved' => 'bg-emerald-100 text-emerald-700 [&_.dot]:bg-emerald-500',
                                        'pending'  => 'bg-amber-100 text-amber-700 [&_.dot]:bg-amber-500',
                                        'rejected' => 'bg-rose-100 text-rose-700 [&_.dot]:bg-rose-500',
                                        'sold'     => 'bg-slate-200 text-slate-700 [&_.dot]:bg-slate-500',
                                        'rented'   => 'bg-primary-100 text-primary-700 [&_.dot]:bg-primary-500',
                                        default    => 'bg-slate-100 text-slate-700 [&_.dot]:bg-slate-400',
                                    };
                                ?>
                                <span class="py-1 px-3 inline-flex items-center gap-1 rounded-full text-[10px] font-bold uppercase <?php echo e($tone); ?>">
                                    <span class="dot size-1.5 rounded-full"></span><?php echo e(ucfirst($st ?? 'unknown')); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <?php if($property->status === 'pending'): ?>
                                        <form action="<?php echo e(route('admin.properties.approve', $property)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                    class="size-8 inline-flex justify-center items-center text-slate-400 hover:text-emerald-500 hover:bg-emerald-50 rounded-lg transition-all"
                                                    title="Approve">
                                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <polyline points="20 6 9 17 4 12" />
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.properties.reject', $property)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                    class="size-8 inline-flex justify-center items-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all"
                                                    title="Reject">
                                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path d="M18 6 6 18M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('properties.show', $property)); ?>"
                                       class="size-8 inline-flex justify-center items-center text-slate-400 hover:text-primary-500 hover:bg-primary-50 rounded-lg transition-all"
                                       title="View">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a>
                                    <button type="button" @click="showEditModal = true"
                                       class="size-8 inline-flex justify-center items-center text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-all"
                                       title="Edit">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>
                                    <form action="<?php echo e(route('admin.properties.destroy', $property)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" onclick="return confirm('Delete this property?')"
                                                class="size-8 inline-flex justify-center items-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all"
                                                title="Delete">
                                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Edit Property Modal -->
                        <div x-show="showEditModal" class="fixed inset-0 lg:left-64 z-50 overflow-y-auto" x-cloak>
                            <div class="fixed inset-0 lg:left-64 bg-slate-900/50 backdrop-blur-sm" @click="showEditModal = false" x-show="showEditModal" x-transition.opacity></div>
                            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">
                                    <div class="flex justify-between items-center py-4 px-6 border-b border-slate-100 bg-white">
                                        <h3 class="font-black text-slate-800 text-xl">Edit Property</h3>
                                        <button type="button" @click="showEditModal = false" class="size-10 inline-flex justify-center items-center rounded-xl text-slate-400 hover:bg-slate-100 transition-all">
                                            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M18 6 6 18M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                    <form action="<?php echo e(route('admin.properties.update', $property)); ?>" method="POST" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                        <input type="hidden" name="property_id" value="<?php echo e($property->id); ?>">
                                        <div class="p-8 overflow-y-auto max-h-[70vh] bg-white">
                                            <?php if(old('property_id') == $property->id && $errors->any()): ?>
                                                <div class="mb-4 p-4 rounded-xl bg-rose-50 text-rose-700 text-sm font-semibold">
                                                    <ul class="list-disc list-inside"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($err); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                                                </div>
                                            <?php endif; ?>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                                <div class="sm:col-span-2">
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Property Title</label>
                                                    <input type="text" name="title" required value="<?php echo e(old('title', $property->title)); ?>" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Price ($)</label>
                                                    <input type="number" name="price" required step="0.01" value="<?php echo e(old('price', $property->price)); ?>" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Type</label>
                                                    <select name="type" required class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                                        <?php $__currentLoopData = ['villa','apartment','house','penthouse','land']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($t); ?>" <?php if(old('type', $property->type) === $t): echo 'selected'; endif; ?>><?php echo e(ucfirst($t)); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Bedrooms</label>
                                                    <input type="number" name="bedrooms" min="0" value="<?php echo e(old('bedrooms', $property->bedrooms)); ?>" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Bathrooms</label>
                                                    <input type="number" name="bathrooms" min="0" value="<?php echo e(old('bathrooms', $property->bathrooms)); ?>" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Area (sq ft)</label>
                                                    <input type="number" name="area" min="0" step="0.01" value="<?php echo e(old('area', $property->area)); ?>" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">City</label>
                                                    <input type="text" name="city" value="<?php echo e(old('city', $property->city)); ?>" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Country</label>
                                                    <input type="text" name="country" value="<?php echo e(old('country', $property->country)); ?>" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Address</label>
                                                    <input type="text" name="address" value="<?php echo e(old('address', $property->address)); ?>" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Assigned Agent</label>
                                                    <select name="agent_id" required class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                                        <option value="">— Select agent —</option>
                                                        <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($agent->id); ?>" <?php if(old('agent_id', $property->agent_id) == $agent->id): echo 'selected'; endif; ?>><?php echo e($agent->name); ?> (<?php echo e($agent->email); ?>)</option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Status</label>
                                                    <select name="status" required class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                                        <?php $__currentLoopData = ['pending','approved','rejected','sold','rented']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($s); ?>" <?php if(old('status', $property->status) === $s): echo 'selected'; endif; ?>><?php echo e(ucfirst($s)); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Description</label>
                                                    <textarea name="description" rows="3" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all"><?php echo e(old('description', $property->description)); ?></textarea>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Features (comma separated)</label>
                                                    <input type="text" name="features" value="<?php echo e(old('features', is_array($property->features) ? implode(', ', $property->features) : $property->features)); ?>" class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Images (Upload to add new ones)</label>
                                                    <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-slate-500 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-500 hover:file:bg-primary-100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-slate-50/50 flex justify-end items-center gap-x-3 py-5 px-8 border-t border-slate-100">
                                            <button type="button" @click="showEditModal = false" class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-slate-200 bg-white text-slate-800 hover:bg-slate-50 transition-all">Cancel</button>
                                            <button type="submit" class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-primary-500 text-white hover:bg-primary-600 transition-all shadow-xl shadow-primary-500/20">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">
                                No properties found.
                                <button type="button" @click="showCreateModal = true" class="text-primary-500 font-bold hover:underline ms-1">Create one</button>.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($properties->hasPages()): ?>
            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                <p class="text-xs text-slate-400 font-semibold">
                    Showing <?php echo e($properties->firstItem()); ?> – <?php echo e($properties->lastItem()); ?> of <?php echo e($properties->total()); ?>

                </p>
                <div><?php echo e($properties->links()); ?></div>
            </div>
        <?php endif; ?>
    </div>

    
    <div x-show="showCreateModal" class="fixed inset-0 lg:left-64 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 lg:left-64 bg-slate-900/50 backdrop-blur-sm" @click="showCreateModal = false"
             x-show="showCreateModal" x-transition.opacity></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="showCreateModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">

                <div class="flex justify-between items-center py-4 px-6 border-b border-slate-100 bg-white">
                    <h3 class="font-black text-slate-800 text-xl">Add New Property</h3>
                    <button type="button" @click="showCreateModal = false"
                            class="size-10 inline-flex justify-center items-center rounded-xl text-slate-400 hover:bg-slate-100 transition-all">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M18 6 6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="<?php echo e(route('admin.properties.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="p-8 overflow-y-auto max-h-[70vh] bg-white">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Property Title</label>
                                <input type="text" name="title" required value="<?php echo e(old('title')); ?>"
                                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all"
                                       placeholder="e.g. Sunset Villa, Malibu">
                            </div>

                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Price ($)</label>
                                <input type="number" name="price" required step="0.01" value="<?php echo e(old('price')); ?>"
                                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all"
                                       placeholder="1250000">
                            </div>

                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Type</label>
                                <select name="type" required
                                        class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                    <?php $__currentLoopData = ['villa','apartment','house','penthouse','land']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($t); ?>" <?php if(old('type') === $t): echo 'selected'; endif; ?>><?php echo e(ucfirst($t)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Bedrooms</label>
                                <input type="number" name="bedrooms" min="0" value="<?php echo e(old('bedrooms', 0)); ?>"
                                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                            </div>

                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Bathrooms</label>
                                <input type="number" name="bathrooms" min="0" value="<?php echo e(old('bathrooms', 0)); ?>"
                                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                            </div>

                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Area (sq ft)</label>
                                <input type="number" name="area" min="0" step="0.01" value="<?php echo e(old('area')); ?>"
                                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                            </div>

                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">City</label>
                                <input type="text" name="city" value="<?php echo e(old('city')); ?>"
                                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all"
                                       placeholder="Malibu">
                            </div>

                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Country</label>
                                <input type="text" name="country" value="<?php echo e(old('country')); ?>"
                                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all"
                                       placeholder="USA">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Address</label>
                                <input type="text" name="address" value="<?php echo e(old('address')); ?>"
                                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all"
                                       placeholder="123 Malibu Dr">
                            </div>

                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Assigned Agent</label>
                                <select name="agent_id" required
                                        class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                    <option value="">— Select agent —</option>
                                    <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($agent->id); ?>" <?php if(old('agent_id') == $agent->id): echo 'selected'; endif; ?>><?php echo e($agent->name); ?> (<?php echo e($agent->email); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Status</label>
                                <select name="status" required
                                        class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all">
                                    <?php $__currentLoopData = ['pending','approved','rejected','sold','rented']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($s); ?>" <?php if(old('status', 'approved') === $s): echo 'selected'; endif; ?>><?php echo e(ucfirst($s)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Description</label>
                                <textarea name="description" rows="3"
                                          class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all"
                                          placeholder="Describe the property..."><?php echo e(old('description')); ?></textarea>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Features (comma separated)</label>
                                <input type="text" name="features" value="<?php echo e(old('features')); ?>"
                                       class="py-3 px-4 block w-full border border-slate-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500 outline-none transition-all"
                                       placeholder="Pool, Garage, Garden">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-xs font-bold text-slate-800 uppercase tracking-wide">Images</label>
                                <input type="file" name="images[]" multiple accept="image/*"
                                       class="block w-full text-sm text-slate-500 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-500 hover:file:bg-primary-100">
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50/50 flex justify-end items-center gap-x-3 py-5 px-8 border-t border-slate-100">
                        <button type="button" @click="showCreateModal = false"
                                class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-slate-200 bg-white text-slate-800 hover:bg-slate-50 transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                                class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-primary-500 text-white hover:bg-primary-600 transition-all shadow-xl shadow-primary-500/20">
                            Publish Listing
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/admin/properties/index.blade.php ENDPATH**/ ?>