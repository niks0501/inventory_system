<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits(['update:categories'])

const selected = ref([])

watch(selected, (newValue) => {
    emit('update:categories', newValue)
})
</script>

<template>
    <div class="filter-wrapper">
        <button class="filter-btn">
            Filter Categories
        </button>

        <div class="filter-dropdown">
            <label
                v-for="category in categories"
                :key="category.id"
                class="filter-item"
            >
                <input
                    type="checkbox"
                    :value="category.id"
                    v-model="selected"
                />
                {{ category.name }}
            </label>
        </div>
    </div>
</template>
