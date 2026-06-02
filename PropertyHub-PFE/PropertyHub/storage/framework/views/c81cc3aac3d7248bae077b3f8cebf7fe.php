<?php $__env->startSection('title', isset($property) ? 'Edit Property' : 'New Property'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $isEdit = isset($property) && $property->exists;
    $action = $isEdit ? route('agent.properties.update', $property) : route('agent.properties.store');
    $type = old('type', $property->type ?? 'villa');
?>

<div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-3xl overflow-hidden">
    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-800"><?php echo e($isEdit ? 'Edit Listing' : 'Create New Listing'); ?></h2>
            <p class="text-xs text-gray-400 font-semibold mt-1"><?php echo e($isEdit ? 'Update the details of your listing' : 'Post a new property to the marketplace'); ?></p>
        </div>
        <a href="<?php echo e(route('agent.properties.index')); ?>"
            class="size-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors" title="Close">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </a>
    </div>

    <form action="<?php echo e($action); ?>" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
        <?php echo csrf_field(); ?>
        <?php if($isEdit): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
                <label for="title" class="block mb-2 text-sm font-bold text-gray-700">Property Title</label>
                <input type="text" id="title" name="title" value="<?php echo e(old('title', $property->title ?? '')); ?>" required
                    class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="e.g. Beautiful Sunset Villa in Malibu">
            </div>

            <div>
                <label for="price" class="block mb-2 text-sm font-bold text-gray-700">Price ($)</label>
                <input type="number" id="price" name="price" value="<?php echo e(old('price', $property->price ?? '')); ?>" required min="0" step="0.01"
                    class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="1250000">
            </div>
            <div>
                <label for="type" class="block mb-2 text-sm font-bold text-gray-700">Property Type</label>
                <select id="type" name="type" required
                    class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="villa" <?php echo e($type === 'villa' ? 'selected' : ''); ?>>Villa</option>
                    <option value="apartment" <?php echo e($type === 'apartment' ? 'selected' : ''); ?>>Apartment</option>
                    <option value="house" <?php echo e($type === 'house' ? 'selected' : ''); ?>>House</option>
                    <option value="penthouse" <?php echo e($type === 'penthouse' ? 'selected' : ''); ?>>Penthouse</option>
                    <option value="land" <?php echo e($type === 'land' ? 'selected' : ''); ?>>Land</option>
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">Bedrooms</label>
                <input type="number" name="bedrooms" value="<?php echo e(old('bedrooms', $property->bedrooms ?? 0)); ?>" required min="0"
                    class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="4">
            </div>
            <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">Bathrooms</label>
                <input type="number" name="bathrooms" value="<?php echo e(old('bathrooms', $property->bathrooms ?? 0)); ?>" required min="0"
                    class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="3">
            </div>
            <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">Total Area (m²)</label>
                <input type="number" name="area" value="<?php echo e(old('area', $property->area ?? '')); ?>" required min="0"
                    class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="3200">
            </div>
            <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">Country</label>
                <input type="text" name="country" value="<?php echo e(old('country', $property->country ?? '')); ?>" required
                    class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="e.g. USA">
            </div>

            <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">City</label>
                <input type="text" name="city" value="<?php echo e(old('city', $property->city ?? '')); ?>" required
                    class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="e.g. Malibu">
            </div>
            <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">Address</label>
                <input type="text" name="address" value="<?php echo e(old('address', $property->address ?? '')); ?>"
                    class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="e.g. 123 Ocean Drive">
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="block mb-2 text-sm font-bold text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" required
                    class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="Describe the property..."><?php echo e(old('description', $property->description ?? '')); ?></textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="block mb-2 text-sm font-bold text-gray-700">Features <span class="text-gray-400 font-normal">(comma-separated)</span></label>
                <input type="text" name="features" value="<?php echo e(old('features', $property->features ?? '')); ?>"
                    class="py-3 px-4 block w-full border border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="Pool, Garage, Garden, Sea view">
            </div>

            <div class="sm:col-span-2">
                <label class="block mb-2 text-sm font-bold text-gray-700">Upload Photos</label>
                <div class="flex justify-center items-center w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer hover:border-primary-400">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                        <span class="font-medium text-gray-400 text-sm">Drop files or <span class="text-primary-600 underline">browse</span></span>
                    </div>
                    <input type="file" name="images[]" multiple accept="image/*" class="hidden">
                </div>
                <?php if($isEdit && $property->all_image_urls): ?>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <?php $__currentLoopData = $property->all_image_urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e($img); ?>" class="w-20 h-20 rounded-xl object-cover" alt="">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="pt-6 flex justify-end gap-x-3 border-t border-gray-100">
            <a href="<?php echo e(route('agent.properties.index')); ?>"
                class="py-3 px-6 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition-all">Cancel</a>
            <button type="submit"
                class="py-3 px-6 text-sm font-bold rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-lg shadow-primary-600/20 transition-all inline-flex items-center gap-x-2">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
                <?php echo e($isEdit ? 'Update Listing' : 'Publish Listing'); ?>

            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/agent/properties/create.blade.php ENDPATH**/ ?>