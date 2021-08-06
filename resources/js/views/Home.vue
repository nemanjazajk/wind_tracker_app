<template>
<div class="container">
    <div class="row justify-content-center">
        <div v-bind:class="ColMdGadget">
            <GoogleGadget /> 
        </div>
        <div v-if="HiddenButtons.length" class="col-md-3">   
            <Buttons />
        </div>
        <div v-bind:class="ColMdTable">  
            <Table /> 
        </div>
        <div class="col-md-9"> 
            <CurrentGraph />
        </div>
    </div>
</div>
</template>
<script>
import Buttons from "../components/Buttons";
import Table from "../components/Table";
import GoogleGadget from "../components/GoogleGadget";
import CurrentGraph from "../components/CurrentGraph";
export default {
  name: 'Home',
  components:{
    Buttons,
    Table,
    GoogleGadget,
    CurrentGraph
  },
  data(){
    return {
        user:'',
        HiddenButtons :'',
        ColMdGadget   :'col-md-4',
        ColMdTable    :'col-md-5 pl-1'
    }},
  mounted () {
           this.getUser()
  },
  methods: {
       getUser()  {
      if (this.$store.state.wind.user ==='admin'){
        this.HiddenButtons = 'response.data.id',
        this.ColMdGadget   = 'col-md-3',
        this.ColMdTable    = 'col-md-3 pl-1'}
      else{
        this.HiddenButtons = '',
        this.ColMdGadget   = 'col-md-4',
        this.ColMdTable    = 'col-md-5 pl-1'
      }
      },
  },
  watch: {
    thisUser: function (val) {
          this.getUser()
        }
  },
  computed: {
    thisUser: function() {
     return this.user = this.$store.state.wind.user;
    },
  },
};

</script>