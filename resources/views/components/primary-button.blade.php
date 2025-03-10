<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#b3e534] dark:bg-[#b3e534] border border-transparent rounded-md font-semibold text-xs text-gray-500  dark:text-gray-500 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-[#b3e534] dark:active:bg-[#b3e534] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 ']) }}>
    {{ $slot }}
</button>
