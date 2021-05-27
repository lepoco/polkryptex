import html from 'html';
export default {
    name: `App`,
    template: html`
    <router-link to="/">Go to Home</router-link>
    <router-link to="/about">Go to About</router-link>
    <router-view></router-view>
  `};