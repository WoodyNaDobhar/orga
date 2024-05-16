<script setup lang="ts">
import "@/assets/css/vendors/tom-select.css";
import _ from "lodash";
import { setValue, init, updateValue } from "./tom-select";
import {
  type TomSettings,
  type RecursivePartial,
} from "tom-select/src/types/index";
import TomSelectPlugin from "tom-select";
import {
  computed,
  type SelectHTMLAttributes,
  onMounted,
  inject,
  ref,
  InputHTMLAttributes,
} from "vue";

export interface TomSelectElement extends HTMLSelectElement {
  TomSelect: TomSelectPlugin;
}

export interface TomSelectProps extends /* @vue-ignore */ SelectHTMLAttributes {
  value?: InputHTMLAttributes["value"] | InputHTMLAttributes["value"][];
  modelValue?: InputHTMLAttributes["value"] | InputHTMLAttributes["value"][];
  options?: RecursivePartial<TomSettings>;
  refKey?: string;
  searchModels?: string[];
}

export interface TomSelectEmit {
  (e: "update:modelValue", value: string | string[]): void;
  (e: "optionAdd", value: string | number): void;
}

export type ProvideTomSelect = (el: TomSelectElement) => void;

const props = withDefaults(defineProps<TomSelectProps>(), {});

const emit = defineEmits<TomSelectEmit>();

const tomSelectRef = ref<TomSelectElement>();

// Compute all default options
const computedOptions = computed(() => {
  let options: TomSelectProps["options"] = {
    ...props.options,
    plugins: {
      dropdown_input: {},
      ...props.options?.plugins,
    },
  };

  if (Array.isArray(props.modelValue)) {
    options = {
      persist: false,
      create: true,
      onDelete: function (values: string[]) {
        return confirm(
          values.length > 1
            ? "Are you sure you want to remove these " +
                values.length +
                " items?"
            : 'Are you sure you want to remove "' + values[0] + '"?'
        );
      },
      ...options,
      plugins: {
        remove_button: {
          title: "Remove this item",
        },
        ...options.plugins,
      },
    };
  }

  return options;
});

const vSelectDirective = {
  mounted(el: TomSelectElement) {
    // Unique attribute
    el.setAttribute("data-id", "_" + Math.random().toString(36).substr(2, 9));

    // Clone the select element to prevent tom select remove the original element
    const clonedEl = el.cloneNode(true) as TomSelectElement;

    // Save initial classnames
    const classNames = el?.getAttribute("class");
    classNames && clonedEl.setAttribute("data-initial-class", classNames);

    // Hide original element
    el?.parentNode && el?.parentNode.appendChild(clonedEl);
    el.setAttribute("hidden", "true");

    // Initialize tom select
    setValue(clonedEl, props);
    init(el, clonedEl, props, computedOptions.value, emit);
  },
  updated(el: TomSelectElement) {
    const clonedEl = document.querySelectorAll(
      `[data-id='${el.getAttribute("data-id")}'][data-initial-class]`
    )[0] as TomSelectElement;
    const value = props.modelValue;
    updateValue(el, clonedEl, value, props, computedOptions.value, emit);
  },
};

const bindInstance = (el: TomSelectElement) => {
  if (props.refKey) {
    const bind = inject<ProvideTomSelect>(`bind[${props.refKey}]`);
    if (bind) {
      bind(el);
    }
  }
};

onMounted(() => {
  if (tomSelectRef.value) {
    bindInstance(tomSelectRef.value);
  }
});

const localValue = computed({
  get() {
    if (props.modelValue === undefined && props.value === undefined) {
      const firstOption = tomSelectRef.value?.querySelectorAll("option")[0];
      return (
        firstOption !== undefined &&
        (firstOption.getAttribute("value") !== null
          ? firstOption.getAttribute("value")
          : firstOption.text)
      );
    }

    return props.modelValue === undefined ? props.value : props.modelValue;
  },
  set(newValue) {
    emit("update:modelValue", newValue);
  },
});
</script>

<template>
  <select
    ref="tomSelectRef"
    v-model="localValue"
    v-select-directive
    class="tom-select"
  >
    <slot></slot>
  </select>
</template>
