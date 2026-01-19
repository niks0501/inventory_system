<template>
  <div>
    <!-- Open Modal Button -->
    <button
      @click="open = true"
      class="p-2 px-4 border-2 rounded-2xl cursor-pointer flex bg-blue-900 text-white font-semibold"
    >
      Add Product
    </button>

    <!-- Modal -->
    <div v-if="open" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
      <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
        <h2 class="text-xl font-semibold mb-4">Add Product</h2>

        <form method="POST" :action="action" enctype="multipart/form-data">
          <input type="hidden" name="_token" :value="csrfToken" />

          <!-- Product Name -->
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

          <!-- Stock Quantity -->
          <div class="mb-3">
            <label class="block text-sm font-medium">Stock Quantity</label>
            <input type="number" name="stock_quantity" class="w-full border rounded px-3 py-2" required>
          </div>

          <!-- Category -->
          <div class="mb-4">
            <label class="block text-sm font-medium">Category</label>
            <select name="category_id" class="w-full border rounded px-3 py-2" required>
              <option value="">Select category</option>
              <option v-for="category in categories" :value="category.id" :key="category.id">
                {{ category.name }}
              </option>
            </select>
          </div>

          <!-- Buttons -->
          <div class="flex justify-end gap-2">
            <button type="button" @click="open = false" class="px-4 py-2 border rounded">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
              Save
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  categories: { type: Array, default: () => [] },
  action: { type: String, default: '' },
})

const open = ref(false)

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
</script>
