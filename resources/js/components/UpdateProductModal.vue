<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  product: Object,
  categories: Array,
})

const emit = defineEmits(['close', 'updated'])

const form = ref({})


watch(
  () => props.product,
  (p) => {
    if (p) {
      form.value = {
        name: p.name ?? '',
        description: p.description ?? '',
        price: p.price ?? 0,
        stock_quantity: p.stock_quantity ?? 0,
        category_id: p.category_id ?? null,
      }
    } else {
      form.value = {}
    }
  },
  { immediate: true }
)

const csrf = document
  .querySelector('meta[name="csrf-token"]')
  ?.getAttribute('content')

async function submit() {
  if (!props.product) return

  const res = await fetch(`/products/${props.product.id}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrf,
    },
    body: JSON.stringify(form.value),
  })

  const data = await res.json()
  emit('updated', data.product)
  emit('close')
}
</script>

<template>
  <div v-if="product" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-lg rounded-2xl bg-white shadow-xl" role="dialog" aria-modal="true">
      <div class="border-b px-6 py-4 text-start">
        <h2 class="text-lg font-semibold text-gray-800">Edit Product</h2>
        <p class="mt-1 text-sm text-gray-500">Update product details below.</p>
      </div>

      <form @submit.prevent="submit" ref="formRef" class="px-6 py-5 space-y-4">
        <input type="hidden" name="_token" :value="csrf" />

        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
          <input id="name" name="name" type="text" required placeholder="e.g. Coke 1.5L"
                 v-model="form.name"
                 class="mt-1 w-full rounded-lg border px-3 py-2 focus:border-blue-500 focus:ring-blue-500" />
        </div>

        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <textarea id="description" name="description" rows="3" placeholder="Optional product description"
                    v-model="form.description"
                    class="mt-1 w-full rounded-lg border px-3 py-2 focus:border-blue-500 focus:ring-blue-500"></textarea>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            <input id="price" name="price" type="number" step="0.01" required placeholder="0.00"
                   v-model.number="form.price"
                   class="mt-1 w-full rounded-lg border px-3 py-2 focus:border-blue-500 focus:ring-blue-500" />
          </div>

          <div>
            <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
            <input id="stock_quantity" name="stock_quantity" type="number" required placeholder="0"
                   v-model.number="form.stock_quantity"
                   class="mt-1 w-full rounded-lg border px-3 py-2 focus:border-blue-500 focus:ring-blue-500" />
          </div>
        </div>

        <div>
          <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
          <select id="category_id" name="category_id" required v-model="form.category_id"
                  class="mt-1 w-full rounded-lg border px-3 py-2 focus:border-blue-500 focus:ring-blue-500">
            <option value="">Select a category</option>
            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
          </select>
        </div>

        <div class="flex justify-end gap-3 border-t pt-4">
          <button type="button" @click="emit('close')" class="rounded-lg border px-4 py-2 text-sm hover:bg-gray-100">Cancel</button>
          <button type="submit" class="rounded-lg bg-green-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-green-700 focus:ring-2 focus:ring-green-500">Save Product</button>
        </div>
      </form>
    </div>
  </div>
</template>