<script setup lang="ts">
	import Loading from 'vue-loading-overlay';
	import { useColorSchemeStore } from "@/stores/color-scheme";
	import { getColor } from "@/utils/colors";
	import { ref, computed } from 'vue';
	import 'vue-loading-overlay/dist/css/index.css';
	
	const props = defineProps<{
		active: boolean
		message: string
	}>();

	const iconColor = computed(() => colorScheme.value ? getColor("primary") : undefined);
	const colorScheme = computed(() => useColorSchemeStore().colorScheme);
	const active = ref(props.active)
	
	const toggleActive = (value: boolean) => {
		active.value = value;
	}
</script>

<template>
	<loading
		:active="props.active"
	    @update:active="toggleActive"
	>
		<template #default>
			<svg
				width="20%"
				viewBox="0 0 57 57"
				xmlns="http://www.w3.org/2000/svg"
				class="w-full h-full"
			>
				<g fill="none" fill-rule="evenodd">
					<g transform="translate(1 1)">
						<circle cx="5" cy="50" r="5" :fill="iconColor">
							<animate
								attributeName="cy"
								begin="0s"
								dur="2.2s"
								values="50;5;50;50"
								calcMode="linear"
								repeatCount="indefinite"
							/>
							<animate
								attributeName="cx"
								begin="0s"
								dur="2.2s"
								values="5;27;49;5"
								calcMode="linear"
								repeatCount="indefinite"
							/>
						</circle>
						<circle cx="27" cy="5" r="5" :fill="iconColor">
							<animate
								attributeName="cy"
								begin="0s"
								dur="2.2s"
								from="5"
								to="5"
								values="5;50;50;5"
								calcMode="linear"
								repeatCount="indefinite"
							/>
							<animate
								attributeName="cx"
								begin="0s"
								dur="2.2s"
								from="27"
								to="27"
								values="27;49;5;27"
								calcMode="linear"
								repeatCount="indefinite"
							/>
						</circle>
						<circle cx="49" cy="50" r="5" :fill="iconColor">
							<animate
								attributeName="cy"
								begin="0s"
								dur="2.2s"
								values="50;50;5;50"
								calcMode="linear"
								repeatCount="indefinite"
							/>
							<animate
								attributeName="cx"
								from="49"
								to="49"
								begin="0s"
								dur="2.2s"
								values="49;5;27;49"
								calcMode="linear"
								repeatCount="indefinite"
							/>
						</circle>
					</g>
				</g>
			</svg>
		</template>
		<template #after>
			<h2 class="mr-5 text-lg font-medium truncate" style="text-align: center; margin-top: 25px;">{{ message }}</h2>
		</template>
	</loading>
</template>
