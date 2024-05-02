<script setup lang="ts">
	import { ref, onMounted } from "vue";
	import { Tab } from "@/components/Base/Headless";
	import { 
		Persona,
	} from '@/interfaces';
	import Lucide from "@/components/Base/Lucide";
	import { useAuthStore } from '@/stores/auth';
	import { useStateStore } from '@/stores/state';
	import axios from 'axios';
	import Loader from "@/components/Base/Loader";
	
	const auth = useAuthStore()
	const state = useStateStore()
	const user = auth.getUser
	const props = defineProps<{
		persona: Persona | undefined
	}>()
	const isLoading = ref<boolean>(false)

	import * as lucideIcons from "lucide-vue-next";
	const getIcon = (media: string): keyof typeof lucideIcons => {
		switch (media) {
			case "Discord":
				return "HardDrive";
			default:
				return media as keyof typeof lucideIcons;
		}
	};
</script>
<template>
		<Loader 
			:active="isLoading"
			message="Loading Persona Data"
		/>
		<div class="px-5 pt-5 mt-5 intro-y box">
			<div
				class="flex flex-col pb-5 -mx-5 border-b lg:flex-row border-slate-200/60 dark:border-darkmode-400"
			>
				<div
					class="flex items-center justify-center flex-1 px-5 lg:justify-start"
				>
					<div
						class="relative flex-none w-20 h-20 sm:w-24 sm:h-24 lg:w-32 lg:h-32 image-fit"
					>
						<img
							:alt="persona?.name"
							class="rounded-full"
							:src="persona?.image"
						/>
						<img 
							v-if="persona?.heraldry && !persona?.heraldry.includes('000000.jpg')" 
							style="width: 33%; height: 33%"
							class="absolute top-0 right-0" 
							:src="persona?.heraldry" 
						/>
					</div>
					<div class="ml-5">
						<div class="text-lg font-medium truncate sm:whitespace-normal">
							{{ persona?.honorific?.name + ' ' }}{{ persona?.name }}
						</div>
						<div class="text-slate-500">
							<template v-for="(peerage) in ['Knight']">
								<template v-if="persona?.titleIssuances?.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length">
									<span v-for="(title, titleIndex) in persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage)" :key="titleIndex">{{ title.name }}&nbsp;</span>
								</template>
							</template>
						</div>
						<div class="text-slate-500">
							<template v-for="(peerage) in ['Nobility']">
								<template v-if="persona?.titleIssuances?.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length">
									<span v-for="(title, titleIndex) in persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage)" :key="titleIndex">{{ title.name }}&nbsp;</span>
								</template>
							</template>
						</div>
						<div class="text-slate-500">
							<template v-for="(peerage) in ['Retainer']">
								<template v-if="persona?.titleIssuances?.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length">
									<span v-for="(title, titleIndex) in persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage)" :key="titleIndex">{{ title.name }}&nbsp;</span>
								</template>
							</template>
						</div>
						<div class="text-slate-500">
							<template v-for="(peerage, index) in ['Master']">
								<template v-if="persona?.titleIssuances?.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length">
									<span v-for="(title, titleIndex) in persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage)" :key="titleIndex">
										{{ title.name }}<span v-if="titleIndex !== persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length - 1 || index !== ['Master', 'Paragon', 'Gentry', 'None'].length - 1">, </span>
									</span>
								</template>
							</template>
						</div>
						<div class="text-slate-500">
							<template v-for="(peerage, index) in ['Paragon']">
								<template v-if="persona?.titleIssuances?.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length">
									<span v-for="(title, titleIndex) in persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage)" :key="titleIndex">
										{{ title.name }}<span v-if="titleIndex !== persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length - 1 || index !== ['Master', 'Paragon', 'Gentry', 'None'].length - 1">, </span>
									</span>
								</template>
							</template>
						</div>
						<div class="text-slate-500">
							<template v-for="(peerage, index) in ['Gentry']">
								<template v-if="persona?.titleIssuances?.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length">
									<span v-for="(title, titleIndex) in persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage)" :key="titleIndex">
										{{ title.name }}<span v-if="titleIndex !== persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length - 1 || index !== ['Master', 'Paragon', 'Gentry', 'None'].length - 1">, </span>
									</span>
								</template>
							</template>
						</div>
						<div class="text-slate-500">
							<template v-for="(peerage, index) in ['None']">
								<template v-if="persona?.titleIssuances?.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length">
									<span v-for="(title, titleIndex) in persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage)" :key="titleIndex">
										{{ title.name }}<span v-if="titleIndex !== persona.titleIssuances.filter(titleIssuance => titleIssuance.issuable.peerage === peerage).length - 1 || index !== ['Master', 'Paragon', 'Gentry', 'None'].length - 1">, </span>
									</span>
								</template>
							</template>
						</div>
						<div class="text-slate-500">
							({{ persona?.pronoun?.subject }}/{{ persona?.pronoun?.object }})
						</div>
						<div v-if="persona?.is_suspended" class="flex items-center truncate sm:whitespace-normal" >
							<Lucide icon="ShieldOff" class="w-4 h-4 mr-2" /> Suspended
						</div>
						<div v-if="persona?.is_active" class="flex items-center truncate sm:whitespace-normal" >
							<Lucide icon="Activity" class="w-4 h-4 mr-2" /> Active
						</div>
						<div v-if="persona?.is_waivered" class="flex items-center truncate sm:whitespace-normal" >
							<Lucide icon="PenTool" class="w-4 h-4 mr-2" /> Waivered
						</div>
						<div v-if="persona?.is_paid" class="flex items-center truncate sm:whitespace-normal" >
							<Lucide icon="DollarSign" class="w-4 h-4 mr-2" /> Dues Paid
						</div>
						<div v-if="persona?.reeve_qualified_expires_at && new Date(persona?.reeve_qualified_expires_at) > new Date()" class="flex items-center truncate sm:whitespace-normal" >
							<Lucide icon="Eye" class="w-4 h-4 mr-2" /> Reeve Qualified
						</div>
						<div v-if="persona?.corpora_qualified_expires_at && new Date(persona?.corpora_qualified_expires_at) > new Date()" class="flex items-center truncate sm:whitespace-normal" >
							<Lucide icon="FileText" class="w-4 h-4 mr-2" /> Corpora Qualified
						</div>
					</div>
				</div>
				<div class="flex justify-center items-center px-5 pt-5 mt-6 border-t border-l border-r lg:mt-0 border-slate-200/60 dark:border-darkmode-400 lg:border-t-0 lg:pt-0 flex-row">
				    <a :href="'chapters/' + persona?.chapter?.id" class="flex flex-col items-center mx-2">
				        <div class="relative p-3 rounded-md box zoom-in w-40">
				            <div class="flex-none relative block before:block before:w-full before:pt-[100%]">
				                <div class="absolute top-0 left-0 w-full h-full image-fit">
				                    <img :alt="persona?.chapter?.name" class="rounded-md" :src="persona?.chapter?.heraldry ?? ''" />
				                </div>
				            </div>
    						<div class="block mt-3 font-medium text-center truncate">{{ persona?.chapter?.name }}</div>
				        </div>
				    </a>
				    <a :href="'chapters/' + persona?.chapter?.id" class="flex flex-col items-center mx-2">
				        <div class="relative p-3 rounded-md box zoom-in w-40">
				            <div class="flex-none relative block before:block before:w-full before:pt-[100%]">
				                <div class="absolute top-0 left-0 w-full h-full image-fit">
				                    <img :alt="persona?.chapter?.realm?.name" class="rounded-md" :src="persona?.chapter?.realm?.heraldry ?? ''" />
				                </div>
				            </div>
    						<div class="block mt-3 font-medium text-center truncate" style="direction: rtl;">{{ persona?.chapter?.realm?.name }}</div>
				        </div>
				    </a>
				</div>
				<div
					class="flex flex-col items-center justify-center flex-1 px-5 pt-5 mt-6 border-t lg:mt-0 lg:border-0 border-slate-200/60 dark:border-darkmode-400 lg:pt-0"
				>
					<div class="flex">
						<div class="w-20 py-3 text-center rounded-md">
							<div class="text-xl font-medium text-primary">{{ persona?.credits.attendance_count }}</div>
							<div class="text-slate-500">Attendances</div>
						</div>
						<div class="w-20 py-3 text-center rounded-md">
							<div class="text-xl font-medium text-primary">{{ persona?.credits.count }}</div>
							<div class="text-slate-500">Credits</div>
						</div>
						<div class="w-20 py-3 text-center rounded-md">
							<div class="text-xl font-medium text-primary">{{ persona?.score }}</div>
							<div class="text-slate-500">Score</div>
						</div>
					</div>
					<div
						class="flex flex-col items-center justify-center mt-4"
					>
						<template v-for="(social) in persona?.socials">
							<div class="flex items-center truncate sm:whitespace-normal">
								<Lucide :icon="getIcon(social.media)" class="w-4 h-4 mr-2" />
								<a :href="social.link" target="_blank">{{ social.value }}</a>
							</div>
						</template>
					</div>
				</div>
			</div>
			<Tab.List
				v-if="auth.isLoggedIn && (auth.getUser.persona_id === persona?.id)"
				variant="link-tabs"
				class="flex-col justify-center text-center sm:flex-row lg:justify-start"
			>
				<Tab :fullWidth="false">
					<Tab.Button class="flex items-center py-4 cursor-pointer">
						<Lucide icon="User" class="w-4 h-4 mr-2" /> Persona Details
					</Tab.Button>
				</Tab>
				<Tab :fullWidth="false">
					<Tab.Button class="flex items-center py-4 cursor-pointer">
						<Lucide icon="Shield" class="w-4 h-4 mr-2" /> Account
					</Tab.Button>
				</Tab>
				<Tab :fullWidth="false">
					<Tab.Button class="flex items-center py-4 cursor-pointer">
						<Lucide icon="Settings" class="w-4 h-4 mr-2" /> Settings
					</Tab.Button>
				</Tab>
				<Tab :fullWidth="false">
					<Tab.Button class="flex items-center py-4 cursor-pointer">
						<Lucide icon="Trash2" class="w-4 h-4 mr-2" /> Crypt
					</Tab.Button>
				</Tab>
			</Tab.List>
		</div>
</template>