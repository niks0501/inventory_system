<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue'

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits(['update:categories'])

const selected = ref([])
const open = ref(false)
const root = ref(null)

watch(selected, (newValue) => {
    const ids = Array.isArray(newValue) ? newValue.map(v => Number(v)) : []
    emit('update:categories', ids)
})

function toggle() {
    open.value = !open.value
}

function close() {
    open.value = false
}

function onDocClick(e) {
    if (!root.value) return
    if (!root.value.contains(e.target)) {
        close()
    }
}

onMounted(() => document.addEventListener('click', onDocClick))
onUnmounted(() => document.removeEventListener('click', onDocClick))
</script>

<template>
    <div ref="root" class="filter-wrapper relative inline-block">
        <button type="button" class="filter-btn px-3 py-2 border rounded" @click.prevent="toggle">
            Filter Categories
        </button>

        <div v-if="open" class="filter-dropdown absolute mt-2 bg-white border rounded shadow z-50 p-2">
            <label
                v-for="category in categories"
                :key="category.id"
                class="filter-item flex items-center gap-2 mb-1"
            >
                <input
                    type="checkbox"
                    :value="category.id"
                    v-model="selected"
                />
                <span>{{ category.name }}</span>
            </label>
        </div>
    </div>
</template>
