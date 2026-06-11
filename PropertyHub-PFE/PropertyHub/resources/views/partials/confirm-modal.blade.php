<div x-data>
    <div x-show="$store.confirm.show"
         x-cloak
         class="fixed inset-0 z-[100] overflow-y-auto"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="$store.confirm.cancel()"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div x-show="$store.confirm.show"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6"
                 @click.outside="$store.confirm.cancel()">
                <div class="mx-auto size-14 flex items-center justify-center rounded-full bg-amber-100 mb-4">
                    <svg class="size-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 text-center mb-2">Confirm Action</h3>
                <p class="text-sm text-slate-500 text-center mb-6" x-text="$store.confirm.message"></p>
                <div class="flex gap-3">
                    <button type="button" @click="$store.confirm.cancel()"
                            class="flex-1 py-2.5 px-4 rounded-xl border border-slate-200 text-slate-700 font-semibold text-sm hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                    <button type="button" @click="$store.confirm.proceed()"
                            class="flex-1 py-2.5 px-4 rounded-xl bg-red-600 text-white font-semibold text-sm hover:bg-red-700 transition-colors">
                        Yes, I acknowledge
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
