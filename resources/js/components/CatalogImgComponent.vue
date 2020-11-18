<template><!--カタログのイメージ画像選択-->
    <li class="input_parts">
        <label for="img_num">イメージ画像</label>
        <select name="img_num" id="img_num" v-model="selectedImgNum" required>
            <option value="0" selected disabled>選択してください</option>
            <option value="4">フラワー(ブルー)</option>
            <option value="5">フラワー(パステルピンク)</option>
            <option value="13">フラワー(ホワイト)</option>
            <option value="9">バラ(ピンク)</option>
            <option value="10">バラ(ブルー)</option>
            <option value="11">ハート型の花(ピンクピンク)</option>
            <option value="12">ハート型の花(ピンクホワイト)</option>
            <option value="14">ハート型の花(カラフル)</option>
            <option value="1">バースデーカード</option>
            <option value="2">バースデーキャンドル</option>
            <option value="3">バースデーガーランド</option>
            <option value="6">サンキュー(キュート)</option>
            <option value="7">サンキュー(エレガント)</option>
            <option value="8">サンキュー(ポップ)</option>
            <option value="15">サンキュー(シック)</option>
            <option value="16">サンキュー(フラワー)</option>
        </select>
        <p v-for="errMsg in errMsgs" :key="errMsg.id" class="form_alert">{{ errMsg }}</p>
        <div class="preview_imgs" v-if="selectedImgNum!=''">
            <p>プレビュー</p>
            <p>
                <img :src="'/image/catalog_imgs/'+('00000'+selectedImgNum).slice( -5 )+'.jpg'" alt="プレビュー画像"><!--選んだものがリアルタイムでプレビューされる-->
            </p>
        </div>
    </li>
</template>

<script>
    export default {
        props: {
            errMsgs: {//エラーメッセージ
                type: Array,
            },
            oldImgNum: {//選択していた画像の番号
                type: String,
            },
        },
        data(){
            return {
                dataErrMsgs: this.errMsgs,//エラーメッセージ
                selectedImgNum: this.oldImgNum,//選択していた画像の番号
            }
        },
    }
</script>
