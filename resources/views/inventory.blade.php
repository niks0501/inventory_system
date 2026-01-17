<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Inventory') }}
                </h2>
                <button class="p-2 px-4 border-2 rounded-2xl cursor-pointer flex bg-blue-900 text-white font-semibold">Add Product</button>
        </div>
    </x-slot>

    <!-- Products Table -->
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <!-- Table -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Example Row -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Sample Product</td>
                                <td class="px-6 py-4 whitespace-nowrap">Sample Category</td>
                                <td class="px-6 py-4 whitespace-nowrap">10</td>
                                <td class="px-6 py-4 whitespace-nowrap">$100.00</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                    <button class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                </td>
                            </tr>
                            <!-- More rows... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>