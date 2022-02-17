export default class Api {
  static #abortController = {};

  static async #request(url, params = {}) {
    Api.#defineAbortController(url, params);

    let response;

    url += new URLSearchParams(params).toString();
    try {
      response = await fetch(url, {
        signal: Api.#abortController.signal,
      });
    } catch (err) {
      if (err.name === 'AbortError') {
        Api.#resetAbortController(url, params);

        return null;
      } else {
        throw err;
      }
    }

    Api.#resetAbortController(url, params);

    return response.json();
  }

  static fetchMails(params = {}) {
    return Api.#request(`${Api.baseUrl}/emails?`, params);
  }

  static fetchStats() {
    return Api.#request(`${Api.baseUrl}/stats`);
  }

  static async fetchPayload(email) {
    const id = email.id ?? email;

    return (await Api.#request(`${Api.baseUrl}/emails/${id}/payload`)).data;
  }

  static #defineAbortController(url, params) {
    const key = this.#abortControllerKey(url, params);

    if (Api.#abortController[key]) {
      Api.#abortController[key].abort();
    }

    Api.#abortController[key] = new AbortController();
  }

  static #resetAbortController(url, params) {
    const key = this.#abortControllerKey(url, params);

    Api.#abortController[key] = null;
  }

  static #abortControllerKey(url, params) {
    return JSON.stringify({ url, ...params });
  }

  static get baseUrl() {
    return `${window.location.origin}${window.location.pathname}`;
  }
}
