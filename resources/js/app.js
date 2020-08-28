/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap.js');
var userId = document.querySelector("meta[name='user-id']").content;
if (userId != null)
{
    console.log(userId);
    var channel = window.Echo.channel('price');

    channel.listen('BuyOrderFilled', function(data) {
        var now = new Date().toLocaleTimeString();
        console.log(data);
        if (data.buyOrder.user_id == userId)
        {
            var toastContainer = $('#orderFillNotifierContainer');
            var toastString = '<div class="toast orderFilledToast" role="alert" aria-live="assertive" aria-atomic="true">' +
            '<div class="toast-header" style="background-color: #FFD448">' + 
                '<p style="margin: 0;"> &#x2713; </p>' +
                '<strong class="mr-auto">Buy Order Filled</strong>' +
                '<small class="text-muted">' + now + '</small>' +
                '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                '</button>' +
            '</div>' +
            '<div class="toast-body" style="background-color: #515151">' +
            data.player.handle + ' ' + data.buyOrder.amount + ' @ ' + data.buyOrder.price + 
            '</div>' +
            '</div>';

            toastContainer.append(toastString);
            $('.orderFilledToast').toast({animation : true, delay : 10000, autohide : false});
            $('.orderFilledToast').toast('show');
        }
    });
    channel.listen('SellOrderFilled', function(data) {
        var now = new Date().toLocaleTimeString();
        if (data.sellOrder.user_id == userId)
        {
            var toastContainer = $('#orderFillNotifierContainer');
            var toastString = '<div class="toast orderFilledToast" role="alert" aria-live="assertive" aria-atomic="true">' +
            '<div class="toast-header">' + 
                '<strong class="mr-auto">Buy Order Filled</strong>' +
                '<small class="text-muted">' + now + '</small>' +
                '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                '</button>' +
            '</div>' +
            '<div class="toast-body">' +
            data.player.handle + ' ' + data.sellOrder.amount + ' @ ' + data.sellOrder.price + 
            '</div>' +
            '</div>';

            toastContainer.append(toastString);
            $('.orderFilledToast').toast({animation : true, delay : 10000, autohide : false});
            $('.orderFilledToast').toast('show');
        }
    });
}
//window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/*
const app = new Vue({
    el: 'app',
});
*/
