import "./bootstrap";
import { createApp, h } from "vue";
import AddProductModal from "./components/AddProductModal.vue";

// Mount AddProductModal directly into a dedicated root if present
const modalRoot = document.getElementById("addProductModalRoot");
if (modalRoot) {
    const categories = modalRoot.dataset.categories
        ? JSON.parse(modalRoot.dataset.categories)
        : [];
    const action = modalRoot.dataset.action || "";
    createApp({
        render: () => h(AddProductModal, { categories, action }),
    }).mount(modalRoot);
} else {
    // Fallback: mount an empty app to #app to preserve Alpine usage
    const app = createApp({});
    app.mount("#app");
}

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
