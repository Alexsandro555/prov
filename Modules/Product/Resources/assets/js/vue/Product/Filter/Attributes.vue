<template>
  <div>
    <template v-for="item in items">
      <v-checkbox class="ma-0 pa-0" :value="item.id" v-model="checkedAttributes" :label="item.title" :disabled="item.disabled"></v-checkbox>
    </template>
  </div>
</template>
<script>
  export default {
    name: 'FilterableAttributes',
    props: {
      items: {
        type: Array,
        default: () => []
      },
      checked: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        checkedAttributes: []
      }
    },
    watch: {
      checkedAttributes() {
        this.$emit('attributechanged', this.checkedAttributes)
      },
      checked(values, oldValues) {
        if(!_.isEqual(values, oldValues)) {
          this.checkedAttributes = values
        }
      }
    }
  }
</script>