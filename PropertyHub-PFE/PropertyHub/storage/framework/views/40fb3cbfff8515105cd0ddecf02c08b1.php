<?php
$user = Auth::user();
$unreadMessages = $user->receivedMessages()->whereNull('read_at')->count();
?>

<!-- Sidebar -->
<aside class="fixed top-0 start-0 bottom-0 w-64 bg-white border-e border-gray-200 flex flex-col pt-6 pb-10 z-50 hidden lg:flex">
    <div class="px-6 mb-8">
        <a class="text-2xl font-black tracking-tighter text-primary-500" href="/">PropertyHub</a>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Agent Portal</p>
    </div>
    
    <nav class="px-6 flex-1">
        <ul class="space-y-1.5">
            <li>
                <a class="flex items-center gap-3.5 py-2.5 px-3 bg-blue-50 text-sm font-semibold rounded-xl <?php echo e(request()->routeIs('agent.dashboard') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-100'); ?>"
                   href="<?php echo e(route('agent.dashboard')); ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <line x1="3" x2="21" y1="9" y2="9" />
                        <line x1="9" x2="9" y1="21" y2="9" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a class="flex items-center gap-3.5 py-2.5 px-3 text-sm font-medium rounded-xl text-gray-700 hover:bg-gray-100 <?php echo e(request()->routeIs('agent.properties.*') ? 'bg-gray-100' : ''); ?>"
                   href="<?php echo e(route('agent.properties.index')); ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    My Properties
                </a>
            </li>
            <li>
                <a class="flex items-center gap-3.5 py-2.5 px-3 text-sm font-medium rounded-xl text-gray-700 hover:bg-gray-100 <?php echo e(request()->routeIs('agent.appointments.*') ? 'bg-gray-100' : ''); ?>"
                   href="<?php echo e(route('agent.appointments.index')); ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                        <line x1="16" x2="16" y1="2" y2="6" />
                        <line x1="8" x2="8" y1="2" y2="6" />
                        <line x1="3" x2="21" y1="10" y2="10" />
                    </svg>
                    Appointments
                </a>
            </li>
            <li>
                <a class="flex items-center gap-3.5 py-2.5 px-3 text-sm font-medium rounded-xl text-gray-700 hover:bg-gray-100 <?php echo e(request()->routeIs('agent.messages.*') ? 'bg-gray-100' : ''); ?>"
                   href="<?php echo e(route('agent.messages.index')); ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    Messages
                    <?php if($unreadMessages > 0): ?>
                        <span class="ms-auto inline-flex items-center justify-center w-5 h-5 rounded-full text-[10px] font-bold bg-blue-600 text-white"><?php echo e($unreadMessages); ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
    </nav>

    <div class="px-6 mt-auto pt-6 border-t border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm">
                <?php echo e(substr($user->name, 0, 1)); ?>

            </div>
            <div>
                <p class="text-sm font-bold text-gray-800"><?php echo e($user->name); ?></p>
                <p class="text-[10px] text-gray-400 truncate"><?php echo e($user->email); ?></p>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Header -->
<header class="sticky top-0 z-40 bg-white border-b border-gray-200 py-3 lg:hidden">
    <div class="flex items-center justify-between px-4">
        <a class="text-xl font-black tracking-tighter text-primary-500" href="/">PropertyHub</a>
        <div class="flex items-center gap-4">
            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
                <?php echo e(substr($user->name, 0, 1)); ?>

            </div>
        </div>
    </div>
</header>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub\resources\views/layouts/agent.blade.php ENDPATH**/ ?>