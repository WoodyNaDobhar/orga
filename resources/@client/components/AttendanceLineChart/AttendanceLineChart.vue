<script setup lang="ts">
	import { computed } from "vue";
	import { type ChartData, type ChartOptions } from "chart.js/auto";
	import { useDarkModeStore } from "@/stores/dark-mode";
	import Chart from "@/components/Base/Chart";
	import { getColor } from "@/utils/colors";
	
	const props = defineProps<{
		width?: number;
		height?: number;
		data?: ChartData;
		labels?: string[];
	}>();
	
	const darkMode = computed(() => {
		const darkModeStore = useDarkModeStore();
		return darkModeStore ? darkModeStore.darkMode : false;
	});
	
	const options = computed<ChartOptions>(() => {
		return {
			maintainAspectRatio: false,
			plugins: {
				legend: {
					display: true,
				},
			},
			scales: {
				x: {
					ticks: {
						font: {
							size: 12,
						},
						color: getColor("slate.500", 0.8),
					},
					grid: {
						display: false,
					},
					border: {
						display: false,
					},
				},
				y: {
					ticks: {
						font: {
							size: 12,
						},
						color: getColor("slate.500", 0.8),
						callback: function (value) {
							return value;
						},
					},
					grid: {
						color: darkMode ? getColor("slate.500", 0.3) : getColor("slate.300"),
					},
					border: {
						dash: [2, 2],
						display: false,
					},
				},
			},
		};
	});
</script>

<template>
	<Chart
		type="line"
		:width="props.width"
		:height="props.height"
		:data="props.data"
		:options="options"
	/>
</template>
