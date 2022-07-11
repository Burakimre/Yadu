
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app'
// });

// Vue JS chat scroll functionality on page load
! function (e, n) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = n() : "function" == typeof define && define.amd ? define(n) : e["vue-chat-scroll"] = n()
}(this, function () {
    "use strict";
    var e = function (e) {
        e.scrollTop = e.scrollHeight
    },
        n = {
            bind: function (n, t) {
                var o = void 0,
                    i = !1;
                n.addEventListener("scroll", function (e) {
                    o && window.clearTimeout(o), o = window.setTimeout(function () {
                        i = n.scrollTop + n.clientHeight + 1 < n.scrollHeight
                    }, 200)
                }), new MutationObserver(function (o) {
                    !1 === (t.value || {}).always && i || 1 != o[o.length - 1].addedNodes.length || e(n)
                }).observe(n, {
                    childList: !0,
                    subtree: !0
                })
            },
            inserted: e
        },
        t = {
            install: function (e, t) {
                e.directive("chat-scroll", n)
            }
        };
    return "undefined" != typeof window && window.Vue && window.Vue.use(t), t
});

// File name function
let input = document.getElementById('avatar');
let infoArea = document.getElementById('custom-file-label');

if (input != null) {
    input.addEventListener('change', changeFilename);
}

function changeFilename(event) {
    let input = event.srcElement;
    let fileName = input.files[0].name;

    infoArea.textContent = fileName;
}