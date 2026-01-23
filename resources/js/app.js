import "./bootstrap";
import { createApp } from "vue";
import AddProductModal from "./components/AddProductModal.vue";
import ProductTable from "./components/ProductTable.vue";
import UpdateProductModal from "./components/UpdateProductModal.vue";

// Create Vue application and register components
const app = createApp({});
app.component("add-product-modal", AddProductModal);
app.component("product-table", ProductTable);
app.component("update-product-modal", UpdateProductModal);
app.mount("#app");

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
