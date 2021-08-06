import Home from './views/Home';
import HistoryGraph from './views/HistoryGraph';
import Settings from './views/Settings';
import NotFound from './views/NotFound';

export default{
    mode: 'hash',

    routes:[
        {
            path: '*',
            component: NotFound
        },
        {
            path: '/',
            component: Home
        },
        {
            path: '/istorija',
            component: HistoryGraph
        },
        {
            path: '/podesavanja',
            component: Settings
        }
    ]
}