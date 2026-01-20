import "./bootstrap";
import { createApp, h } from "vue";
import AddProductModal from "./components/AddProductModal.vue";

const app = createApp({});

app.component("add-product-modal", AddProductModal);

// Mount Vue to a dedicated container to avoid conflicts with Alpine's `open` bindings
app.mount("#vue");

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
