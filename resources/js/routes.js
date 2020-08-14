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
            path: '/users/:id',
            component: User,
            name: 'user',
        },
    ],
}