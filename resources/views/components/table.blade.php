<div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-200">
    <table class="min-w-full text-sm text-left">
        {{-- Table Head --}}
        @isset($head)
            <thead class="bg-indigo-500 text-white uppercase text-xs font-semibold tracking-wider">
                {{ $head }}
            </thead>
        @endisset

        {{-- Table Body --}}
        @isset($body)
            <tbody class="divide-y divide-gray-100">
                {{ $body }}
            </tbody>
        @endisset

        {{-- Table Footer --}}
        @isset($footer)
            <tfoot class="bg-gray-50 text-gray-600 font-medium">
                {{ $footer }}
            </tfoot>
        @endisset
    </table>
</div>
