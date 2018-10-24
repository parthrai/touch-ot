import Home from './components/public-tablet/home/Home';
import Agenda from './components/public-tablet/agenda/Agenda';
import Expo from './components/public-tablet/expo/Expo';
import Events from './components/public-tablet/events/Event';
import SiteMap from './components/public-tablet/sitemap/SiteMap';
import Social from './components/public-tablet/social/Social';
import EWGames from './components/public-tablet/ewgames/EWGames';

const routes = [
  { path: '/', component: Home },
  { path: '/Agenda', component: Agenda },
  { path: '/Expo', component: Expo },
  { path: '/Events', component: Events },
  { path: '/SiteMap', component: SiteMap },
  { path: '/Social', component: Social },
  { path: '/EW-Games', component: EWGames }
];

export default routes;
