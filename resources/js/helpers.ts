export default function getUserOS(): string {
  const { userAgent } = navigator;

  if (userAgent.includes('Win')) {
    return 'Windows';
  }

  if (userAgent.includes('Mac')) {
    return 'MacOS';
  }

  if (userAgent.includes('X11') || userAgent.includes('Linux')) {
    return 'Linux';
  }

  return 'Windows';
}
