<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
    initialProducts: {
        type: Array,
        default: () => ([]),
    },
})

const products = ref(Array.isArray(props.initialProducts) ? [...props.initialProducts] : [])



function handleProductCreated(e) {
    const p = e.detail
    products.value.unshift(p)
}

onMounted(() => {
    window.addEventListener('product-created', handleProductCreated)
})

onUnmounted(() => {
    window.removeEventListener('product-created', handleProductCreated)
})
</script>

<template>
        <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Example Row -->
                            
                            <tr v-for="product in products" :key="product.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ product.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ product.category ? product.category.name : '' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ product.stock_quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">₱{{ Number(product.price).toFixed(2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                    <button class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                </td>
                            </tr>
                     
                           
                            
                            <!-- More rows... -->
                        </tbody>
                    </table>
</template>