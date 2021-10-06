export const name = "Router";

export default class Router {
  async loadComponent(name) {
    this.loadModule("./" + name + ".js?v=" + window.app.props.version);
  }

  loadPageModule(name) {
    this.loadModule("./../pages/" + name + ".js?v=" + window.app.props.version);
  }

  async loadModule(modulePath) {
    try {
      const { default: defaultImport } = await import(modulePath);
      new defaultImport();
    } catch (ex) {
      if (window.app.props.debug) {
        console.log(ex);
      }
      return;
    }
  }
}
