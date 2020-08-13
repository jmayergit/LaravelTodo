import Home from './views/Home'
import User from './views/User'

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Home,
        },
        {
            path: '/user/:id',
            component: User,
            name: 'user',
        },
    ],
}