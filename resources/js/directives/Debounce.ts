import { DirectiveBinding } from 'vue';

export default {
  beforeMount(el: HTMLElement, binding: DirectiveBinding) {
    const eventName: string = binding.arg as string;
    const delay = Object.keys(binding.modifiers).map((t) => parseInt(t, 10))[0] ?? 200;

    let timeout: number;

    el.addEventListener(eventName, (event) => {
      if (timeout) {
        clearTimeout(timeout);
      }

      timeout = setTimeout(() => {
        binding.value(event);
      }, delay);
    });
  },
};
