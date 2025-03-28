import { twMerge } from 'tailwind-merge';
import { DirectiveBinding, VNode } from 'vue';

const computeClasses = (el: HTMLElement, binding: DirectiveBinding, vNode: VNode) => {
  const existingClasses = el.classList.value;
  const inheritedClasses = (vNode as any)?.ctx?.attrs?.class as string | undefined;

  // No need to run twMerge if there are no classes
  if (!existingClasses && !inheritedClasses) {
    return;
  }

  // This works because all fallthrough classes are added at the end of the string
  el.classList.value = twMerge(existingClasses, inheritedClasses);
};

export default {
  beforeMount: computeClasses,
  updated: computeClasses,
} as const;
