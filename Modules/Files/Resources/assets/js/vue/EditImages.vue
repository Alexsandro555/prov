<template>
  <v-container>
    <v-layout wrap row>
      <v-flex>
        <!--<edit-image :id="id" type="medium"/>-->
        <edit-image :id="id" type="main"/>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
  import EditImage from './EditImage.vue'

  export default {
    props: {
      id: {
        type: String,
        required: true
      }
    },
    components: {
      EditImage
    }
  }
</script>