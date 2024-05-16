<script lang="ts">
type LitepickerConfig = Partial<ILPConfiguration>;
</script>

<script setup lang="ts">
import "@/assets/css/vendors/litepicker.css";
import { type InputHTMLAttributes, onMounted, ref, inject, computed } from "vue";
import { setValue, init, reInit } from "./litepicker";
import LitepickerJs from "litepicker";
import { FormInput } from "@/components/Base/Form";
import { type ILPConfiguration } from "litepicker/dist/types/interfaces.d";

export interface LitepickerElement extends HTMLInputElement {
  litePickerInstance: LitepickerJs;
}

export interface LitepickerEmit {
  (e: "update:modelValue", value: string): void;
}

export interface LitepickerProps extends /* @vue-ignore */ InputHTMLAttributes {
  value?: InputHTMLAttributes["value"];
  modelValue?: InputHTMLAttributes["value"];
  options: {
    format?: string | undefined;
  } & LitepickerConfig;
  refKey?: string;
}

export type ProvideLitepicker = (el: LitepickerElement) => void;

const props = defineProps<LitepickerProps>();
const litepickerRef = ref<LitepickerElement>();
const tempValue = ref(props.modelValue);
const emit = defineEmits<LitepickerEmit>();

const vLitepickerDirective = {
  mounted(el: LitepickerElement) {
    setValue(props, emit);
    if (el !== null) {
      init(el, props, emit);
    }
  },
  updated(el: LitepickerElement) {
    if (tempValue.value !== props.modelValue && el !== null) {
      reInit(el, props, emit);
      tempValue.value = props.modelValue;
    }
  },
};

const bindInstance = (el: LitepickerElement) => {
  if (props.refKey) {
    const bind = inject<ProvideLitepicker>(`bind[${props.refKey}]`);
    if (bind) {
      bind(el);
    }
  }
};

onMounted(() => {
  if (litepickerRef.value) {
    bindInstance(litepickerRef.value);
  }
});

const localValue = computed({
  get() {
    return props.modelValue === undefined ? props.value : props.modelValue;
  },
  set(newValue) {
    emit("update:modelValue", newValue);
  },
});
</script>

<template>
  <FormInput
    ref="litepickerRef"
    v-model="localValue"
    type="text"
    v-litepicker-directive
  />
</template>
