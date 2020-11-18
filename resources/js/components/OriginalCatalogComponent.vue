<template><!--オリジナルカタログ一覧画面-->
    <div>
        <div class="tabs"><!--ステータス別タブ-->
            <button v-bind:class="[currentId==0 ? 'active_tab' : 'inactive_tab']" @click="tab(0)" class="">作成中</button>
            <button v-bind:class="[currentId==1 ? 'active_tab' : 'inactive_tab']" @click="tab(1)" class="">送信済み</button>
            <button v-bind:class="[currentId==2 ? 'active_tab' : 'inactive_tab']" @click="tab(2)" class="">返答あり</button>
        </div>
        <div class="oc_cards" v-if="result.length!==0"><!--オリジナルカタログ一覧-->
            <div v-for="catalog in result" :key="catalog.id" class="oc_card">
                <a :href="'/mypage/original_catalog/'+catalog.id">
                    <img :src="'/image/catalog_imgs/'+('00000'+catalog.img_num).slice( -5 )+'.jpg'" :alt="catalog.name+'さんへのギフトカタログのイメージ画像'" class="oc_img">
                    <div class="oc_detail">
                        <h3>{{ catalog.name }}さんへの<br>ギフトカタログ</h3>
                    </div>
                </a>
            </div>
        </div>
        <div v-else class="no_catalog_msg">
            <h3>該当するカタログはありません。</h3>
        </div>
        <paginate
            v-model="page"
            :page-count="pageCount"
            :page-range="10"
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
            csrf: {//csrfトークン
                type: String,
                required: true,
            },
        },
        data(){
            return {
                currentId: 0,//今選択しているステータス
                results:Object(),//該当タブ全体
                result:Object(),//現在のページネーションで表示する該当タブ
                page: 1,//現在のページネーションのページ
                pageCount: 0,//最大ページ
                numOfPage:12//1ページで表示する要素数
            }
        },
        mounted() {
            this.currentId=0
            var param = {
                'kind': this.currentId,
            };
            axios.post('/mypage/original_catalog/result_get',param).then(res => {//データ更新
                this.results=res.data.results
                this.pageCount=Math.ceil(this.results.length/this.numOfPage)
                this.results["length"]=this.results.length
                this.result=Array.prototype.slice.call(this.results, 0,this.numOfPage);
            });
        },
        methods: {
            tab(kind){//タブ切り替え
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
            pageChange(){//ページネーションのページ変更
                this.result=Array.prototype.slice.call(this.results, this.numOfPage*(this.page-1),this.numOfPage*this.page);
            }
        },
    }
</script>
