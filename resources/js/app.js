import "./bootstrap";
import { createApp } from "vue";
import AddProductModal from "./components/AddProductModal.vue";
import ProductTable from "./components/ProductTable.vue";
import UpdateProductModal from "./components/UpdateProductModal.vue";
import DeleteConfirmationModal from "./components/DeleteConfirmationModal.vue";
import FilterProductsButton from "./components/FilterProductsButton.vue";

// Create Vue application and register components
const app = createApp({});
app.component("add-product-modal", AddProductModal);
app.component("product-table", ProductTable);
app.component("update-product-modal", UpdateProductModal);
app.component("delete-confirmation-modal", DeleteConfirmationModal);
app.component("filter-products-button", FilterProductsButton);
app.mount("#app");

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
