
class LocationParser {
    constructor() {
        this.url = new URL(window.location.href);
    }
    get(parameter) {
        return this.url.searchParams.get(parameter);
    }
    clearParams() {
        const baseUrl = window.location.href.split("?")[0];
        window.history.pushState('name', '', baseUrl);
    }
}

export default new LocationParser;
