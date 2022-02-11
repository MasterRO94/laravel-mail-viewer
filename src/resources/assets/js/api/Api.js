export default class Api {
  static async fetchMails(page = 1, filters = {}) {
    let url = `${window.location.origin}${window.location.pathname}/emails?`;

    url += new URLSearchParams({ page, filters }).toString();

    const response = await fetch(url);

    return response.json();
  }
}
