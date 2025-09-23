@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 bg-white text-gray-900 focus:border-[#1b3985] focus:ring-[#1b3985] rounded-md shadow-sm']) }}>
