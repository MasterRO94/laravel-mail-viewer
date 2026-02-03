const abortControllers: { [key: string]: AbortController | null } = {};

export const baseUrl = `${window.location.origin}${window.location.pathname}`;

export async function request(url: string, params = {}) {
  const abortController = defineAbortController(url, params);

  let response;

  if (!url.startsWith('http')) {
    url = `${baseUrl}${url}`;
  }

  if (Object.keys(params).length > 0) {
    const searchParams = new URLSearchParams(params).toString();

    url = url.endsWith('?') ? `${url}${searchParams}` : `${url}?${searchParams}`;
  }

  try {
    response = await fetch(url, {
      signal: abortController.signal,
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'fetch',
      },
    });
  } catch (err: any) {
    if (err.name !== 'AbortError') {
      throw err;
    }

    return null;
  } finally {
    resetAbortController(url, params);
  }

  return response.json();
}

function abortControllerKey(url: string, params = {}) {
  return JSON.stringify({ url, ...params });
}

function defineAbortController(url: string, params = {}): AbortController {
  const key = abortControllerKey(url, params);

  if (abortControllers[key]) {
    abortControllers[key].abort();
  }

  abortControllers[key] = new AbortController();

  return abortControllers[key];
}

function resetAbortController(url: string, params = {}) {
  const key = abortControllerKey(url, params);

  // eslint-disable-next-line @typescript-eslint/no-dynamic-delete
  delete abortControllers[key];
}
