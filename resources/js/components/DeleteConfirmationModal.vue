<script setup>
import { ref } from 'vue'

const props = defineProps({
  selectedItem: { type: Object, required: false },
})

const emit = defineEmits(['close', 'confirmed'])

const loading = ref(false)

const csrf = document
  .querySelector('meta[name="csrf-token"]')
  ?.getAttribute('content')

async function confirmDeletion() {
  if (!props.selectedItem || !props.selectedItem.id) return
  if (!csrf) {
    console.error('CSRF token not found')
    return
  }

  loading.value = true

  try {
    const res = await fetch(`/products/${props.selectedItem.id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
    })

    if (!res.ok) {
      const err = await res.json().catch(() => ({}))
      console.error('Delete failed', err)
      loading.value = false
      return
    }

    // Emit confirmed with deleted item id (or full item)
    emit('confirmed', props.selectedItem.id)
    emit('close')
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
  }
}

function cancel() {
  emit('close')
}
</script>

<template>
  <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 flex items-center justify-center bg-black/50 p-4" aria-hidden="true"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 relative z-20">
        <div>
          <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete Product</h3>
          <div class="mt-2">
            <p class="text-sm text-gray-500">
              Are you sure you want to delete "{{ selectedItem ? selectedItem.name : '' }}"? This action cannot be undone.
            </p>
          </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
          <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm" :disabled="loading" @click="confirmDeletion">
            <span v-if="!loading">Delete</span>
            <span v-else>Deleting...</span>
          </button>
          <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="cancel">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</template>