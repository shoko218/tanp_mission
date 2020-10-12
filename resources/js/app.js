/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')
import Vue from 'vue'
import GoodComponent from './components/GoodComponent'
import CartComponent from './components/CartComponent'
import CatalogImgComponent from './components/CatalogImgComponent'
import LoverImgComponent from './components/LoverImgComponent'
import OriginalCatalogComponent from './components/OriginalCatalogComponent'
// import StripeComponent from './components/StripeComponent'
import RandomRecommend from './components/RandomRecommend'
import VueAnalytics from 'vue-analytics'

// window.Vue = require('vue');

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

const app = new Vue({
    el: '#app',
    components: {
        GoodComponent,CartComponent,RandomRecommend,CatalogImgComponent,LoverImgComponent,OriginalCatalogComponent,
    },
});

Vue.use(VueAnalytics, {
    id: 'UA-179570799-1'
})

window.onload = function onload(){
    var hb_btn=document.getElementById("hb_menu_btn");
    var hb_menu=document.getElementById("hb_menu");
    var cover=document.getElementById("darker");
    var hb_btn_img=document.getElementById("hb_menu_btn_img");
    var change_btn=document.getElementById("change_btn");
    var target_scene_id=document.getElementById("target_scene_id");
    var target_genre_id=document.getElementById("target_genre_id");
    var target_relationship_id=document.getElementById("target_relationship_id");
    var target_gender=document.getElementById("target_gender");
    var target_generation_id=document.getElementById("target_generation_id");
    var inputs=document.getElementById("inputs");
    var search_bar=document.getElementById("search_bar");
    var add_condition=document.getElementById("add_condition");
    var option_condition=document.getElementById("option_condition");
    if(change_btn!=null){
        if(search_bar.value!=''){
            search_bar.style.display ="block";
            inputs.style.display ="none";
            change_btn.innerHTML="条件検索にする"
            change_btn.className = "key_to_conditions_btn";
        }else{
            inputs.style.display ="block";
            search_bar.style.display ="none";
            change_btn.innerHTML="キーワード検索にする"
            change_btn.className = "conditions_to_key_btn";
            if(target_genre_id.value!=''||target_gender.value!=''||target_generation_id.value!=''){{
                option_condition.style.display ="block";
                add_condition.style.display ="none";
            }}
        }
    }

    $('html').removeClass('scroll-prevent');
    hb_btn.addEventListener("click", function() {
        if(hb_btn.classList.contains("open")){
            hb_btn.className = "";
            hb_menu.className="hb_menu_close";
            cover.style.visibility="hidden";
            hb_btn_img.setAttribute('src','/image/icons/menu.png');
            $('html').removeClass('scroll-prevent');
        }else{
            hb_btn.className = "open";
            hb_menu.className="hb_menu_open";
            cover.style.visibility="visible";
            hb_btn_img.setAttribute('src','/image/icons/x.png');
            $('html').addClass('scroll-prevent');
        }
    });
    cover.addEventListener("click", function() {
        hb_btn.className = "";
        hb_menu.className="hb_menu_close";
        cover.style.visibility="hidden";
        hb_btn_img.setAttribute('src','/image/icons/menu.png');
        $('html').removeClass('scroll-prevent');
    });

    if(change_btn!=null){
        change_btn.addEventListener("click", function() {
            if(change_btn.classList.contains("conditions_to_key_btn")){
                change_btn.className = "key_to_conditions_btn";
                inputs.style.display ="none";
                search_bar.style.display ="block";
                target_scene_id.selectedIndex=0;
                target_genre_id.selectedIndex=0;
                target_relationship_id.selectedIndex=0;
                target_gender.selectedIndex=0;
                target_generation_id.selectedIndex=0;
                change_btn.innerHTML="条件検索にする"
            }else{
                change_btn.className = "conditions_to_key_btn";
                inputs.style.display ="block";
                search_bar.style.display ="none";
                search_bar.value="";
                change_btn.innerHTML="キーワード検索にする"
            }
        });
    }
    if(add_condition!=null){
        add_condition.addEventListener("click", function() {
            option_condition.style.display ="block";
            add_condition.style.display ="none";
        });
    }
}

