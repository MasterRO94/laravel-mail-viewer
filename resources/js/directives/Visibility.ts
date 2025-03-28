import { Directive, DirectiveBinding } from 'vue';

type VisibilityEvent = 'visible' | 'hidden' | 'changed';
type VisibilityCallback = (isVisible: boolean) => void;

interface ElVisibilityExecuted {
  _visibleVisibilityExecuted?: boolean;
  _hiddenVisibilityExecuted?: boolean;
  _changedVisibilityExecuted?: boolean;
}

type HTMLElementWithObserver = HTMLElement & ElVisibilityExecuted;

const handler = (
  el: HTMLElementWithObserver,
  entry: IntersectionObserverEntry,
  event: VisibilityEvent,
  callback: VisibilityCallback,
  once: boolean
) => {
  const dataKey = `_${event}VisibilityExecuted` as keyof ElVisibilityExecuted;
  const isVisible = entry.isIntersecting;

  const shouldExecute =
    (isVisible && event === 'visible')
    || (!isVisible && event === 'hidden')
    || event === 'changed';

  if (shouldExecute && (!el[dataKey] || !once)) {
    callback(isVisible);
    el[dataKey] = true;
  }
};

const Visibility: Directive<HTMLElementWithObserver, VisibilityCallback> = {
  mounted(el: HTMLElementWithObserver, binding: DirectiveBinding<VisibilityCallback>) {
    // eslint-disable-next-line
    if (!el) {
      return;
    }

    // eslint-disable-next-line
    const once = binding.modifiers.once ?? false;
    const event = (['visible', 'hidden', 'changed'] as VisibilityEvent[]).find(
      (e) => binding.modifiers[e]
    );

    if (!event) {
      throw new Error(`
        No modifier has been specified. 
        There must be one of ['visible', 'hidden', 'changed'] modifier set on 'v-visible' directive. 
      `);
    }

    if (typeof binding.value !== 'function') {
      throw new Error('Missing \'v-visible\' directive callback function.');
    }

    const observer = new IntersectionObserver((entries) => {
      handler(el, entries[0], event, binding.value, once);
    });

    observer.observe(el);

    (el as any).__VisibilityObserver__ = observer;
  },

  unmounted(el) {
    const observer = (el as any).__VisibilityObserver__ as IntersectionObserver | undefined;

    if (observer) {
      observer.disconnect();
    }
  }
};

export default Visibility;
