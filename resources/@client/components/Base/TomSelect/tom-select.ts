import {
  type TomSelectProps,
  type TomSelectElement,
  type TomSelectEmit,
} from "./TomSelect.vue";
import {
  type TomSettings,
  type RecursivePartial,
} from "tom-select/src/types/index";
import TomSelect from "tom-select";
import _ from "lodash";
import axios from "axios";
import { showToast } from "@/utils/toast";

const setValue = (el: TomSelectElement, props: TomSelectProps) => {
  if (props.modelValue) {
    if (props.modelValue.length) {
      if (Array.isArray(props.modelValue)) {
        for (const value of props.modelValue) {
          const selectedOption = Array.from(el).find(
            (option) =>
              option instanceof HTMLOptionElement && option.value == value
          );

          if (
            selectedOption !== undefined &&
            selectedOption instanceof HTMLOptionElement
          ) {
            selectedOption.selected = true;
          }
        }
      } else {
        el.value = props.modelValue;
      }
    }
  }
};

const init = (
  originalEl: TomSelectElement,
  clonedEl: TomSelectElement,
  props: TomSelectProps,
  computedOptions: RecursivePartial<TomSettings>,
  emit: TomSelectEmit,
) => {
  // On option add
  if (Array.isArray(props.modelValue)) {
    computedOptions = {
      onOptionAdd: function (value: string | number) {
        // Add new option
        const newOption = document.createElement("option");
        newOption.value = value.toString();
        newOption.text = value.toString();
        originalEl.add(newOption);

        // Emit option add
        emit("optionAdd", value);
      },
      ...computedOptions,
    };
  }

  clonedEl.TomSelect = new TomSelect(clonedEl, {
    ...computedOptions,
    load: async function(query: string, callback: Function) {
      if(props && props.searchModels && props.searchModels.length){
        try {
          await axios.post('api/search', { search: query })
            .then(response => {
              const originalSelectEl = originalEl as HTMLSelectElement;
              originalSelectEl.innerHTML = '';
              if(props && props.searchModels && props.searchModels.length){
                props.searchModels.forEach(model => {
                    const modelOptions = response.data.data[model];
                    if (modelOptions && modelOptions.length > 0) {
                        // Create optgroup for the model
                        const optgroup = document.createElement('optgroup');
                        optgroup.label = model;
                        
                        // Add options to the optgroup
                        modelOptions.forEach((option: { name: string; id: number; }) => {
                            const optionEl = document.createElement('option');
                            optionEl.value = option.id.toString();
                            optionEl.textContent = option.name;
                            optgroup.appendChild(optionEl);
                        });
                        
                        // Append the optgroup to the select element
                        originalSelectEl.appendChild(optgroup);
                    }
                });
              }

              // Refresh select element
              originalEl.dispatchEvent(new Event('change')); // Optionally trigger change event if needed
            })
            .catch(error => {
              console.log('Error searching whereables:', error)
              showToast(false, error.response.data.message) 
            });
        } catch (error: any) {
          console.log('Error searching whereables:', error)
          showToast(false, error)
        }
      }
    }
  });

  // On change
  clonedEl.TomSelect.on("change", function (selectedItems: string[] | string) {
    console.log(selectedItems)
    emit(
      "update:modelValue",
      Array.isArray(selectedItems) ? [...selectedItems] : selectedItems
    );
  });
};

const getOptions = (
  options: HTMLCollection | undefined,
  tempOptions: Element[] = []
) => {
  if (options) {
    Array.from(options).forEach(function (optionEl) {
      if (optionEl instanceof HTMLOptGroupElement) {
        getOptions(optionEl.children, tempOptions);
      } else {
        tempOptions.push(optionEl);
      }
    });
  }

  return tempOptions;
};

const updateValue = (
  originalEl: TomSelectElement,
  clonedEl: TomSelectElement,
  value: string | string[] | number | number[] | null,
  props: TomSelectProps,
  computedOptions: RecursivePartial<TomSettings>,
  emit: TomSelectEmit
) => {
  // Remove old options
  for (const [optionKey, option] of Object.entries(
    clonedEl.TomSelect.options
  )) {
    if (
      !getOptions(originalEl.children).filter((optionEl) => {
        return (
          optionEl instanceof HTMLOptionElement &&
          optionEl.value.toString() === option.value.toString()
        );
      }).length
    ) {
      clonedEl.TomSelect.removeOption(option.value);
    }
  }

  // Update classnames
  const initialClassNames = clonedEl
    .getAttribute("data-initial-class")
    ?.split(" ");
  clonedEl.setAttribute(
    "class",
    [
      ...Array.from(originalEl.classList),
      ...Array.from(clonedEl.classList).filter(
        (className) => initialClassNames?.indexOf(className) == -1
      ),
    ].join(" ")
  );
  clonedEl.TomSelect.wrapper.setAttribute(
    "class",
    [
      ...Array.from(originalEl.classList),
      ...Array.from(clonedEl.TomSelect.wrapper.classList).filter(
        (className) => initialClassNames?.indexOf(className) == -1
      ),
    ].join(" ")
  );
  clonedEl.setAttribute(
    "data-initial-class",
    Array.from(originalEl.classList).join(" ")
  );

  // Add new options
  const options = originalEl.children;
  if (options) {
    Array.from(options).forEach(function (optionEl) {
      clonedEl.TomSelect.addOption({
        text: optionEl.textContent,
        value: optionEl.getAttribute("value"),
      });
    });
  }

  // Refresh options
  clonedEl.TomSelect.refreshOptions(false);

  // Update value
  if (
    (!Array.isArray(value) && value !== clonedEl.TomSelect.getValue()) ||
    (Array.isArray(value) && !_.isEqual(value, clonedEl.TomSelect.getValue()))
  ) {
    clonedEl.TomSelect.destroy();
    if (originalEl.innerHTML) {
      clonedEl.innerHTML = originalEl.innerHTML;
    }
    setValue(clonedEl, props);
    init(originalEl, clonedEl, props, computedOptions, emit);
  }
};

export { setValue, init, updateValue };
