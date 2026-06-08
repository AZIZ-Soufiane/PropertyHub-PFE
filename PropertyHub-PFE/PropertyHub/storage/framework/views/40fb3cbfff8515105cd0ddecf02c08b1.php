<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title ?? 'Agent Portal — PropertyHub'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/preline/dist/preline.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important}</style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <?php
    $user = Auth::user();
    $unreadMessages = $user->receivedMessages()->whereNull('read_at')->count();
    ?>

    <div x-data="{ sidebarOpen: false }">

        
        <div x-show="sidebarOpen" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        
        <aside id="application-sidebar"
            class="fixed top-0 start-0 bottom-0 z-[60] w-full sm:w-64 bg-white border-e border-gray-200 pt-6 sm:pt-7 pb-0 overflow-y-auto -translate-x-full lg:translate-x-0 transition-all duration-300 flex flex-col"
            :class="sidebarOpen && 'translate-x-0'">
            <div class="px-4 sm:px-6 mb-6 sm:mb-8">
                <a class="text-xl sm:text-2xl font-black tracking-tighter" href="<?php echo e(route('home')); ?>" aria-label="PropertyHub" style="color:#3b65ad;">PropertyHub</a>
                <p class="text-[8px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1 sm:mt-2">Agent Portal</p>
            </div>
            <nav class="px-4 sm:px-6 flex-1">
                <ul class="space-y-1.5">
                    <li>
                        <a class="flex items-center gap-x-3 sm:gap-x-3.5 py-2 px-3 text-xs sm:text-sm rounded-lg sm:rounded-xl transition-all <?php echo e(request()->routeIs('agent.dashboard') ? 'bg-primary-50 text-primary-500 font-semibold' : 'text-gray-700 font-medium hover:bg-gray-100'); ?>"
                           href="<?php echo e(route('agent.dashboard')); ?>" @click="sidebarOpen = false">
                            <svg class="size-3 sm:size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="9" x2="9" y1="21" y2="9"/></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="w-full flex items-center gap-x-3 sm:gap-x-3.5 py-2 sm:py-2.5 px-3 text-xs sm:text-sm rounded-lg sm:rounded-xl transition-all <?php echo e(request()->routeIs('agent.properties.*') ? 'bg-primary-50 text-primary-500 font-semibold' : 'text-gray-700 font-medium hover:bg-gray-100'); ?>"
                           href="<?php echo e(route('agent.properties.index')); ?>" @click="sidebarOpen = false">
                            <svg class="size-3 sm:size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            My Properties
                        </a>
                    </li>
                    <li>
                        <a class="w-full flex items-center gap-x-3 sm:gap-x-3.5 py-2 sm:py-2.5 px-3 text-xs sm:text-sm rounded-lg sm:rounded-xl transition-all <?php echo e(request()->routeIs('agent.appointments.*') ? 'bg-primary-50 text-primary-500 font-semibold' : 'text-gray-700 font-medium hover:bg-gray-100'); ?>"
                           href="<?php echo e(route('agent.appointments.index')); ?>" @click="sidebarOpen = false">
                            <svg class="size-3 sm:size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            Appointments
                        </a>
                    </li>
                    <li>
                        <a class="w-full flex items-center gap-x-3 sm:gap-x-3.5 py-2 sm:py-2.5 px-3 text-xs sm:text-sm rounded-lg sm:rounded-xl transition-all <?php echo e(request()->routeIs('agent.messages.*') ? 'bg-primary-50 text-primary-500 font-semibold' : 'text-gray-700 font-medium hover:bg-gray-100'); ?>"
                           href="<?php echo e(route('agent.messages.index')); ?>" @click="sidebarOpen = false">
                            <svg class="size-3 sm:size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            Messages
                            <?php if($unreadMessages > 0): ?>
                                <span class="ms-auto inline-flex items-center size-4 sm:size-5 justify-center rounded-full text-[8px] sm:text-[10px] font-bold bg-primary-500 text-white"><?php echo e($unreadMessages); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="px-4 sm:px-6 py-4 sm:py-5 border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <span class="size-9 rounded-full bg-primary-500 flex items-center justify-center text-white font-black text-sm flex-shrink-0"><?php echo e(strtoupper(substr($user->name, 0, 1))); ?></span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-gray-800 truncate"><?php echo e($user->name); ?></p>
                        <p class="text-[10px] text-gray-400 font-medium truncate"><?php echo e($user->email); ?></p>
                    </div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="size-8 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Sign out">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        
        <div class="w-full lg:ps-64">

            
            <header class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-[48] bg-white/80 backdrop-blur-md border-b border-gray-200 py-3">
                <nav class="flex items-center justify-between w-full px-4 sm:px-6">
                    <div class="lg:hidden">
                        <button type="button" class="text-gray-500 hover:text-gray-600" @click="sidebarOpen = !sidebarOpen">
                            <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-x-4 ms-auto">
                    </div>
                </nav>
            </header>

            
            <?php if(session('success') || session('error')): ?>
                <div class="px-4 sm:px-6 pt-4">
                    <?php if(session('success')): ?>
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm font-medium"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            
            <div class="p-6 sm:p-8 space-y-8">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/layouts/agent.blade.php ENDPATH**/ ?>