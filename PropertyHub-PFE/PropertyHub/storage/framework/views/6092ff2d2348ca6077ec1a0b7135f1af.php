<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-10">
            <a class="text-3xl font-black tracking-tighter text-primary-500" href="/">PropertyHub</a>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-2">Premium Real Estate</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Create Account</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Already have an account?
                    <a class="text-blue-600 decoration-2 hover:underline font-medium" href="<?php echo e(route('login')); ?>">Sign in</a>
                </p>
            </div>

            <?php if($errors->any()): ?>
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required
                        class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="John Doe">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required
                        class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="your@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required minlength="8"
                        class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Min 8 characters">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full py-3 px-4 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Confirm your password">
                </div>

                <div class="flex items-start gap-2">
                    <input type="checkbox" id="terms" name="terms" required class="mt-1 shrink-0 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="terms" class="text-sm text-gray-600">
                        I agree to the <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                    </label>
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    Create Account
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/auth/register.blade.php ENDPATH**/ ?>