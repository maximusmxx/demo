<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users list
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="w-full mb-4">
                <div class="flex items-center justify-end text-sm text-gray-700 leading-5 white:text-gray-400">
                    <form method="GET" action="{{ url()->current() }}">
                    <label for="per_page">Items per page:</label>
                    <select name="per_page" id="per_page" onchange="this.form.submit()" class="font-medium text-gray-500 bg-white-100 border border-gray-300 py-2 px-4 pe-10 rounded ms-2 text-sm">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                    </form>
                </div>
            </div>
            <div class="w-full mb-4 overflow-hidden rounded-lg shadow-lg">
                <div class="w-full overflow-x-auto">
                    <table class="w-full">
                        <thead>
                        <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-50 uppercase border-b border-gray-600">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">IP address</th>
                            <th class="px-4 py-2">Create at</th>
                            <th class="px-4 py-2">Updated at</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                            @each('user.partials.item', $users, 'item')
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($users->hasPages())
                <div class="w-full my-4">
                    <div class="pagination">
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
