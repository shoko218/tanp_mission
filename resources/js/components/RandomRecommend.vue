<template><!--ランダムレコメンド-->
    <section id="random_recommend">
        <div class="random_recommend_contents">
            <div class="description">
                <h2>ランダムレコメンド</h2>
                <p class="comment">こんな商品はいかがですか？</p>
            </div>
            <p class="reload_btn"><a v-on:click="change"><i class="fas fa-sync-alt"></i></a></p>
            <div class="product_card">
                <a :href="'/product?id='+dataProductId" onclick="gtag('event','click', {'event_category': 'link','event_label': 'ランダムレコメンド'});">
                    <img :src="'/image/products/'+('00000'+dataProductId).slice( -5 )+'.jpg'" :alt="dataTitle" class="product_card_img">
                    <div class="product_detail">
                        <p class="rc_title">{{ dataTitle }}</p>
                        <p class="rc_genre">{{ dataGenre }}</p>
                        <p class="rc_price">{{ new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(dataPrice) }}(+tax)</p>
                    </div>
                </a>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name:'random-recommend',
        props: {
            productId: {//商品id
                type: Number,
            },
            title: {//商品名
                type: String,
            },
            genre: {//商品のジャンル
                type: String,
            },
            price: {//商品の値段
                type: String,
            },
        },
        data(){
            return {
                dataProductId: this.productId,//商品id
                dataTitle: this.title,//商品名
                dataGenre: this.genre,//商品のジャンル
                dataPrice: this.price,//商品の値段
            }
        },
        methods: {
            change(){//別の商品を表示
                axios.get('/change').then(res => {
                    this.dataProductId=res.data.rand_product.id,
                    this.dataTitle=res.data.rand_product.name,
                    this.dataGenre=res.data.rand_product_genre,
                    this.dataPrice=res.data.rand_product.price
                });
            }
        }
    }
</script>
