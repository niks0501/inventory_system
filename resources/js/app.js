import "./bootstrap";
import { createApp, h } from "vue";
import AddProductModal from "./components/AddProductModal.vue";
import ProductTable from "./components/ProductTable.vue";

// Create separate Vue apps and mount them to specific DOM roots to avoid id conflicts
const modalApp = createApp({});
modalApp.component("add-product-modal", AddProductModal);
modalApp.mount("#modal-root");

const productsApp = createApp({});
productsApp.component("product-table", ProductTable);
productsApp.mount("#products-vue");

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
