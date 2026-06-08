<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title ?? 'Admin Dashboard — PropertyHub'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/preline/dist/preline.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important}</style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex min-h-screen">

    
    <aside class="hidden lg:flex w-full sm:w-64 lg:w-64 flex-shrink-0 bg-white border-r border-slate-200 flex-col pt-6 sm:pt-7 pb-8 sm:pb-10 min-h-screen">
        <div class="px-4 sm:px-6 mb-6 sm:mb-8">
            <a class="text-xl sm:text-2xl font-black tracking-tighter" href="<?php echo e(route('home')); ?>" aria-label="PropertyHub" style="color:#3b65ad;">PropertyHub</a>
            <p class="text-[8px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1 sm:mt-2">Admin Portal</p>
        </div>
        <nav class="px-4 sm:px-6 flex-1" aria-label="Sidebar navigation">
            <ul class="space-y-1">
                <li>
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                       class="flex items-center gap-x-2.5 sm:gap-x-3.5 py-2 sm:py-2.5 px-2.5 sm:px-3 text-xs sm:text-sm rounded-lg sm:rounded-xl transition-all <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-500 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100'); ?>">
                        <svg class="size-3 sm:size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="9" x2="9" y1="21" y2="9"/></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.users.index')); ?>"
                       class="flex items-center gap-x-2.5 sm:gap-x-3.5 py-2 sm:py-2.5 px-2.5 sm:px-3 text-xs sm:text-sm rounded-lg sm:rounded-xl transition-all <?php echo e(request()->routeIs('admin.users.*') ? 'bg-primary-50 text-primary-500 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100'); ?>">
                        <svg class="size-3 sm:size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Users &amp; Roles
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.properties.index')); ?>"
                       class="flex items-center gap-x-2.5 sm:gap-x-3.5 py-2 sm:py-2.5 px-2.5 sm:px-3 text-xs sm:text-sm rounded-lg sm:rounded-xl transition-all <?php echo e(request()->routeIs('admin.properties.*') ? 'bg-primary-50 text-primary-500 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100'); ?>">
                        <svg class="size-3 sm:size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Properties
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.logs.index')); ?>"
                       class="flex items-center gap-x-3.5 py-2.5 px-3 text-sm rounded-xl transition-all <?php echo e(request()->routeIs('admin.logs*') ? 'bg-primary-50 text-primary-500 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100'); ?>">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                        System Logs
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.messages.index')); ?>"
                       class="flex items-center gap-x-3.5 py-2.5 px-3 text-sm rounded-xl transition-all <?php echo e(request()->routeIs('admin.messages.*') ? 'bg-primary-50 text-primary-500 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100'); ?>">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Messages
                    </a>
                </li>
            </ul>
        </nav>
        <div class="px-4 sm:px-6 mt-auto pt-4 sm:pt-6 border-t border-slate-100">
            <div class="flex items-center gap-3">
                <span class="size-9 rounded-full bg-primary-500 flex items-center justify-center text-white font-black text-sm flex-shrink-0"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></span>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-slate-800 truncate"><?php echo e(Auth::user()->name); ?></p>
                    <p class="text-[10px] text-slate-400 font-semibold truncate"><?php echo e(Auth::user()->email); ?></p>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="size-8 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Sign out">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    
    <div class="flex-1 flex flex-col min-h-screen">

        
        <header class="sticky top-0 z-40 bg-white border-b border-slate-200 py-4 px-6 flex items-center justify-between shadow-sm">
            <div>
                <h1 class="text-xl font-black text-slate-800"><?php echo $__env->yieldContent('page-title', 'Admin Dashboard'); ?></h1>
                <p class="text-xs text-slate-400 font-semibold"><?php echo $__env->yieldContent('page-subtitle', 'Welcome back, ' . Auth::user()->name); ?></p>
            </div>
            <div class="flex items-center gap-4">
                <?php echo $__env->yieldContent('header-actions'); ?>

                
                <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                    <button id="dropdown-notifications" type="button"
                        class="hs-dropdown-toggle relative p-2.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-all">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                            <span class="absolute top-1.5 right-1.5 size-2 rounded-full" style="background:#3b65ad;"></span>
                        <?php endif; ?>
                    </button>
                    <div class="hs-dropdown-menu transition-[opacity,margin] hs-dropdown-open:opacity-100 opacity-0 hidden w-80 bg-white shadow-xl rounded-2xl border border-slate-100 mt-2 z-50 overflow-hidden"
                         aria-labelledby="dropdown-notifications">
                        <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                            <p class="text-sm font-black text-slate-800">Notifications</p>
                            <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                                <span class="inline-flex items-center py-0.5 px-2 rounded-full text-[10px] font-bold text-white bg-primary-500"><?php echo e(auth()->user()->unreadNotifications->count()); ?> New</span>
                            <?php endif; ?>
                        </div>
                        <div class="divide-y divide-slate-50 max-h-72 overflow-y-auto">
                            <?php $__empty_1 = true; $__currentLoopData = auth()->user()->notifications()->take(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="flex items-start gap-3 px-4 py-3 <?php echo e($notification->read_at ? 'opacity-60' : 'hover:bg-slate-50 transition-colors'); ?>">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-slate-800"><?php echo e($notification->data['title'] ?? 'Notification'); ?></p>
                                        <p class="text-xs text-slate-400 mt-0.5"><?php echo e($notification->data['message'] ?? ''); ?></p>
                                        <p class="text-[10px] text-slate-300 font-semibold mt-1"><?php echo e($notification->created_at->diffForHumans()); ?></p>
                                    </div>
                                    <?php if(!$notification->read_at): ?>
                                        <form action="<?php echo e(route('notifications.markAsRead', $notification->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="mt-1 size-2 rounded-full flex-shrink-0 bg-primary-500 hover:bg-primary-600 transition-colors" title="Mark as read"></button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="px-4 py-6 text-center">
                                    <p class="text-sm text-slate-500 font-medium">No notifications available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                            <div class="px-4 py-3 border-t border-slate-100">
                                <form action="<?php echo e(route('notifications.markAllAsRead')); ?>" method="POST" class="block text-center">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-xs font-bold text-primary-500 hover:text-primary-600 transition-colors">Mark all as read</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>

        
        <?php if(session('success') || session('error')): ?>
            <div class="px-6 sm:px-8 pt-6">
                <?php if(session('success')): ?>
                    <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold">
                        <svg class="size-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div class="flex items-center gap-3 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm font-semibold">
                        <svg class="size-5 shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        
        <main class="flex-1 p-6 sm:p-8 space-y-8">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/layouts/admin.blade.php ENDPATH**/ ?>