<template>
  <div v-if="getValues.length" class="table-height">
    <table class="table table-mod">
      <tbody>
        <tr>
          <th scope="row">Status ventilatora</th>
          <td>{{ getindicaton.balloonUp }}</td>
        </tr>
        <tr>
          <th scope="row">Status balona</th>
          <td>{{ getindicaton.currentState }}</td>
        </tr>
        <tr>
          <th scope="row">Status svetlo</th>
          <td>{{ getindicaton.led }}</td>
        </tr>
        <tr>
          <th scope="row">Dozvoljena brzina</th>
          <td><input class="form-control" 
                    @input="changed" 
                    name="flavor" 
                    :placeholder= "[[maxWind]]" ></td>
        </tr>
        <tr>
          <th scope="row">Granična brzina</th>
          <td><input class="form-control" 
                    @input="changed2" 
                    name="flavor2" 
                    :placeholder= "[[maxWind2]]" ></td>
        </tr>
      </tbody>
    </table>
   </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  name: "Table",
  methods: {
    changed: function(event) {
      this.$store.commit('SET_MAX', event.target.value)},
      changed2: function(event) {
      this.$store.commit('SET_MAX2', event.target.value)},

    ...mapActions(['fetchTodos']),

    storeValue:function(event){
          this.value = event.target.value
        }
  },
  computed: mapGetters(['getValues','getindicaton','maxWind','maxWind2']),
  
  created(){
    
  },
  data () {
    return {
      value:''
    }}
};
</script>
<style>
  .table-mod{
    padding-bottom: none !important;
  }
  .table-mod th {
    width:150px;
  }
  .table-height{
    padding-top: 14px !important;
  }
  @media all and (max-width: 515px) and (min-width: 200px) {
  .table-height {
    padding: 0px 22px 0px 30px !important;
  }
}
</style>