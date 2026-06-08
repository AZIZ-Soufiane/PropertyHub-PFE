<?php $__env->startSection('title', 'My Favorites'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-800">My Favorites</h1>
        <p class="text-sm text-gray-500 mt-1">Properties you saved for later.</p>
    </div>
    <a href="<?php echo e(route('properties.index')); ?>"
        class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-sm transition-all">
        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
        Browse More
    </a>
</div>

<?php if($favorites->isEmpty()): ?>
    <div class="bg-white border border-gray-200 rounded-2xl p-16 text-center">
        <svg class="size-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
        </svg>
        <p class="text-lg font-bold text-gray-700">No favorites yet</p>
        <p class="text-sm text-gray-400 mt-1">Click the heart icon on any property to save it here.</p>
        <a href="<?php echo e(route('properties.index')); ?>" class="mt-6 inline-flex items-center gap-2 py-2.5 px-5 bg-primary-600 text-white rounded-xl font-bold text-sm hover:bg-primary-700 transition-all">
            Browse Properties
        </a>
    </div>
<?php else: ?>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $favorites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $statusName = optional($property->statusRelation)->name ?? 'pending';
                $pillMap = [
                    'approved' => 'bg-emerald-100 text-emerald-700',
                    'pending'  => 'bg-amber-100 text-amber-700',
                    'sold'     => 'bg-gray-100 text-gray-600',
                    'rented'   => 'bg-blue-100 text-blue-700',
                ];
                $pill = $pillMap[$statusName] ?? 'bg-gray-100 text-gray-700';
            ?>
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group">
                <div class="relative h-48 overflow-hidden">
                    <img src="<?php echo e($property->image_url); ?>" alt="<?php echo e($property->title); ?>"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-3 left-3 py-1 px-3 rounded-full text-[10px] font-bold <?php echo e($pill); ?> uppercase">
                        <?php echo e(ucfirst($statusName)); ?>

                    </span>
                    
                    <form action="<?php echo e(route('buyer.favorites.toggle', $property)); ?>" method="POST" class="absolute top-3 right-3">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="size-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center shadow hover:bg-red-50 transition-colors" title="Remove from favorites">
                            <svg class="size-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-primary-500 mb-1"><?php echo e(ucfirst($property->type)); ?></p>
                    <h3 class="text-base font-bold text-gray-800 mb-1 truncate"><?php echo e($property->title); ?></h3>
                    <p class="text-xs text-gray-500 flex items-center gap-1 mb-3">
                        <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <?php echo e($property->city); ?>, <?php echo e($property->country); ?>

                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-black text-gray-900">$<?php echo e(number_format($property->price)); ?></span>
                        <div class="flex items-center gap-3 text-xs text-gray-500 font-medium">
                            <?php if($property->bedrooms): ?>
                                <span class="flex items-center gap-1">
                                    <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    <?php echo e($property->bedrooms); ?>

                                </span>
                            <?php endif; ?>
                            <?php if($property->bathrooms): ?>
                                <span><?php echo e($property->bathrooms); ?> bath</span>
                            <?php endif; ?>
                            <?php if($property->area): ?>
                                <span><?php echo e(number_format($property->area)); ?> ft²</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <a href="<?php echo e(route('properties.show', $property)); ?>"
                            class="flex-1 py-2 text-center text-sm font-bold text-primary-600 border border-primary-200 rounded-xl hover:bg-primary-50 transition-colors">
                            View Details
                        </a>
                        <?php if($property->agent): ?>
                            <a href="<?php echo e(route('buyer.messages.show', $property->agent)); ?>"
                                class="flex-1 py-2 text-center text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors">
                                Contact Agent
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($favorites->hasPages()): ?>
        <div class="mt-6"><?php echo e($favorites->links()); ?></div>
    <?php endif; ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.buyer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/buyer/favorites/index.blade.php ENDPATH**/ ?>