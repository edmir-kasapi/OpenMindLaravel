<div class="w-64 h-screen bg-gray-800 text-white flex flex-col fixed left-0 top-0 z-1">
    <!-- Sidebar Header -->
    <div class="h-16 flex items-center justify-center font-bold text-xl border-b border-gray-700 select-none">
        {{ $title }}
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-4 py-6 space-y-2">
       {{ $slot }}
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-gray-700 text-sm text-gray-400 text-center select-none">
        © {{ date('Y') }} Company Inc.
    </div>
</div>
