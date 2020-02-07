<template>
  <v-row justify="center" align="center" class="no-gutters">
    <v-col v-for="section in sections" :key="section.id" :class="[{borderSel: current === section.id}, section.url_key]" @click="setSection({'section_id': section.id})"/>
  </v-row>
</template>

<script>
  import axios from 'axios'
  import { mapActions, mapGetters, mapState } from 'vuex'

  export default {
    name: 'SectionButtons',
    computed: {
      ...mapState('sections', {sections: 'items', current: 'current'})
    },
    methods: {
      ...mapActions('sections', ['setSection'])
    }
  }
</script>

<style scoped>
  .birds {
    background: url('/images/chicken-img-panel.png') center center no-repeat;
    background-size: 217px;
    padding-bottom: 150px;
    max-width: 250px;
    display: block;
  }

  .pigs {
    background: url('/images/pig-img-panel.png') center center no-repeat;
    background-size: 217px;
    padding-bottom: 150px;
    max-width: 250px;
    display: block;
  }

  .cows {
    background: url('/images/cow-img-panel.png') center center no-repeat;
    background-size: 217px;
    padding-bottom: 150px;
    max-width: 250px;
    display: block;
  }

  .others {
    background: url('/images/bar-img-panel.png') center center no-repeat;
    background-size: 217px;
    padding-bottom: 150px;
    max-width: 250px;
    display: block;
  }
</style>