<template>
  <div class="container graph-container">
    <div v-if="this.chartHistory.chart" class="alert alert-danger text-justify" role="alert">
      <p class="text-center">
     <strong>Unesite odgovarajuće parametre u polje za datum</strong>
    </p>
    </div>
  <div v-if="!this.loading" class="d-flex justify-content-center"> <!-- Parts that will be visible before compiled your HTML -->
    <div class="spinner"></div> <!-- this is a cool spinner taken from spinKit -->
  </div>
  <div v-if="this.loading">          
    <line-chart 
    :chart-data="datacollection" 
    :options="options"
    :height="300">
    </line-chart>
  </div>
  </div> 
</template>

<script>
import { mapGetters } from "vuex";
import LineChart from './LineChart.js'
export default {
  name: "history",
  computed: {...mapGetters(["chartHistory"]),
    chartData: function() {
     return this.data = this.chartHistory.chartValue.map(function(item) { return parseFloat(item).toFixed(1)  });
    },
    chartLoader: function() {
     return this.data = this.chartHistory.chartLoader;
    }
  },
  components: {
    LineChart
  },
  data(){
    return {
      loading:true,
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
  created(){
   this.fillData() 
  },

  methods: {
    fillData ()
    {
      
      this.datacollection = {
        labels: this.chartHistory.chartDate,
        datasets: [
          {
            label: 'Brzina vetra',
            backgroundColor: '#f8f9fa00',
            data:this.chartHistory.chartValue.map(function(item) { return parseFloat(item).toFixed(1)  }),
            borderColor: '#3490dc',
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
          display: true,
          categoryPercentage: 0.5,
          scaleLabel: {
            display: true,
            labelString: 'Vreme prosek po minuti'
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
    chartLoader: function (val) {
          this.loading=this.chartHistory.chartLoader
        }
  }
}
</script>

<style lang="css">
.graph-container {
    padding-top: 4rem;
}
.small {
  max-width: 800px;
  /* max-height: 500px; */
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
.nopadding {
   padding: 0 !important;
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