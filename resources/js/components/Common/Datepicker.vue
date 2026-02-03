<template>
  <div class="relative">
    <div class="absolute inset-y-0 start-0 flex items-center ps-2.5 pointer-events-none">
      <IconCalendarWeek
        class="size-6 text-gray-500 dark:text-gray-400"
      />
    </div>

    <input
      :id
      ref="input"
      name="end"
      type="text"
      class="
        bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
        focus:ring-teal-500 focus:border-teal-500 block w-full ps-9 p-2.5
        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
        dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500
      "
      :placeholder
    >
  </div>
</template>

<script
  setup
  lang="ts"
>
import { DatepickerOptions, Datepicker as FlowbiteDatepicker } from 'flowbite-datepicker';
import { IconCalendarWeek } from '@tabler/icons-vue';
import { onBeforeUnmount, onMounted, useTemplateRef } from 'vue';

const emit = defineEmits(['update:modelValue', 'input']);

const { id, placeholder } = defineProps<{
  modelValue?: Date | null,
  id: string,
  placeholder: string,
}>();

const input = useTemplateRef('input');

const onDateChange = (e: CustomEvent) => {
  emit('update:modelValue', e.detail.date);
  emit('input', e.detail.date);
};

onMounted(() => {
  const today = new Date();

  const datepickerOptions: DatepickerOptions = {
    autohide: true,
    format: 'dd M yyyy',
    maxDate: `${String(today.getDay())}/${String(today.getMonth()+1)}/${String(today.getFullYear())}`,
    minDate: null,
    orientation: 'bottom',
    buttons: false,
    autoSelectToday: false,
    title: null,
    rangePicker: true,
  };

  new FlowbiteDatepicker(input.value, datepickerOptions);

  input.value?.addEventListener('changeDate', onDateChange);
});

onBeforeUnmount(() => {
  window.removeEventListener('changeDate', onDateChange);
});
</script>
