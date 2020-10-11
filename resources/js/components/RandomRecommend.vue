<template>
    <section id="random_recommend">
        <div class="description">
            <h2>ランダムレコメンド</h2>
            <p class="comment">こんな商品はいかがですか？</p>
        </div>
        <p class="reload_btn"><a v-on:click="change"><i class="fas fa-sync-alt"></i></a></p>
        <div class="product_card">
            <a :href="'/product?id='+dataProductId" onClick="ga(‘send’,’event’,’sp’,’click’,’banner’);">
                <img :src="'/image/products/'+('00000'+dataProductId).slice( -5 )+'.png'" :alt="dataTitle" class="product_card_img">
                <div class="product_detail">
                    <p class="rc_title">{{ dataTitle }}</p>
                    <p class="rc_genre">{{ dataGenre }}</p>
                    <p class="rc_price">{{ new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(dataPrice) }}(+tax)</p>
                </div>
            </a>
        </div>
    </section>
</template>

<script>
    export default {
        name:'random-recommend',
        props: {
            productId: {
                type: Number,
            },
            title: {
                type: String,
            },
            genre: {
                type: String,
            },
            price: {
                type: String,
            },
        },
        data(){
            return {
                dataProductId: this.productId,
                dataTitle: this.title,
                dataGenre: this.genre,
                dataPrice: this.price,
            }
        },
        methods: {
            change(){
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
