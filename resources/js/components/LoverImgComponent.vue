<template><!--アイコンの選択、リアルタイムプレビュー-->
    <li class="input_parts">
        <label for="image">写真(jpeg,png形式、10MB以下)</label>
        <input id="image" type="file" name="image" accept="image/jpeg, image/png" class="image" @change="onFileChange($event)">
        <p v-for="errMsg in errMsgs" :key="errMsg.id" class="form_alert">{{ errMsg }}</p>
        <p>プレビュー</p>
        <div class="preview_lover_imgs" v-if="selectedImg!=null"><!--新しく選択した画像がある場合-->
            <div class="lover_img">
                <img :src="selectedImg" alt="プレビュー画像">
            </div>
        </div>
        <div class="preview_lover_imgs" v-else-if="s3Url!=null"><!--S3に画像がある場合-->
            <div class="lover_img">
                <img :src="s3Url" alt="プレビュー画像">
            </div>
        </div>
        <div class="preview_lover_imgs" v-else-if="imgPath!=null"><!--ローカルストレージに画像がある場合-->
            <div class="lover_img">
                <img :src="'/storage/lover_imgs/'+imgPath" alt="プレビュー画像">
            </div>
        </div>
        <div class="preview_lover_imgs" v-else><!--選択している画像がない場合-->
            <div class="lover_img">
                <img :src="'/image/somethings/lover_img_preview.jpg'" alt="プレビュー画像">
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        props: {
            errMsgs: {//エラーメッセージ
                type: Array,
            },
            imgPath: {//ローカルストレージへのパス
                type: String,
            },
            s3Url: {//S3へのパス
                type: String,
            },
        },
        data(){
            return {
                dataErrMsgs: this.errMsgs,//エラーメッセージ
                selectedImg: null//新しく選ばれた画像
            }
        },
        methods:{
            onFileChange(e){//画像選択
                const files = e.target.files;
                if(files.length > 0) {
                    const file = files[0];
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.selectedImg = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    }
</script>
