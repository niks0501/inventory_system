<x-app-layout>
    <x-slot name="header">
        <div id="app" class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Inventory') }}
            </h2>
        
            <add-product-modal
                :categories='@json($categories)'
                action="{{ route('products.store') }}"
            ></add-product-modal>
            
        </div>
    </x-slot>

    <!-- Products Table -->
        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <product-table
                            :initial-products='@json($products->items())'
                        ></product-table>
                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

</x-app-layout>
 
<!-- Vue will render the modal via the component mounted to #app -->