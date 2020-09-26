<template>
    <li class="input_parts">
        <label for="image">写真(jpeg,png,gif形式、10MB以下)</label>
        <input id="image" type="file" name="image" accept="image/jpeg, image/png, image/gif" class="image" @change="onFileChange($event)">
        <p v-for="errMsg in errMsgs" :key="errMsg.id" class="form_alert">{{ errMsg }}</p>
        <div class="preview_lover_imgs" v-if="selectedImg!=null">
            <p>プレビュー</p>
            <div class="lover_img">
                <img :src="selectedImg" alt="プレビュー画像">
            </div>
        </div>
        <div class="preview_lover_imgs" v-else-if="ext">
            <p>プレビュー</p>
            <div class="lover_img">
                <img :src="'/storage/lover_imgs/'+('000000000'+id).slice( -9 )+'.'+ext" alt="プレビュー画像">
            </div>
        </div>
        <div class="preview_lover_imgs" v-else>
            <p>プレビュー</p>
            <div class="lover_img">
                <img :src="'/image/somethings/lover_img_preview.png'" alt="プレビュー画像">
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        props: {
            errMsgs: {
                type: Array,
            },
            id:{
                type: String,
            },
            ext: {
                type: String,
            },
        },
        data(){
            return {
                dataErrMsgs: this.errMsgs,
                selectedImg: null
            }
        },
        methods:{
            onFileChange(e){
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
