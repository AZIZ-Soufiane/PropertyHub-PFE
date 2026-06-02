<!-- Footer -->
<footer class="bg-slate-950 py-20 px-4 rounded-t-3xl">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
        <div>
            <a class="text-2xl font-black text-white mb-4 block tracking-tighter" href="/">Property<span class="text-blue-500">Hub.</span></a>
            <p class="text-gray-500 font-medium text-sm">Elevating the real estate experience through intelligent management and stunning presentation.</p>
        </div>
        <div>
            <h4 class="text-gray-400 font-black mb-4 text-[10px] uppercase tracking-widest">Quick Access</h4>
            <ul class="space-y-3 text-white font-bold text-sm">
                <li><a class="hover:text-blue-500 transition-colors" href="<?php echo e(route('properties.index')); ?>">Listings</a></li>
                <li><a class="hover:text-blue-500 transition-colors" href="<?php echo e(route('compare')); ?>">Comparison</a></li>
                <li><a class="hover:text-blue-500 transition-colors" href="<?php echo e(route('login')); ?>">Authentication</a></li>
            </ul>
        </div>
        <div class="md:col-span-2">
            <h4 class="text-gray-400 font-black mb-4 text-[10px] uppercase tracking-widest">Newsletter</h4>
            <form class="flex gap-2">
                <input type="email" placeholder="Your email" class="grow bg-white/5 border border-white/10 rounded-xl px-4 py-3 outline-none focus:border-blue-500 text-white font-bold text-sm">
                <button class="px-6 py-3 bg-white text-black font-bold text-sm rounded-xl hover:bg-gray-100 transition-all">Join</button>
            </form>
        </div>
    </div>
    <div class="max-w-7xl mx-auto border-t border-white/5 mt-16 pt-8 flex justify-between text-[10px] font-black text-gray-600 uppercase tracking-widest">
        <span>&copy; <?php echo e(date('Y')); ?> PropertyHub</span>
        <span>Crafted by Solicode</span>
    </div>
</footer><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views\frontend\partials\footer.blade.php ENDPATH**/ ?>