<template>
  <div>
    <input
      type="hidden"
      v-if="field.primary"
      :name="num"
      :value="editedItem[num]"
      hidden/>
    <v-text-field
      v-else-if="field.type=='string'"
      :name="num"
      v-validate="getRules(num)"
      :data-vv-name="num"
      :label="field.label"
      :value="editedItem[num]"
      :error-messages="errors.first(num) || messages[num]"
      @input="update($event,num)">
    </v-text-field>
   <v-text-field
      v-else-if="field.type=='decimal'"
      :name="num"
      :v-validate="getRules(num)"
      :data-vv-name="num"
      :label="field.label"
      :value="editedItem[num]"
      prefix="₽"
      :error-messages="errors.first(num)"
      @input="update($event.replace(',','.'),num)">
    </v-text-field>
    <v-text-field
      v-else-if="field.type=='integer' && !field.primary"
      :name="num"
      :label="field.label"
      :value="editedItem[num]"
      v-validate="getRules(num)"
      :data-vv-name="num"
      :error-messages="errors.first(num)"
      @input="update($event,num)">
    </v-text-field>
    <wysiwyg-index
      v-else-if="field.type=='text'"
      :id="editedItem['id']"
      :name="num"
      url="image-wysiwyg-upload"
      url-file="upload-file"
      type-file-upload="file"
      type-file="image-wysiwyg"
      :model="config.model"
      :value="editedItem[num]"
      @input="update($event, num)">
    </wysiwyg-index>
    <v-checkbox
      v-else-if="field.type=='boolean'"
      :label="field.label"
      :name="num"
      type="checkbox"
      v-validate="getRules(num)"
      :data-vv-name="num"
      v-model="editedItem[num]"
      @change="updateItemCheckbox($event,num)"
      :error-messages="errors.first(num)">
    </v-checkbox>
    <v-autocomplete
      :value="editedItem[num]"
      v-else-if="field.type=='selectbox'"
      @change="update($event,num)"
      :items="items"
      color="white"
      hide-no-data
      :name="num"
      item-text="title"
      item-value="id"
      :label="field.label"
      v-validate="getRules(num)"
      :data-vv-name="num"
      :error-messages="errors.first(num)"
      placeholder="Введите поисковую фразу">
      <template slot="selection" slot-scope="data">
        {{ data.item.title }}
      </template>
    </v-autocomplete>
  </div>
</template>
<script>
  import {mapState} from 'vuex'

  export default {
    name: 'FormBuilder',
    $_veeValidate: {
      validator: 'new',
    },
    props: {
      field: {
        type: Object,
        required: true
      },
      num: {
        type: String,
        required: true
      },
      editedItem: {
        type: Object,
        required: true
      },
      rules: {
        type: Object,
        required: true
      },
      config: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        module: null
      }
    },
    mounted() {
      if (this.field.type == 'selectbox') {
        this.module = this.config.upLinks.find(item => item.column === this.num).module
        this.$store.getters[this.module + '/getByKey'](this.$store.getters[this.module + '/items'])
      }
    },
    computed: {
      ...mapState('initializer', ['messages']),
      items() {
        return this.$store.getters[this.module + '/items']
      },
    },
    methods: {
      getRules(num) {
        return !_.isUndefined(this.rules[num]) ? '' + this.rules[num] : ''
      },
      update(value, key) {
        this.$emit('update', {[key]: value})
      },
      updateItemCheckbox(value, key) {
        this.$emit('update', {[key]: Boolean(value)})
      }
    }
  }
</script>