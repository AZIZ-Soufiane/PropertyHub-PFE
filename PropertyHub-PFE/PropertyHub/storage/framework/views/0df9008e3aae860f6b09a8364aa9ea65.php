<?php $__env->startSection('content'); ?>
<!-- Header -->
<header class="flex flex-wrap sm:justify-start sm:flex-nowrap z-50 w-full bg-white/80 backdrop-blur-md border-b border-gray-200 py-3 sticky top-0">
    <nav class="max-w-7xl w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <a class="text-2xl font-black tracking-tighter text-primary-500" href="/">PropertyHub</a>
        </div>
        <div class="hidden sm:flex items-center gap-x-8">
            <a class="font-semibold text-gray-600 hover:text-blue-600 transition-colors" href="/">Home</a>
            <a class="font-semibold text-gray-600 hover:text-blue-600 transition-colors" href="<?php echo e(route('properties.index')); ?>">Properties</a>
            <a class="font-semibold text-gray-600 hover:text-blue-600 transition-colors" href="<?php echo e(route('compare')); ?>">Compare</a>
            <?php if(auth()->guard()->check()): ?>
                <a class="py-2 px-4 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            <?php else: ?>
                <a class="py-2 px-4 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all" href="<?php echo e(route('login')); ?>">Log in</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<main class="pt-20">
    <!-- Image Slider -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div x-data="{
            images: <?php echo \Illuminate\Support\Js::from($property->all_image_urls)->toHtml() ?>,
            current: 0,
            get total() { return this.images.length },
            next() { this.current = (this.current + 1) % this.total },
            prev() { this.current = (this.current - 1 + this.total) % this.total },
            goTo(i) { this.current = i }
        }" x-init="setInterval(() => next(), 6000)" @keydown.arrow-right.window="next()" @keydown.arrow-left.window="prev()" class="mb-8">
            <!-- Main Image -->
            <div class="relative h-96 lg:h-[540px] rounded-3xl overflow-hidden bg-gray-100 group">
                <template x-for="(img, index) in images" :key="index">
                    <img :src="img"
                         :alt="'<?php echo e($property->title); ?> - Image ' + (index + 1)"
                         class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out"
                         :class="current === index ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                </template>

                <!-- Prev / Next -->
                <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 p-3 bg-white/80 backdrop-blur-sm rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity hover:bg-white">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 p-3 bg-white/80 backdrop-blur-sm rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity hover:bg-white">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>

                <!-- Counter Badge -->
                <div class="absolute top-4 right-4 z-20 bg-black/50 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full">
                    <span x-text="current + 1"></span> / <span x-text="total"></span>
                </div>

                <!-- Dot Indicators -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex gap-2">
                    <template x-for="(img, index) in images" :key="'dot-'+index">
                        <button @click="goTo(index)" class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                                :class="current === index ? 'bg-white w-6' : 'bg-white/50 hover:bg-white/80'"></button>
                    </template>
                </div>
            </div>

            <!-- Thumbnails -->
            <div class="flex gap-3 mt-4 overflow-x-auto pb-2 scrollbar-hide">
                <template x-for="(img, index) in images" :key="'thumb-'+index">
                    <button @click="goTo(index)" class="flex-shrink-0 h-20 w-28 rounded-xl overflow-hidden transition-all duration-300 ring-2"
                            :class="current === index ? 'ring-blue-600 scale-105' : 'ring-transparent opacity-60 hover:opacity-100'">
                        <img :src="img" :alt="'Thumbnail ' + (index + 1)" class="w-full h-full object-cover">
                    </button>
                </template>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Property Info -->
            <div class="w-full lg:w-2/3">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <span class="text-sm font-bold text-blue-600 uppercase tracking-widest"><?php echo e($property->type); ?></span>
                        <h1 class="text-4xl font-black text-gray-900 mt-2"><?php echo e($property->title); ?></h1>
                        <div class="flex items-center gap-2 text-gray-500 mt-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            <?php echo e($property->address); ?>, <?php echo e($property->city); ?>, <?php echo e($property->country); ?>

                        </div>
                    </div>
                    <span class="text-4xl font-black text-blue-600">$<?php echo e(number_format($property->price)); ?></span>
                </div>

                <!-- Features -->
                <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                    <div class="grid grid-cols-3 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <span class="block text-[10px] uppercase font-black text-gray-400 tracking-widest mb-1">Bedrooms</span>
                            <span class="text-2xl font-black text-gray-900"><?php echo e($property->bedrooms); ?></span>
                        </div>
                        <div class="text-center">
                            <span class="block text-[10px] uppercase font-black text-gray-400 tracking-widest mb-1">Bathrooms</span>
                            <span class="text-2xl font-black text-gray-900"><?php echo e($property->bathrooms); ?></span>
                        </div>
                        <div class="text-center">
                            <span class="block text-[10px] uppercase font-black text-gray-400 tracking-widest mb-1">Area</span>
                            <span class="text-2xl font-black text-gray-900"><?php echo e(number_format($property->area)); ?> sqft</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-[10px] uppercase font-black text-gray-400 tracking-widest mb-1">Year Built</span>
                            <span class="text-2xl font-black text-gray-900"><?php echo e($property->year_built ?? 'N/A'); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Description</h2>
                    <p class="text-gray-600 leading-relaxed"><?php echo e($property->description); ?></p>
                </div>

                <!-- Features List -->
                <?php if($property->features): ?>
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Features & Amenities</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <?php $__currentLoopData = explode(',', $property->features); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center gap-2 text-gray-600">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <?php echo e(trim($feature)); ?>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Agent Info -->
                <?php if($property->agent): ?>
                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Listed by</h2>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-2xl font-bold text-blue-600"><?php echo e(substr($property->agent->name, 0, 1)); ?></span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900"><?php echo e($property->agent->name); ?></h3>
                                <p class="text-gray-500"><?php echo e($property->agent->email); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Schedule a Visit</h3>
                    
                    <form action="<?php echo e(route('appointments.store')); ?>" method="POST" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="property_id" value="<?php echo e($property->id); ?>">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Date</label>
                            <input type="date" name="date" required min="<?php echo e(date('Y-m-d')); ?>"
                                class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-600 focus:ring-blue-600">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Time</label>
                            <select name="time_slot" required class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm">
                                <option value="09:00">09:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="14:00">02:00 PM</option>
                                <option value="15:00">03:00 PM</option>
                                <option value="16:00">04:00 PM</option>
                            </select>
                        </div>

                        <?php if(auth()->guard()->check()): ?>
                            <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all">
                                Request Appointment
                            </button>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>?redirect=<?php echo e(route('properties.show', $property)); ?>" class="block w-full py-3 px-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all text-center">
                                Login to Schedule
                            </a>
                        <?php endif; ?>
                    </form>

                    <hr class="my-6 border-gray-200">

                    <div class="space-y-3">
                        <a href="mailto:<?php echo e($property->agent?->email ?? 'contact@propertyhub.com'); ?>?subject=Inquiry about <?php echo e($property->title); ?>" 
                            class="flex items-center justify-center gap-2 py-3 px-4 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Send Message
                        </a>
                        <a href="<?php echo e(route('compare')); ?>?id=<?php echo e($property->id); ?>" 
                            class="flex items-center justify-center gap-2 py-3 px-4 bg-gray-50 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Compare
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('frontend.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views\frontend\property-details.blade.php ENDPATH**/ ?>