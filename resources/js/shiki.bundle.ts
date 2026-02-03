/* Generate by @shikijs/codegen */
import type {
  DynamicImportLanguageRegistration,
  DynamicImportThemeRegistration,
  HighlighterGeneric,
} from '@shikijs/types';
import { createdBundledHighlighter, createSingletonShorthands, } from '@shikijs/core';
import { createJavaScriptRegexEngine } from '@shikijs/engine-javascript';

type BundledLanguage = 'html' | 'css'
type BundledTheme = 'material-theme-palenight' | 'material-theme-lighter'
type Highlighter = HighlighterGeneric<BundledLanguage, BundledTheme>

const bundledLanguages = {
  html: () => import('@shikijs/langs/html'),
  css: () => import('@shikijs/langs/css'),
} as Record<BundledLanguage, DynamicImportLanguageRegistration>;

const bundledThemes = {
  'material-theme-palenight': () =>
    import('@shikijs/themes/material-theme-palenight'),
  'material-theme-lighter': () =>
    import('@shikijs/themes/material-theme-lighter'),
} as Record<BundledTheme, DynamicImportThemeRegistration>;

const createHighlighter = /* @__PURE__ */ createdBundledHighlighter<
  BundledLanguage,
  BundledTheme
>({
  langs: bundledLanguages,
  themes: bundledThemes,
  engine: () => createJavaScriptRegexEngine(),
});

const {
  codeToHtml,
  codeToHast,
  codeToTokensBase,
  codeToTokens,
  codeToTokensWithThemes,
  getSingletonHighlighter,
  getLastGrammarState,
} = /* @__PURE__ */ createSingletonShorthands<BundledLanguage, BundledTheme>(
  createHighlighter,
);

export {
  bundledLanguages,
  bundledThemes,
  codeToHast,
  codeToHtml,
  codeToTokens,
  codeToTokensBase,
  codeToTokensWithThemes,
  createHighlighter,
  getLastGrammarState,
  getSingletonHighlighter,
};

export type { BundledLanguage, BundledTheme, Highlighter };
