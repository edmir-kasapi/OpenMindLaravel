@props(['active' => false])


<a {{ $attributes }} @class([
    'block px-4 py-2.5 rounded transition duration-200 cursor-pointer pointer-events-auto text-white',
    'bg-blue-600' => $active,
    'hover:bg-gray-700 text-gray-300' => !$active,
])>
    {{ $slot }}
</a>
