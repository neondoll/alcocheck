<template>
  <div>
    <b-table striped stacked hover :items="items" />

    <b-button ><i class="fas fa-address-book"></i></b-button>
  </div>
</template>

<script>
import {BButton,BTable} from 'bootstrap-vue'
export default {
  components: {
    BTable,
    BButton
  },
  data() {
    return {
      items: [
        { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
        { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
        { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
        { age: 38, first_name: 'Jami', last_name: 'Carney' }
      ]
    }
  }
}
</script>

<style scoped>

</style>