<script setup>
import { ref } from 'vue'

const props = defineProps({
  categories: Array,
  action: String,
})

const open = ref(false)
const csrf = document
  .querySelector('meta[name="csrf-token"]')
  ?.getAttribute('content')

const formRef = ref(null)

async function submit() {
  const url = props.action
  const fd = new FormData(formRef.value)

  const response = await fetch(url, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': csrf,
    },
    body: fd,
  })

  const data = await response.json()

  if (response.ok) {
    window.dispatchEvent(new CustomEvent('product-created', { detail: data.product }))
    open.value = false
    // reset form fields
    formRef.value.reset()
  } else {
    // optional: handle validation errors
    console.error('Create product failed', data)
  }
}
</script>

<template>
  <div>
    <!-- Trigger Button -->
    <button
      @click="open = true"
      class="inline-flex items-center gap-2 rounded-xl bg-blue-900 px-5 py-2.5
             text-sm font-semibold text-white shadow hover:bg-blue-800
             focus:outline-none focus:ring-2 focus:ring-blue-500"
    >
      + Add Product
    </button>

    <!-- Backdrop -->
    <div
      v-if="open"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    >
      <!-- Modal -->
      <div
        class="w-full max-w-lg rounded-2xl bg-white shadow-xl"
        role="dialog"
        aria-modal="true"
      >
        <!-- Header -->
        <div class="border-b px-6 py-4">
          <h2 class="text-lg font-semibold text-gray-800">
            Add New Product
          </h2>
          <p class="mt-1 text-sm text-gray-500">
            Fill in the product details below.
          </p>
        </div>

        <!-- Form -->
        <form @submit.prevent="submit" ref="formRef" class="px-6 py-5 space-y-4">
          <input type="hidden" name="_token" :value="csrf" />

          <!-- Product Name -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">
              Product Name
            </label>
            <input
              id="name"
              name="name"
              type="text"
              required
              placeholder="e.g. Coke 1.5L"
              class="mt-1 w-full rounded-lg border px-3 py-2
                     focus:border-blue-500 focus:ring-blue-500"
            />
          </div>

          <!-- Description -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700">
              Description
            </label>
            <textarea
              id="description"
              name="description"
              rows="3"
              placeholder="Optional product description"
              class="mt-1 w-full rounded-lg border px-3 py-2
                     focus:border-blue-500 focus:ring-blue-500"
            ></textarea>
          </div>

          <!-- Price & Stock -->
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label for="price" class="block text-sm font-medium text-gray-700">
                Price
              </label>
              <input
                id="price"
                name="price"
                type="number"
                step="0.01"
                required
                placeholder="0.00"
                class="mt-1 w-full rounded-lg border px-3 py-2
                       focus:border-blue-500 focus:ring-blue-500"
              />
            </div>

            <div>
              <label for="stock_quantity" class="block text-sm font-medium text-gray-700">
                Stock Quantity
              </label>
              <input
                id="stock_quantity"
                name="stock_quantity"
                type="number"
                required
                placeholder="0"
                class="mt-1 w-full rounded-lg border px-3 py-2
                       focus:border-blue-500 focus:ring-blue-500"
              />
            </div>
          </div>

          <!-- Category -->
          <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">
              Category
            </label>
            <select
              id="category_id"
              name="category_id"
              required
              class="mt-1 w-full rounded-lg border px-3 py-2
                     focus:border-blue-500 focus:ring-blue-500"
            >
              <option value="">Select a category</option>
              <option
                v-for="c in categories"
                :key="c.id"
                :value="c.id"
              >
                {{ c.name }}
              </option>
            </select>
          </div>

          <!-- Actions -->
          <div class="flex justify-end gap-3 border-t pt-4">
            <button
              type="button"
              @click="open = false"
              class="rounded-lg border px-4 py-2 text-sm
                     hover:bg-gray-100"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="rounded-lg bg-green-600 px-5 py-2 text-sm
                     font-semibold text-white shadow
                     hover:bg-green-700 focus:ring-2 focus:ring-green-500"
            >
              Save Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>


