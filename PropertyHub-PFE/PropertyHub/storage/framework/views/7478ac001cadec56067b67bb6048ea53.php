<?php $__env->startSection('title', 'Sign In — PropertyHub'); ?>

<?php $__env->startSection('content'); ?>
    <main class="w-full max-w-md mx-auto p-4 sm:p-6 md:p-8 flex flex-col min-h-screen justify-center">
        <div class="text-center mb-10">
            <a class="text-3xl font-black tracking-tighter text-primary-500" href="<?php echo e(route('home')); ?>">PropertyHub</a>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Premium Real Estate</p>
        </div>
        <div class="mt-6 sm:mt-8 bg-white border border-gray-200 rounded-xl md:rounded-2xl shadow-sm">
            <div class="p-4 sm:p-6 md:p-8">
                <div class="text-center">
                    <h1 class="block text-xl sm:text-2xl md:text-3xl font-bold text-gray-800">Sign in</h1>
                    <p class="mt-2 sm:mt-3 text-xs sm:text-sm text-gray-600">
                        Don't have an account yet?
                        <a class="text-primary-500 decoration-2 hover:underline font-medium" href="<?php echo e(route('register')); ?>">Sign up here</a>
                    </p>
                </div>

                <?php if($errors->any()): ?>
                    <div class="mt-5 p-3 bg-rose-50 border border-rose-200 rounded-lg text-xs sm:text-sm text-rose-600 font-medium">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?>

                <div class="mt-5 sm:mt-6 md:mt-8">
                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="grid gap-y-4 sm:gap-y-5 md:gap-y-6">
                            <div>
                                <label for="email" class="block text-xs sm:text-sm mb-2 sm:mb-3 text-gray-900">Email address</label>
                                <div class="relative">
                                    <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required aria-describedby="email-error" class="py-2 sm:py-3 px-3 sm:px-4 block w-full border border-gray-200 rounded-lg text-xs sm:text-sm focus:border-primary-500 focus:ring-primary-500 outline-none disabled:opacity-50 disabled:pointer-events-none" placeholder="your@email.com">
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-center">
                                    <label for="password" class="block text-xs sm:text-sm mb-2 sm:mb-3 text-gray-900">Password</label>
                                    <a class="text-xs sm:text-sm text-primary-500 decoration-2 hover:underline font-medium" href="#">Forgot password?</a>
                                </div>
                                <div class="relative">
                                    <input type="password" id="password" name="password" required aria-describedby="password-error" class="py-2 sm:py-3 px-3 sm:px-4 block w-full border border-gray-200 rounded-lg text-xs sm:text-sm focus:border-primary-500 focus:ring-primary-500 outline-none disabled:opacity-50 disabled:pointer-events-none" placeholder="••••••••">
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex">
                                    <input id="remember-me" name="remember" type="checkbox" value="1" class="shrink-0 mt-0.5 border-gray-200 rounded text-primary-500 focus:ring-primary-500">
                                </div>
                                <div class="ms-3">
                                    <label for="remember-me" class="text-xs sm:text-sm text-gray-900">Remember me</label>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-primary-500 text-white hover:bg-primary-600 disabled:opacity-50 disabled:pointer-events-none transition-all">
                                Sign in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views\auth\login.blade.php ENDPATH**/ ?>