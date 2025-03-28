import { reactive } from 'vue';

export default reactive<{
  initialized: boolean;
  payloads: Record<number, string | null>
}>({
  initialized: false,
  payloads: {},
});
