import MyProfile from './Components/MyProfile';
import Settings from './Components/Settings';
import Supports from './Components/Supports';

export const routes = [
    {
        path: '/',
        name: 'my-profile',
        component: MyProfile
    },
    {
        path: '/settings',
        name: 'settings',
        component: Settings
    },
    {
        path: '/supports',
        name: 'supports',
        component: Supports
    }
];
