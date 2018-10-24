import Home from './components/fondle-slab/home/Home';
import Agenda from './components/fondle-slab/agenda/Agenda';
import Expo from './components/fondle-slab/expo/Expo';
import Events from './components/fondle-slab/events/Event';
import SiteMap from './components/fondle-slab/sitemap/SiteMap';
import Social from './components/fondle-slab/social/Social';
import EWGames from './components/fondle-slab/ewgames/EWGames';

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
