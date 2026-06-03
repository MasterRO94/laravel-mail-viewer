import {
  defineConfigWithVueTs,
  vueTsConfigs,
} from '@vue/eslint-config-typescript';
import prettier from 'eslint-config-prettier';
import vue from 'eslint-plugin-vue';

export default defineConfigWithVueTs(
  vue.configs['flat/recommended'],
  // strictTypeChecked enables `projectService` for typed linting, so no manual
  // `parserOptions.project` is needed (the two are mutually exclusive).
  vueTsConfigs.strictTypeChecked,
  {
    ignores: [
      'vendor',
      'node_modules',
      'public',
      'resources/old-assets',
      '.claude',
    ],
  },
  {
    rules: {
      'vue/multi-word-component-names': 'off',
      '@typescript-eslint/no-explicit-any': 'off',
      'vue/no-v-html': 'off',
    },
  },
  prettier,
);
