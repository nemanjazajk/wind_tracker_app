<template>
  <div v-if="getValues.length" class="gauge-chart" >
    <GChart
      class = "chart_div"
      type="Gauge"
      :settings="{ packages: ['gauge'] }"
      :data="chartData"
      :options="chartOptions"
      range
    />
  </div>
</template>
<script>
import { GChart } from 'vue-google-charts'
import { mapGetters } from "vuex";
export default {
  name: 'Gadget',
  components: {
    GChart
  },
  data () {
    return {
      value:this.gaugeValue,
      GaugeData:'',
      chartData: [
        ['Label', 'Value'],
        ['Vetar',this.value ],
      ],
      chartOptions: {
        animation: {
        duration: 5000,
        easing: "out"
         },
        min: 0,
        max: 120,
        width: 280,
        height: 280,
        greenFrom: 0,
        greenTo: 15,
        redFrom: 21,
        redTo: 120,
        yellowFrom: 15,
        yellowTo: 21,
        minorTicks: 5
      }
    }
  },
  computed: {...mapGetters(['getValues']),
  gaugeValue: function() {
      return this.GaugeData = this.getValues.slice(-1)[0];
      }
  },
  mounted() {
      let val = this.$store.state.wind.indicaton.currentWindSpeed 
      this.chartData=[
        ['Label', 'Value'],
        ['Vetar', val],
      ]
        
  },
  created() {
    window.addEventListener("resize", this.reponsive);
      this.reponsive ()
  },
  destroyed() {
  window.removeEventListener("resize", this.reponsive);
},
  methods:{
      reponsive (){
        const expr = window.innerWidth;
        if (expr>=1200) {
            this.chartOptions.height = 280
            this.chartOptions.width = 280}
            else if (expr < 1200 && expr > 990) 
            {
            this.chartOptions.height = 235
            this.chartOptions.width = 235
            }
            else if (expr < 990 && expr > 770) 
            {
            this.chartOptions.height = 175
            this.chartOptions.width = 175
            }
            else if (expr < 770 && expr > 515) {
            this.chartOptions.height = 480
            this.chartOptions.width = 480
          }
          else if (expr < 515 ) {
            this.chartOptions.height = expr*0.86
            this.chartOptions.width = this.chartOptions.height
          }
    },
  },
watch: {
  gaugeValue: function (val) {
     this.chartData=[
        ['Label', 'Value'],
        ['Vetar',parseFloat( Number(val).toFixed(1))],
      ]
        },
}
}
</script>
<style scoped>
    .gauge-chart {
        margin:auto 0 auto auto !important;
    }
    





</style>