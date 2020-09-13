<template>
    <div>
        <div class="tabs">
            <button v-bind:class="[currentId==0 ? 'active_tab' : 'inactive_tab']" @click="tab(0)" class="">作成中</button>
            <button v-bind:class="[currentId==1 ? 'active_tab' : 'inactive_tab']" @click="tab(1)" class="">送信済み</button>
            <button v-bind:class="[currentId==2 ? 'active_tab' : 'inactive_tab']" @click="tab(2)" class="">返答あり</button>
        </div>
        <div class="oc_cards">
            <form v-for="catalog in result" :key="catalog.id" method="post" :name="'form'+catalog.id" action="/mypage/original_catalog/detail" class="oc_card">
                <input type="hidden" name="_token" v-bind:value="csrf">
                <input type="hidden" name="id" :value="catalog.id">
                <a :href="'javascript:form'+catalog.id+'.submit()'">
                    <img :src="'/image/catalog_imgs/'+('00000'+catalog.img_num).slice( -5 )+'.png'" :alt="catalog.name+'さんへのギフトカタログのイメージ画像'" class="oc_img">
                    <div class="oc_detail">
                        <h3>{{ catalog.name }}さんへの<br>オリジナルギフトカタログ</h3>
                    </div>
                </a>
            </form>
        </div>
        <paginate
            v-model="page"
            :page-count="pageCount"
            :page-range="1"
            :click-handler="pageChange"
            :prev-text="'<'"
            :next-text="'>'"
            :container-class="'pagination'"
            :page-class="'page-item'"
            :page-link-class="'page-link'"
            :prev-class="'page-item'"
            :prev-link-class="'page-link'"
            :next-class="'page-item'"
            :next-link-class="'page-link'">
        </paginate>
    </div>
</template>

<script>
    import Vue from 'vue';
    import Paginate from 'vuejs-paginate';
    Vue.component('paginate', Paginate);
    export default {
        props:  {
            csrf: {
                type: String,
                required: true,
            }
        },
        data(){
            return {
                currentId: 0,
                results:Object(),
                result:Object(),
                page: 1,
                pageCount: 0,
                numOfPage:1
            }
        },
        mounted() {
            this.currentId=0
            var param = {
                'kind': this.currentId,
            };
            axios.post('/mypage/original_catalog/result_get',param).then(res => {
                this.results=res.data.results
                this.pageCount=Math.ceil(this.results.length/this.numOfPage)
                this.results["length"]=this.results.length
                this.result=Array.prototype.slice.call(this.results, 0,this.numOfPage);
            });
        },
        methods: {
            tab(kind){
                this.currentId=kind
                var param = {
                    'kind': this.currentId,
                };
                axios.post('/mypage/original_catalog/result_get',param).then(res => {
                    this.results=res.data.results
                    this.pageCount=Math.ceil(this.results.length/this.numOfPage)
                    this.results["length"]=this.results.length
                    this.result=Array.prototype.slice.call(this.results, 0,this.numOfPage);
                });
                this.page=1
            },
            pageChange(){
                this.result=Array.prototype.slice.call(this.results, this.numOfPage*(this.page-1),this.numOfPage*this.page);
            }
        },
    }
</script>
