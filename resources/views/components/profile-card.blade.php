@props(['icon', 'label', 'value'])

<div class="flex items-start bg-white dark:bg-gray-800 p-4 rounded-xl shadow border border-blue-100 dark:border-gray-700">
    <div class="text-blue-600 text-2xl mr-4">{{ $icon }}</div>
    <div>
        <p class="text-sm font-semibold text-gray-500 dark:text-gray-300">{{ $label }}</p>
        <p class="text-base font-bold text-gray-800 dark:text-white break-words">{{ $value }}</p>
    </div>
</div>
