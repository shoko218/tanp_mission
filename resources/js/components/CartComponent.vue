<template><!--カート-->
    <div>
        <div class="alert alert-danger alert-dismissible fade show msg_box" v-if="errMsg!=''"><!--エラーメッセージ表示-->
            {{ errMsg }}
            <button type="button" class="close" @click="deleteErrMsg()">&times;</button>
        </div>
        <div v-if="dataCartGoods.length>0||dataProducts.length>0"><!--カートに商品がある場合-->
            <div id="orders">
                <div v-if="dataCartGoods.length > 0" class="od_cards"><!--会員登録をしている場合(DBカート)-->
                    <div v-for="dataProduct in dataCartGoods" :key="dataProduct.id" class="product_card"><!--商品表示-->
                        <a :href="'/product?id='+dataProduct.product.id">
                            <img :src="'/image/products/'+('00000'+dataProduct.product.id).slice( -5 )+'.jpg'" :alt="dataProduct.title" class="product_card_img">
                            <div class="product_detail cart_card_detail">
                                <p class="rc_title">{{ dataProduct.product.name }}</p>
                                <p class="rc_genre">{{ dataProduct.product.genre.name }}</p>
                                <p class="rc_price">{{ new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(dataProduct.product.price) }}(+tax)</p>
                            </div>
                        </a>
                        <input type="hidden" name="product_id" :value="dataProduct.product.id">
                        <div class="cart_action_btns"><!--カートにある商品を操るボタン-->
                            <div class="cart_change_count">
                                <button v-on:click="minus(dataProduct.product.id)" class="cart_minus_btn">-</button>
                                <p>{{ dataProduct.count }}</p>
                                <button v-if="dataProduct.count>254" class="cart_cannot_plus_btn" type="button">+</button>
                                <button v-else v-on:click="plus(dataProduct.product.id)" class="cart_plus_btn">+</button>
                            </div>
                            <p v-on:click="comp_out(dataProduct.product.id)" class="delete_btn"><u>削除</u></p>
                        </div>
                    </div>
                </div>
                <div v-else class="od_cards"><!--会員登録をしていない場合(Cookieカート)-->
                    <div v-for="(dataProduct,i) in dataProducts" :key="dataProduct.id" class="product_card"><!--商品表示-->
                        <a :href="'/product?id='+dataProduct.id">
                            <img :src="'/image/products/'+('00000'+dataProduct.id).slice( -5 )+'.jpg'" :alt="dataProduct.title" class="product_card_img">
                            <div class="product_detail">
                                <p class="rc_title">{{ dataProduct.name }}</p>
                                <p class="rc_genre">{{ dataProduct.genre.name }}</p>
                                <p class="rc_price">¥{{ dataProduct.price }}(+tax)</p>
                            </div>
                        </a>
                        <input type="hidden" name="product_id" :value="dataProduct.productId">
                        <div class="cart_action_btns"><!--カートにある商品を操るボタン-->
                            <div class="cart_change_count">
                                <button v-on:click="minus(dataProduct.id)" class="cart_minus_btn">-</button>
                                <p>{{ dataProductCount[i] }}</p>
                                <button v-if="dataProductCount[i]>254" class="cart_cannot_plus_btn" type="button">+</button>
                                <button v-else v-on:click="plus(dataProduct.id)" class="cart_plus_btn">+</button>
                            </div>
                            <p v-on:click="comp_out(dataProduct.id)" class="delete_btn"><u>削除</u></p>
                        </div>
                    </div>
                </div>
            </div>
            <p class="cart_sum">商品合計:<b>¥{{ new Intl.NumberFormat().format(dataSumPrice)}}</b></p><!--合計金額-->
            <div class="btns">
                <button onclick="location.href='/purchase/fillin_info'">購入手続きへ→</button>
            </div>
        </div>
        <div v-else><!--カートに商品がない場合-->
            <div class="nothing_msgs">
                <p class="nothing_msg">まだ商品はありません。</p>
                <div class="btns">
                    <button onclick="location.href='/search'">商品を探しに行く</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            cartGoods: {//DBカートの中身
                type: Array,
            },
            sumPrice: {//合計金額
                type: Number,
            },
            products: {//Cookieカートの中身(商品のみ)
                type: Array,
            },
            productCount: {//Cookieカートの中身(個数のみ)
                type: Array,
            },
        },
        data(){
            return {
                dataCartGoods: this.cartGoods,//DBカートの中身
                dataSumPrice: this.sumPrice,//合計金額
                dataProducts: this.products,//Cookieカートの中身(商品のみ)
                dataProductCount: this.productCount,//Cookieカートの中身(個数のみ)
                errMsg:'',
            }
        },
        methods: {
            plus(productId){//カートの中の選択した商品の個数を1つ増やす
                var post_data = {
                    'product_id': productId,
                };
                axios.post('cart/plus',post_data).then(res => {//情報更新
                    this.dataCartGoods=res.data.cart_goods,
                    this.dataSumPrice=res.data.sum_price,
                    this.dataProducts=res.data.products,
                    this.dataProductCount=res.data.product_count
                });
            },
            minus(productId){//カートの中の選択した商品の個数を1つ減らす
                var post_data = {
                    'product_id': productId,
                };
                axios.post('cart/minus',post_data).then(res => {//情報更新
                    this.dataCartGoods=res.data.cart_goods,
                    this.dataSumPrice=res.data.sum_price,
                    this.dataProducts=res.data.products,
                    this.dataProductCount=res.data.product_count,
                    this.errMsg=res.data.errMsg
                });
            },
            comp_out(productId){//カートの中の選択した商品カートからなくす
                var post_data = {
                    'product_id': productId,
                };
                axios.post('cart/complete_out',post_data).then(res => {//情報更新
                    this.dataCartGoods=res.data.cart_goods,
                    this.dataSumPrice=res.data.sum_price,
                    this.dataProducts=res.data.products,
                    this.dataProductCount=res.data.product_count,
                    this.errMsg=res.data.errMsg
                });
            },
            deleteErrMsg(){//エラーメッセージを消す
                this.errMsg='';
            }
        }
    }
</script>
