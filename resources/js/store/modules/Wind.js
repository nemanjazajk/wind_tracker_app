import axios from 'axios';
const state = {
  dateWarning :false,
  user        :'',
  lables      :[],
  values      :[],
  indicaton   :{
    led              :"Isključeno",
    errorMessage     :"",
    balloonUp        :"Isključeno",
    currentState     :'',
    connectionError  :true,
    currentWindSpeed : ''
  },
  maxWind  :15,
  maxWind2 :21,
  chartHistory:{
    chartDisabled :[],
    chartDate     :[],
    chartValue    :[1,1,1,1],
    chart         :false,
    chartLoader   :true
  }
};

const getters = {
  getLables   : state=>state.lables,
  getValues   : state=>state.values,
  getindicaton: state=>state.indicaton,
  maxWind     : state=>state.maxWind,
  maxWind2    : state=>state.maxWind2,
  chartHistory: state=>state.chartHistory
};

const actions = {
  // Current disabled values for history
  async getDisabled({ commit })  {
    const response = await axios.get('/api/date/current')
    commit('SET_DISABLED',response.data)
  },
    async getUser({ commit })  {
    const response = await axios.get('/api/user')
    commit('SET_USER',response.data)
    },
  // Current graph values from the past hour
    async getGraphVal({ commit })  {
    const response = await axios.get('/api/posts/get')
    commit('SET_POSTS',response.data)
  },
  // Current values for the device
  async tableStats({ commit })  {
    const response = await axios.get('/api/posts')
    if (response) {commit('SET_INDICATIONS',response.data)}
    },
  // Sending data for date calendar
  async  postDate({commit},payload) {
      if(!payload.date.length == 0 ){
        commit('SET_LOADER',false)
       await axios.post('/api/date', {
          payload
      })
        .then((resp) => {
          commit('SET_WARNING',resp.data)
          commit('SET_ERROR',false)
          commit('SET_CHART', resp.data)
          commit('SET_LOADER',true)
        })
        .catch((err) => {
          console.log(err)
        })}else{
          commit('SET_ERROR',true)
        }
    },
  }
 
const mutations = {
  SET_POSTS(state, graph) {
  state.lables = graph.data.reverse().map(todo=>todo.created_at)
  state.values = graph.data.map(todo=>parseFloat(todo.currentWindSpeed).toFixed(1))
  },
  SET_INDICATIONS(state, indication) {
   const theRemoveChartValue        = state.values.shift();
   const theRemoveChartLable        = state.lables.shift();
   state.indicaton.connectionError  = !!indication.connection.val
   state.indicaton.currentState     = indication.data.currentState
   state.indicaton.currentWindSpeed = indication.data.currentWindSpeed
   state.values.push(indication.data.currentWindSpeed.toFixed(1))
   state.lables.push(indication.data.created_at)
   
   const error = indication.data.eventError.split(",")
   const obj   = {};
   error.forEach(string => {
      const [key, value] = string.split(":");
      obj[key] = value;
      });
   state.indicaton.errorMessage = obj.currentErrorEvent =='NONE' ? ''          : obj.currentErrorEvent
   state.indicaton.balloonUp    = obj.operater_up       =='ON'   ? 'Uključeno' : 'Isključeno'
   state.indicaton.led          = obj.leed              =='ON'   ? 'Uključeno' : 'Isključeno'
 },
  SET_MAX(state, maxWind) {
      state.maxWind=maxWind
  },
  SET_MAX2(state, maxWind2) {
    state.maxWind2=maxWind2
},
  SET_CHART(state, chartHistory) {
    state.chartHistory.chartValue   = chartHistory.map(item=>parseFloat(item.currentWindSpeed).toFixed(1))
    state.chartHistory.chartDate    = chartHistory.map(item=>item.date)
    state.chartHistory.chartLoader  = false
},
  SET_DATE(state, chartHistory) {
    state.chartHistory.chartStart  = chartHistory[0][0].created_at
    state.chartHistory.chartStop   = chartHistory[1][0].created_at
},
  SET_ERROR(state,chartHistory){
    state.chartHistory.chart       = chartHistory
},
  SET_LOADER(state,chartHistory){
    state.chartHistory.chartLoader = chartHistory
},
  SET_USER(state,user){
    if (user.id === 7 || user.id === 8){
      state.user = 'user'
    }
    else{
      state.user = 'admin'
    }
  },
  SET_WARNING(state,data){
    if (!data.length){
      state.dateWarning = true
      setTimeout(()=>{
      state.dateWarning = false
     },2000)
    }
  },
  SET_DISABLED(state,data){
    state.chartHistory.chartDisabled = data
  }
  }
export default {
  state,
  getters,
  actions,
  mutations
};
