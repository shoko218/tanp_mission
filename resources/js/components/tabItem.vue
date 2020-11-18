<template><!--オリジナルカタログのジャンル別タブ-->
  <button @click="$emit('input', id)" :class="[active, 'tab']">
    {{ label }}
  </button>
</template>

<script>
export default {
  props: {
    id: Number,
    label: String,
    value: Number
  },
  computed: {
    active() {//選択されているタブを変更
      return this.value === this.id ? 'active' : false
    }
  }
}
</script>
