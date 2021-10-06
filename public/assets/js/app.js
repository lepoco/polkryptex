import Router from "./components/router.js?v=1.0.0";
let router = new Router();

const PAGES = ["signin", "register", "dashboard-account", "installer"];

router.loadComponent("cookie");
router.loadComponent("signout");

if (PAGES.includes(window.app.props.view)) {
  router.loadPageModule("installer");
}
