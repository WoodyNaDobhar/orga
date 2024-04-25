<script setup lang="ts">
	import _, { toNumber } from "lodash";
	import { ref, reactive } from "vue";
	import { useRoute } from 'vue-router';
	import { Tab } from "@/components/Base/Headless";
	import { useAuthStore } from '@/stores/auth';
	import ClassCredits from "@/components/Profile/ClassCredits";
	import Honors from "@/components/Profile/Honors";
	import Units from "@/components/Profile/Units";
	import Recommendations from "@/components/Profile/Recommendations";
	import Attendances from "@/components/Profile/Attendances";
	import ProfileHead from "@/components/Profile/ProfileHead";
	import { Breakpoint, GridLayout, GridItem, Layout } from 'grid-layout-plus'

	const auth = useAuthStore()
	const user = auth.getUser
	const route = useRoute()
	const persona_id = ref(route.params.persona_id ? route.params.persona_id : (auth.isLoggedIn ? user.persona.id : 1))
	const components = [
		{ component: ClassCredits },
		{ component: Honors },
		{ component: Attendances },
		{ component: Recommendations },
		{ component: Units },
	];
	const presetLayouts = reactive({
		xxs: [
			{"x":0,"y":0,"w":2,"h":8,"i": "0", static: false},
			{"x":0,"y":8,"w":2,"h":8,"i": "1", static: false},
			{"x":0,"y":16,"w":2,"h":14,"i": "2", static: false},
			{"x":0,"y":30,"w":2,"h":8,"i": "3", static: false},
			{"x":0,"y":38,"w":2,"h":14,"i": "4", static: false}
		],
		xs: [
			{"x":0,"y":0,"w":2,"h":8,"i": "0", static: false},
			{"x":2,"y":0,"w":2,"h":8,"i": "1", static: false},
			{"x":0,"y":8,"w":4,"h":13,"i": "2", static: false},
			{"x":0,"y":21,"w":2,"h":8,"i": "3", static: false},
			{"x":2,"y":21,"w":2,"h":8,"i": "4", static: false}
		],
		sm: [
			{"x":0,"y":0,"w":2,"h":8,"i": "0", static: false},
			{"x":2,"y":0,"w":4,"h":8,"i": "1", static: false},
			{"x":0,"y":8,"w":6,"h":13,"i": "2", static: false},
			{"x":4,"y":21,"w":2,"h":14,"i": "3", static: false},
			{"x":0,"y":21,"w":4,"h":14,"i": "4", static: false}
		],
		md: [
			{"x":0,"y":0,"w":3,"h":8,"i":"0", static: false},
			{"x":6,"y":0,"w":4,"h":8,"i":"1", static: false},
			{"x":0,"y":8,"w":5,"h":14,"i":"2", static: false},
			{"x":3,"y":0,"w":3,"h":8,"i":"3", static: false},
			{"x":5,"y":8,"w":5,"h":14,"i":"4", static: false}
		],
		lg: [
			{"x":0,"y":0,"w":3,"h":8,"i":"0", static: false},
			{"x":6,"y":0,"w":6,"h":11,"i":"1", static: false},
			{"x":0,"y":8,"w":6,"h":18,"i":"2", static: false},
			{"x":3,"y":0,"w":3,"h":8,"i":"3", static: false},
			{"x":6,"y":11,"w":6,"h":15,"i":"4", static: false}
		]
	})
	
	const layout = ref(presetLayouts.lg)
	
	function breakpointChangedEvent(newBreakpoint: Breakpoint, newLayout: Layout) {
		console.info('BREAKPOINT CHANGED breakpoint=', newBreakpoint, ', layout: ', newLayout)
	}
	
	function containerResizedEvent(
		i: string,
		newH: number,
		newW: number,
		newHPx: number,
		newWPx: number
	) {
		const msg =
			'CONTAINER RESIZED i=' +
			i +
			', H=' +
			newH +
			', W=' +
			newW +
			', H(px)=' +
			newHPx +
			', W(px)=' +
			newWPx
		console.info(msg)
	}
	

function moveEvent(i: string, newX: number, newY: number) {
	const msg = 'MOVE i=' + i + ', X=' + newX + ', Y=' + newY
	console.info(msg)
}

function movedEvent(i: string, newX: number, newY: number) {
	const msg = 'MOVED i=' + i + ', X=' + newX + ', Y=' + newY
	console.info(msg)
}

