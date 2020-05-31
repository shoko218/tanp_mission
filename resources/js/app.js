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

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

window.onload = function onload(){
    var hb_btn=document.getElementById("hb_menu_btn");
    var hb_menu=document.getElementById("hb_menu");
    var cover=document.getElementById("darker");
    var hb_btn_img=document.getElementById("hb_menu_btn_img");
    console
    hb_btn.addEventListener("click", function() {
        if(hb_btn.classList.contains("open")){
            hb_btn.className = "";
            hb_menu.className="hb_menu_close";
            cover.style.visibility="hidden";
            hb_btn_img.setAttribute('src','https://tanp_mission.jp/image/bars.png');
        }else{
            hb_btn.className = "open";
            hb_menu.className="hb_menu_open";
            cover.style.visibility="visible";
            hb_btn_img.setAttribute('src','https://tanp_mission.jp/image/x.png');
        }
    });
}
