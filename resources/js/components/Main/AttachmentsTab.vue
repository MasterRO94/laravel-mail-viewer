<template>
  <div
    class="w-full min-h-[20rem] p-2 space-y-2"
    :class="{ 'animate-fade-in': active }"
  >
    <div class="flex flex-col divide-y divide-gray-200 dark:divide-slate-700">
      <div
        v-for="(attachment, i) in email.attachments"
        :key="`${email.id}-attachment-${i}`"
        class="flex py-2 justify-between items-center"
      >
        <div class="flex gap-2">
          <Component :is="icon(attachment)" />

          <div v-text="attachment.name" />
        </div>

        <div>
          <Btn
            class="px-1.5 py-0.5 text-sm"
            :href="`${baseUrl}/emails/${email.id}/attachments/${attachment.name}`"
          >
            <IconDownload class="size-5" />

            Download
          </Btn>
        </div>
      </div>
    </div>
  </div>
</template>

<script
  setup
  lang="ts"
>
import Email from '@/models/Email';
import Attachment from '@/models/Attachment';
import {
  Icon,
  IconDownload,
  IconFile,
  IconFileTypeDoc,
  IconFileTypeDocx,
  IconFileTypePdf,
  IconFileTypePpt,
  IconFileTypeSql,
  IconFileTypeSvg,
  IconFileTypeTxt,
  IconFileTypeXml,
  IconFileTypeZip,
  IconFileZip,
  IconPhoto,
} from '@tabler/icons-vue';
import Btn from '@/components/Common/Btn.vue';
import { baseUrl } from '@/api';

const { email } = defineProps({
  email: {
    type: Email,
    required: true,
  },

  active: {
    type: Boolean,
    required: false,
    default: false,
  },
});

const iconMap: Record<string, Icon> = {
  bmp: IconPhoto,
  docx: IconFileTypeDocx,
  doc: IconFileTypeDoc,
  gif: IconPhoto,
  jpeg: IconPhoto,
  png: IconPhoto,
  pdf: IconFileTypePdf,
  pptx: IconFileTypePpt,
  ppt: IconFileTypePpt,
  sql: IconFileTypeSql,
  svg: IconFileTypeSvg,
  txt: IconFileTypeTxt,
  xml: IconFileTypeXml,
  zip: IconFileTypeZip,
  gzip: IconFileZip,
};

const icon = (attachment: Attachment): Icon => {
  return iconMap[attachment.subtype] ?? IconFile;
};
</script>
