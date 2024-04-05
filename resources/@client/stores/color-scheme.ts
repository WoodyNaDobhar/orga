import { defineStore } from "pinia";

const colorSchemes = [
  "default",
  "theme-1",
  "theme-2",
  "theme-3",
  "theme-4",
] as const;

export type ColorSchemes = typeof colorSchemes[number];

interface ColorSchemeState {
  colorSchemeValue: ColorSchemes;
}

const getColorScheme = () => {
  const colorScheme = localStorage.getItem("colorScheme");
  return colorSchemes.filter((item, key) => {
    return item === colorScheme;
  })[0];
};

export const useColorSchemeStore = defineStore("colorScheme", {
  state: (): ColorSchemeState => ({
    colorSchemeValue:
      localStorage.getItem("colorScheme") === null
        ? "theme-4"
        : getColorScheme(),
  }),
  getters: {
    colorScheme(state) {
      if (localStorage.getItem("colorScheme") === null) {
        localStorage.setItem("colorScheme", "theme-4");
      }

      return state.colorSchemeValue;
    },
  },
  actions: {
    setColorScheme(colorScheme: ColorSchemes) {
      localStorage.setItem("colorScheme", colorScheme);
      this.colorSchemeValue = colorScheme;
    },
  },
});
