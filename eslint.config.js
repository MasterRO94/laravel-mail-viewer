import {
  defineConfigWithVueTs,
  vueTsConfigs,
} from '@vue/eslint-config-typescript';
import prettier from 'eslint-config-prettier';
import vue from 'eslint-plugin-vue';

export default defineConfigWithVueTs(
  {
    languageOptions: {
      parser: 'vue-eslint-parser',
      parserOptions: {
        parser: '@typescript-eslint/parser', // Ensure TS parser is used for Vue
        project: './tsconfig.json', // Path to TypeScript config
        tsconfigRootDir: import.meta.dirname, // Ensure correct path resolution
      },
    },
  },
  vue.configs['flat/recommended'],
  vueTsConfigs.strictTypeChecked,
  {
    ignores: ['vendor', 'node_modules', 'public', 'resources/old-assets'],
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
