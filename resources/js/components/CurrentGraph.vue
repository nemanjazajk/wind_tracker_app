<template>
  <div class="container">
    <div v-if="!getValues.length" class="d-flex justify-content-center"> <!-- Parts that will be visible before compiled your HTML -->
      <div class="spinner"></div> <!-- this is a cool spinner taken from spinKit -->
    </div>
  <div v-if="getValues.length"> 
    <div v-if="!getindicaton.connectionError" class="alert alert-danger text-justify" role="alert">
      <p class="text-center">
        <strong> PREKINUTA JE KONEKCIJA SA UREDJAJEM!!!</strong>
      </p>
    </div>
   <div v-if="getindicaton.errorMessage.length" class="alert alert-danger text-justify" role="alert">
    <p class="text-center">
      <strong>{{ getindicaton.errorMessage }}</strong>
    </p>
  </div>
  <line-chart 
    :chart-data="datacollection" 
    :options="options"
    :height="300">
  </line-chart>
  </div>
</div>
</template>

<script>
import LineChart from './LineChart.js'
import { mapGetters, mapActions } from "vuex";
export default {
  name: "Graph",
  computed: {...mapGetters(["getLables", "getValues","getAlert",'maxWind','maxWind2',"getindicaton"]),
    chartData: function() {
     return this.currChData = this.getValues;
    },
    maxWindTwo: function() {
     return this.maxWindTw = this.maxWind2;
    },
    maxWindOne: function() {
     return this.maxWindOn = this.maxWind;
    },
  },
  components: {
    LineChart,
  },
  data(){
    return {
      loading:false,
      maxWindTw:'',
      maxWindOn:'',
      datacollection:  {
      type: Object,
      default: null
    },
    options:  {
      type: Object,
      default: null
    }
    }
  },

  mounted () {
    this.fillData() 
  },
  methods: {...mapActions(['getGraphVal','tableStats']),
    fillData ()
    {
      const maxWi=Number(this.maxWind)
      const maxWi2=Number(this.maxWind2)
      this.datacollection = {
        labels: this.getLables
       , datasets: [
          {
            label: 'Brzina u granicama',
            backgroundColor: '#38c172',
            data: this.getValues.map(function(item) { return item > maxWi? maxWi : item; }),
            borderColor: '#38c172',
            borderWidth: 1,
            pointRadius: 0
          },
          {
            label: 'Brzina u granicama',
            backgroundColor: '#ffed4a8f',
            data: this.getValues.map(function(item) { return item > maxWi2? maxWi2 : item; }),
            borderColor: '#ffed4a8f',
            borderWidth: 1,
            pointRadius: 0
          },
           {
            label: 'Velika brzina',
            backgroundColor: '#e3342f',
            data: this.getValues,
            borderColor: '#e3342f',
            borderWidth: 1,
            pointRadius: 0
            }
        ]
      },
      this.options = {
      responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        text: 'Dijagram brzine vetra'
      },
      tooltips: {
        mode: 'index',
        intersect: false,   
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        
         xAxes: [{
                type: 'time',
                distribution: 'series',
                time: {
                    unit: 'minute',
                    tooltipFormat: 'YYYY MM DD HH:mm:ss',
                    displayFormats: {
                        minute: 'mm:ss'
                    }
                },
                scaleLabel: {
                display: true,
                labelString: 'Vreme u razmaku < 15 s'
                 }
            }],
        yAxes: [{
          ticks: {
                min: 0,
              },
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Brzina u km/h'
          }
        }]
      }
    }
    }
  },
    watch: {
    chartData: function (val) {
          this.fillData()
        },
    maxWindTwo: function (val) {
          this.fillData()
        },
    maxWindOne: function (val) {
          this.fillData()
        },
  }
}
</script>

<style lang="css">
.small {
  max-width: 800px;
  margin:  50px auto;
}
.spinner {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>