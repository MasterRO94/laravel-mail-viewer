import { reactive } from 'vue';
import Email from '@/models/Email';

export default reactive<{
  initialized: boolean;
  activeEmail: Email | null;
  payloads: Record<number, string | null>;
  autoUpdateEnabled: boolean;
}>({
  initialized: false,
  activeEmail: null,
  payloads: {},
  autoUpdateEnabled: true,
});
