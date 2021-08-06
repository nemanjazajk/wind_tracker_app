<template>
  <div id="calendar" class="container">
    <div class  ="container">
      <div v-if   ="errorDate.length" 
           class  ="alert alert-danger text-justify"
           role   ="alert">
        <p class  ="text-center">
           <strong >{{ errorDate }}</strong>
        </p>
    </div>
    <div v-if   ="this.$store.state.wind.dateWarning" 
           class  ="alert alert-warning text-justify"
           role   ="alert">
        <p class  ="text-center">
           <strong >ODABRANI DATUM NE POSTOJI U BAZI</strong>
        </p>
    </div>
      <h3 class ="text">Izaberite datum</h3>
      <date-picker
        ref               ="datepicker"
        :lang             ="lang"
        type              ="datetime"
        v-model           ="datetime"
        :default-value    ="new Date()"
        :disabled-date    ="disabledDate"
        :show-time-panel  ="showTimePanel"
        format            ="YYYY-MM-DD hh"
        placeholder       ="Odaberite datum i vreme"
        :multiple         ="false"
        :range            ="true"
        class             ="data-picker-style"
        @closed           ="closeDate"
      >
      <template v-slot:footer>
          <button 
            class="mx-btn mx-btn-text" 
            @click="toggleTimePanel">
              {{ showTimePanel ? 'Odaberite datum' : 'Odaberite vreme' }}
          </button>
          <button 
            class="mx-btn mx-btn-text" 
            @click="emitDate">OK
          </button>
      </template>
      </date-picker>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import DatePicker from "vue2-datepicker";
import 'vue2-datepicker/index.css';
export default {
  name: "Calendar",
  components: {
    DatePicker
  },
  
  data() {
    return {
      disData: [],
      disabledDates : [],
      closeDate: false,
      errorDate : '',
      showTimePanel: false,
      valueStart: '2020-11-11T07:01:58.000000Z',
      valueStop:  '2020-11-08T17:21:25.000000Z',
      date: '',
      timePickerOptions:{
        start: '2020-11-11T07:01:58.000000Z',
        end:   '2020-11-08T17:21:25.000000Z'
      },
      datetime:[],
      range:      '',
      showTimePanel: false,
      lang: {
        days:   ['Ned','Pon', 'Uto','Sre','Čet','Pet','Sub'],
        months: ['Jan', 'Feb','Mar','Apr','Maj','Jun','Jul','Avg','Sep','Okt','Nov','Dec'],
        formatLocale: {
           firstDayOfWeek: 1,
          },
      }
    };
  },
  computed: {
    disabledData: function() {
      return this.disData = this.$store.state.wind.chartHistory.chartDisabled
    }
  },
  mounted(){
    this.getDate();
  },
  methods: { 
    toggleTimePanel() {
      this.showTimePanel = !this.showTimePanel;
    },
    ...mapActions(['postDate']),
    disabledDate(date) {
      const Date1 = new Date(this.valueStart);
      const Date2 = new Date(this.valueStop);
      const pad = (v) => v < 10 ? `0${v}` : v;
      const day = date.getDate();
      const year = date.getFullYear();
      const month = date.getMonth();
      const text = `${pad(day)}/${pad(month + 1)}/${year}`
      const disabledList = this.disabledDates;
      return date < new Date(Date2.getTime()) || disabledList.indexOf(text) !== -1 || date > new Date(Date1.getTime())  ;
    },
    emitDate () {
      const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
      const firstDate = new Date(this.datetime[0]);
      const secondDate = new Date(this.datetime[1]);
      const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay)); 
      if (
          diffDays < 3 && 
          !(firstDate-secondDate) == 0 || 
          !this.datetime[0] == null ||
          !this.datetime[1] == null 
          ){
        let payload = {
        date: this.datetime         
      }
        this.errorDate = '';
        this.$store.dispatch('postDate', payload);
      }else{
        this.errorDate = 'MOLIMO VAS DA BIRATE DATUM U RAZMAKU OD DVA DANA'
      }
        this.$refs.datepicker.closePopup()
    },
    setDate(val){
      const current = val[0].map(item=>new Date(item.date)) // dates from database
      const arr2    = current.map(item=>item.toString()) // dates to be created from first and last record from atabase
      const start   = new Date(current[0])
      const end     = new Date(current[current.length-1])
      const getDaysArray = function() {
    for(var arr=[],dt=new Date(start); dt<=end; dt.setDate(dt.getDate()+1)){
        arr.push(new Date(dt)); // creating list of callendar dates
    }
      arr = arr.map(item=>item.toString())
      arr = arr.filter(function(item) {
      return !arr2.includes(item); 
    })
    const disabledDates = arr.map(item=>new Date(item).toLocaleDateString('en-GB'))
    return  Array.from(disabledDates);
 
      };
      this.disabledDates = getDaysArray()
      if (val){
        this.valueStop = start,
        this.valueStart = end
      }
    }
  ,
   async getDate()
    {  
      if(this.$store.state.wind.chartHistory.chartDisabled.length !== 0 ){
        this.setDate(this.$store.state.wind.chartHistory.chartDisabled)
        }   
    }  
  },
  watch: {
  disabledData: function (val) {
     this.getDate()
        },
}
 
};
</script>
<style lang="css">

.data-picker-style {
    width:100%;
    border-radius: 5px;
    margin-bottom: 1rem;
    margin-left: 1rem;
    text-align: auto;
}
.mx-range-wrapper{
    text-align: auto;
    position: auto;
    vertical-align: middle;
}
.mx-range-wrapper > div:nth-child(2) {
    display: none; 
}

.mx-datepicker-popup[style] {
   left: calc(50% - 120px) !important;
}
.text {
  padding-bottom: 1rem;
  padding-left: 1rem;
}

</style>

