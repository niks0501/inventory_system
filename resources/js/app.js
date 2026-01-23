import "./bootstrap";
import { createApp } from "vue";
import AddProductModal from "./components/AddProductModal.vue";
import ProductTable from "./components/ProductTable.vue";

// Create Vue application and register components
const app = createApp({});
app.component("add-product-modal", AddProductModal);
app.component("product-table", ProductTable);
app.mount("#app");

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