function resizeEvent(i: string, newH: number, newW: number, newHPx: number, newWPx: number) {
	const msg =
	'RESIZE i=' + i + ', H=' + newH + ', W=' + newW + ', H(px)=' + newHPx + ', W(px)=' + newWPx
	console.info(msg)
}

function resizedEvent(i: string, newX: number, newY: number, newHPx: number, newWPx: number) {
	const msg =
	'RESIZED i=' + i + ', X=' + newX + ', Y=' + newY + ', H(px)=' + newHPx + ', W(px)=' + newWPx
	console.info(msg)
}

function layoutBeforeMountEvent(newLayout: Layout) {
	console.info('beforeMount layout: ', newLayout)
}

function layoutMountedEvent(newLayout: Layout) {
	console.info('Mounted layout: ', newLayout)
}

function layoutReadyEvent(newLayout: Layout) {
	console.info('Ready layout: ', newLayout)
}

function layoutUpdatedEvent(newLayout: Layout) {
	console.info('Updated layout: ', newLayout)
}
</script>

<template>
	<Tab.Group>
		<!-- BEGIN: Profile Info -->
		<ProfileHead :persona_id="persona_id" />
		<!-- END: Profile Info -->
		<Tab.Panels class="mt-5">
			<Tab.Panel>
				<GridLayout
					v-model:layout="layout"
					:responsive-layouts="presetLayouts"
					:row-height="30"
					:is-draggable="true"
					:is-resizable="true"
					:is-bounded="true"
					:auto-size="true"
					responsive
					@layout-updated="layoutUpdatedEvent"
					@breakpoint-changed="breakpointChangedEvent"
				>
					<GridItem
						v-for="item in layout"
						:key="item.i"
						:x="item.x"
						:y="item.y"
						:w="item.w"
						:h="item.h"
						:i="item.i"
						@layout-updated="layoutUpdatedEvent"
					>
						<template v-if="toNumber(item.i) < components.length">
							<component :is="components[toNumber(item.i)].component" :persona_id="persona_id" :layout="layout" />
						</template>
					</GridItem>
				</GridLayout>
			</Tab.Panel>
		</Tab.Panels>
		<Tab.Panels>
			<Tab.Panel>
				Account
			</Tab.Panel>
		</Tab.Panels>
		<Tab.Panels>
			<Tab.Panel>
				Settings
			</Tab.Panel>
		</Tab.Panels>
		<Tab.Panels>
			<Tab.Panel>
				Crypt
			</Tab.Panel>
		</Tab.Panels>
	</Tab.Group>
</template>
<style scoped>
	:deep(.vgl-item__resizer) {
		position: absolute;
		right: 0;
		bottom: 0;
		box-sizing: border-box;
		width: var(--vgl-resizer-size);
		height: var(--vgl-resizer-size);
		cursor: se-resize;
		z-index: 1000;
	}
	.vue-grid-layout {
		background: #eee;
	}
	
	.vue-grid-item:not(.vue-grid-placeholder) {
		background: #ccc;
		border: 1px solid black;
	}
	
	.vue-grid-item .resizing {
		opacity: 0.9;
	}
	
	.vue-grid-item .static {
		background: #cce;
	}
	
	.vue-grid-item .text {
		font-size: 24px;
		text-align: center;
		position: absolute;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		margin: auto;
		height: 100%;
		width: 100%;
	}
	
	.vue-grid-item .no-drag {
		height: 100%;
		width: 100%;
	}
	
	.vue-grid-item .minMax {
		font-size: 12px;
	}
	
	.vue-grid-item .add {
		cursor: pointer;
	}
	
	.vue-draggable-handle {
		position: absolute;
		width: 20px;
		height: 20px;
		top: 0;
		left: 0;
		background: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='10'><circle cx='5' cy='5' r='5' fill='#999999'/></svg>") no-repeat;
		background-position: bottom right;
		padding: 0 8px 8px 0;
		background-repeat: no-repeat;
		background-origin: content-box;
		box-sizing: border-box;
		cursor: pointer;
		z-index: 1000;
	}
	
	.layoutJSON {
		background: #ddd;
		border: 1px solid black;
		margin-top: 10px;
		padding: 10px;
	}
	
	.columns {
		-moz-columns: 120px;
		-webkit-columns: 120px;
		columns: 120px;
	}

</style>
