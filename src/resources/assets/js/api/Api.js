export default class Api {
  static #abortController;

  static async fetchMails(params = {}) {
    Api.#defineAbortController();

    let response;
    let url = `${window.location.origin}${window.location.pathname}/emails?`;

    url += new URLSearchParams(params).toString();
    try {
      response = await fetch(url, {
        signal: Api.#abortController.signal,
      });
    } catch (err) {
      if (err.name === 'AbortError') {
        Api.#resetAbortController();

        return null;
      } else {
        throw err;
      }
    }

    Api.#resetAbortController();

    return response.json();
  }

  static #defineAbortController() {
    if (Api.#abortController) {
      Api.#abortController.abort();
    }

    Api.#abortController = new AbortController();
  }

  static #resetAbortController() {
    Api.#abortController = null;
  }
}
