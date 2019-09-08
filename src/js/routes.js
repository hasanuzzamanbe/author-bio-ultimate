import MyProfile from './Components/MyProfile';
import Settings from './Components/Settings';
import Supports from './Components/Supports';
// import EventEmailSettings from "./Components/EmailSettings/EventEmailSettings";

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
    },
    // {
    //     path: "email_settings",
    //     name: "email_settings",
    //     component: EventEmailSettings,
    // }
];
