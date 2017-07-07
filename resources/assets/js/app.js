
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('loader', require('./components/core/loader.vue'));
Vue.component('stock-item', require('./components/StockItem.vue'));
Vue.component('settings', require('./components/Settings.vue'));
Vue.component('purchase-order', require('./components/PurchaseOrder.vue'));
Vue.component('sale', require('./components/sale.vue'));
Vue.component('Editpurchaseorder', require('./components/EditPurchaseOrder.vue'));
Vue.component('purchaseorderreceive', require('./components/PurchaseOrderReceive.vue'));
Vue.component('showpurchaseorder', require('./components/ShowPurchaseOrder.vue'));

const app = new Vue({
    el: '#app',
    data: {
        isLoading: false
    }
});

require('./helpers');
