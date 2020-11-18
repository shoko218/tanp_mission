<template><!--いいねボタン-->
    <div>
        <input type="hidden" name="product_id" :value="productId">
        <button v-if="dataIsFav" id="fav_btn" class="favorite" v-on:click="favorite"></button>
        <button v-else id="fav_btn" class="unfavorite" v-on:click="favorite"></button>
    </div>
</template>

<script>
    export default {
        props: {
            isFav: {//いいねしているか
                type: Boolean,
            },
            productId: {//商品id
                type: String,
            },
        },
        data(){
            return {
                dataIsFav: this.isFav//いいねしているか
            }
        },
        methods: {
            favorite(){//いいね
                var fav_data = {
                    'product_id': this.productId,
                    '_token': this.csrf,
                };
                axios.post('product/favorite',fav_data).then(res => {//データ更新
                    this.dataIsFav=res.data.is_fav
                });
            }

        }
    }
</script>
