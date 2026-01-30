<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import UpdateProductModal from './UpdateProductModal.vue'
import FilterProductsButton from './FilterProductsButton.vue'

const selectedProduct = ref(null)
const showEditModal = ref(false)
const showConfirmDeleteModal = ref(false)

const props = defineProps({
    initialProducts: {
        type: Array,
        default: () => ([]),
    },
    categories: {
        type: Array,
        default: () => ([]),
    },
})

const products = ref(Array.isArray(props.initialProducts) ? [...props.initialProducts] : [])
const selectedCategories = ref([])
const search = ref('')
const loading = ref(false)

function debounce(fn, wait = 400) {
    let t
    return (...args) => {
        clearTimeout(t)
        t = setTimeout(() => fn(...args), wait)
    }
}

function editProduct(product) {
    selectedProduct.value = product
    showEditModal.value = true
}

function handleProductCreated(e) {
    const p = e.detail
    products.value.unshift(p)
}

function deleteProduct(product) {
    selectedProduct.value = product
    showConfirmDeleteModal.value = true
}

async function loadProducts() {
    try {
        loading.value = true

        const params = new URLSearchParams(window.location.search)
        // remove any existing category params to replace with selected ones
        params.delete('categories[]')
        params.delete('categories')
        selectedCategories.value.forEach(id => params.append('categories[]', id))
        if (search.value && search.value.length > 0) {
            params.set('search', search.value)
        } else {
            params.delete('search')
        }

        const res = await fetch('/products' + (params.toString() ? ('?' + params.toString()) : ''), {
            headers: { Accept: 'application/json' },
        })
        if (res.ok) {
            const data = await res.json()
            products.value = Array.isArray(data.data) ? data.data : []
            // keep server response handling minimal; front-end pagination is server-rendered
        }
    } catch (e) {
        console.error('Failed to load products', e)
    } finally {
        loading.value = false
    }
}

function handleCategoriesUpdate(newValue) {
    selectedCategories.value = Array.isArray(newValue) ? [...newValue] : []
    // fetch filtered results via AJAX
    updateUrl()
    loadProducts()
}

// Initialize search from current URL
onMounted(() => {
    const params = new URLSearchParams(window.location.search)
    search.value = params.get('search') || ''
})

function navigateToSearch() {
    updateUrl()
    loadProducts()
}

function buildParams() {
    const params = new URLSearchParams()
    selectedCategories.value.forEach(id => params.append('categories[]', id))
    if (search.value && search.value.length > 0) {
        params.set('search', search.value)
    }
    return params
}

function updateUrl() {
    const params = buildParams()
    const qs = params.toString() ? ('?' + params.toString()) : ''
    history.pushState({}, '', '/products' + qs)
}

const debouncedLoad = debounce(() => {
    updateUrl()
    loadProducts()
}, 400)

watch(search, () => {
    debouncedLoad()
})

function handlePopState() {
    const params = new URLSearchParams(window.location.search)
    search.value = params.get('search') || ''
    const cats = params.getAll('categories[]')
    if (cats.length === 0) {
        const alt = params.getAll('categories')
        selectedCategories.value = alt
    } else {
        selectedCategories.value = cats
    }
    // when user navigates history, reload filtered results via AJAX
    loadProducts()
}

onMounted(() => {
    window.addEventListener('product-created', handleProductCreated)
    window.addEventListener('popstate', handlePopState)
})

onUnmounted(() => {
    window.removeEventListener('product-created', handleProductCreated)
    window.removeEventListener('popstate', handlePopState)
})

function handleProductUpdated(updatedProduct) {
    const idx = products.value.findIndex(p => p.id === updatedProduct.id)
    if (idx !== -1) {
        products.value.splice(idx, 1, updatedProduct)
    }
}

async function handleProductDeleted(deleted) {
    const deletedId = deleted && deleted.id ? deleted.id : deleted
    const idx = products.value.findIndex(p => p.id === deletedId)
    if (idx !== -1) {
        products.value.splice(idx, 1)
    }
    showConfirmDeleteModal.value = false
    selectedProduct.value = null
    // Refresh current paginated page from server to keep list consistent
    await loadProducts()
}
</script>

<template>
    <div class="mb-4 text-start flex items-center justify-between">
        <filter-products-button :categories="props.categories" @update:categories="handleCategoriesUpdate" />
        <div>
            <input
                v-model="search"
                type="search"
                placeholder="Search products..."
                class="border p-2 rounded"
                aria-label="Search products"
                @keyup.enter="navigateToSearch"
            />
            <button type="button" class="ml-2 px-3 py-2 bg-indigo-600 text-white rounded" @click="navigateToSearch">Search</button>
        </div>
    </div>

    <div class="min-h-60 overflow-auto">
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
                            <tr v-if="products.length === 0">
                                <td colspan="5" class="px-6 py-20 text-center text-gray-500">
                                    No products found for selected categories.
                                </td>
                            </tr>
                            <!-- Example Row -->
                            
                            <tr v-for="product in products" :key="product.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ product.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ product.category ? product.category.name : '' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ product.stock_quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">₱{{ Number(product.price).toFixed(2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="text-indigo-600 hover:text-indigo-900" @click="editProduct(product)">Edit</button>
                                    <button class="text-red-600 hover:text-red-900 ml-4" @click="deleteProduct(product)">Delete</button>
                                </td>
                            </tr>
                     
                           
                            
                            <!-- More rows... -->
                        </tbody>
        </table>
    </div>

    <div class="mt-4">
        <div v-if="loading" class="text-sm text-gray-500 mb-2">Loading...</div>
    </div>

                    <update-product-modal
                        v-if="showEditModal"
                        :product="selectedProduct"
                        :categories="props.categories"
                        @close="showEditModal = false"
                        @updated="handleProductUpdated"
                    ></update-product-modal>
                    <delete-confirmation-modal
                        v-if="showConfirmDeleteModal"
                        :selected-item="selectedProduct"
                        @close="showConfirmDeleteModal = false"
                        @confirmed="handleProductDeleted"
                    >
                    </delete-confirmation-modal>
</template>