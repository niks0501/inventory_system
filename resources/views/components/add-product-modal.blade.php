@props([
    'categories' => [],
    'action' => '#',
    'show' => false,
])

@if ($show)
<div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">

        <h2 class="text-xl font-semibold mb-4">Add Product</h2>

        <form method="POST" action="{{ $action }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label class="block text-sm font-medium">Product Name</label>
                <input name="name" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="block text-sm font-medium">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label class="block text-sm font-medium">Price</label>
                <input type="number" step="0.01" name="price" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Stock -->
            <div class="mb-3">
                <label class="block text-sm font-medium">Stock Quantity</label>
                <input type="number" name="stock_quantity" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Category</label>
                <select name="category_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" @click="$emit('close')" class="border px-4 py-2 rounded">
                    Cancel
                </button>
                <button class="bg-green-600 text-white px-4 py-2 rounded">
                    Save
                </button>
            </div>

        </form>
    </div>
</div>
@endif
