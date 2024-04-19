<script setup lang="ts">
	import { ref } from "vue";
	import logoUrl from "@/assets/images/logo.png";
	import Lucide from "@/components/Base/Lucide";
	import Breadcrumb from "@/components/Base/Breadcrumb";
	import { FormInput } from "@/components/Base/Form";
	import { Menu, Popover } from "@/components/Base/Headless";
	import _ from "lodash";
	import { TransitionRoot } from "@headlessui/vue";
	import { useAuthStore } from '@/stores/auth';
	import { useStateStore } from '@/stores/state';
	import { useRouter } from 'vue-router';
	import Notification from "@/components/Base/Notification";
	import debounce from "lodash/debounce";
	import { showToast } from '@/utils/toast';
	import axios from 'axios';
	import dayjs from 'dayjs';
	
	const thisRouter = useRouter()
	const auth = useAuthStore()
	const user = auth.getUser
	const state = useStateStore()
	
	const navigateToProfile = () => {
		thisRouter.push('/profile');
	};
	
	interface ChapterSearchResult extends SearchResult {
		id: number;
		name: string;
		heraldry?: string;
		abbreviation?: string;
		full_abbreviation?: string;
		chapter_full_abbreviation?: string;
		realm: {
			name: string;
		};
	}
	
	interface SearchResult {
		id: number;
		name: string;
		heraldry?: string;
		abbreviation?: string;
		full_abbreviation?: string;
		chapter_full_abbreviation?: string;
		image?: string;
		event_started_at?: string;
		type?: string;
		email?: string;
	}
	const searchDropdown = ref(false);
	const showSearchDropdown = () => {
		searchDropdown.value = true;
	};
	const hideSearchDropdown = () => {
		searchDropdown.value = false;
	};
	const searchText = ref('')
	const searchData = ref({
		Chapters: [] as ChapterSearchResult[],
		Events: [] as SearchResult[],
		Personas: [] as SearchResult[],
		Realms: [] as SearchResult[],
		Users: [] as SearchResult[],
		Units: [] as SearchResult[],
	});
	
	const onInput = debounce(async () => {
		hideSearchDropdown();
		try {
			const response = await axios.post('api/search', { search: searchText.value });
			searchData.value = response.data.data;
			showSearchDropdown()
		} catch (error) {
			throw error;
		}
	}, 300);
	
	const logout = async () => {
		try {
			auth.logout()
				.then(response => {
					state.storeState('success', 'You have been logged out.');
					thisRouter.push('/');
				})
				.catch(error => {
					state.storeState('error', error)
					console.log('Error logging out:', error)
					showToast(false, error.response.data.message)
				});
		} catch (error:any) {
			state.storeState('error', error)
			console.log('Error logging out:', error)
			showToast(false, error)
		}
	};
</script>

<template>
	<!-- BEGIN: Top Bar -->
	<div
		class="top-bar-boxed relative z-[51] -mx-5 mb-12 mt-12 h-[70px] border-b border-white/[0.08] px-3 sm:-mx-8 sm:px-8 md:-mt-5 md:pt-0"
	>
		<div class="flex h-full items-center">
			<!-- BEGIN: Logo -->
			<RouterLink
				:to="{ name: 'home' }"
				class="hidden -intro-x md:flex"
			>
				<img
					alt="ORK4"
					class="w-6"
					:src="logoUrl"
				/>
				<span class="ml-3 text-lg text-white"> ORK4 </span>
			</RouterLink>
			<!-- END: Logo -->
			<!-- BEGIN: Breadcrumb -->
			<Breadcrumb
				light
				class="h-full md:ml-10 md:pl-10 md:border-l border-white/[0.08] mr-auto -intro-x"
			>
				<a :href="'https://www.amtgard.com'" target="_blank">Amtgard</a>
				<template v-for="(crumb, index) in state.breadcrumb.crumbs" :key="index">
					<Breadcrumb.Link :to="crumb.link" :active="index === state.breadcrumb.depth">
						&nbsp;>&nbsp;{{ crumb.label }}
					</Breadcrumb.Link>
				</template>
			</Breadcrumb>
			<!-- END: Breadcrumb -->
			<!-- BEGIN: Search -->
			<div class="relative mr-3 intro-x sm:mr-6">
				<div class="hidden search sm:block">
					<FormInput
						type="text"
						class="border-transparent w-56 shadow-none rounded-full bg-slate-200 pr-8 transition-[width] duration-300 ease-in-out focus:border-transparent focus:w-72 dark:bg-darkmode-400/70"
						placeholder="Search..."
						v-model="searchText"
						@input="onInput"
						@blur="hideSearchDropdown"
					/>
					<Lucide
						icon="Search"
						class="absolute inset-y-0 right-0 w-5 h-5 my-auto mr-3 text-slate-600 dark:text-slate-500"
					/>
				</div>
				<a class="relative text-white/70 sm:hidden" href="">
					<Lucide icon="Search" class="w-5 h-5 dark:text-slate-500" />
				</a>
				<TransitionRoot
					as="template"
					:show="searchDropdown"
					enter="transition-all ease-linear duration-150"
					enterFrom="mt-5 invisible opacity-0 translate-y-1"
					enterTo="mt-[3px] visible opacity-100 translate-y-0"
					entered="mt-[3px]"
					leave="transition-all ease-linear duration-150"
					leaveFrom="mt-[3px] visible opacity-100 translate-y-0"
					leaveTo="mt-5 invisible opacity-0 translate-y-1"
				>
					<div class="absolute right-0 z-10 mt-[3px]">
						<div class="w-[450px] p-5 box">
							<div v-if="searchData.Chapters.length > 0">
								<div class="mb-2 font-medium">Chapters</div>
								<div class="mb-5" v-for="chapter in searchData.Chapters" :key="chapter.id">
									<a
										:href="`/chapters/${chapter.id}`"
										class="flex items-center mt-2"
									>
										<div class="w-8 h-8 image-fit" v-if="chapter.heraldry">
											<img
												alt="chapter.name"
												class="rounded-full"
												:src="chapter.heraldry"
											/>
										</div>
										<div
											class="flex items-center justify-center w-8 h-8 rounded-full bg-pending/20 dark:bg-pending/10 text-dark"
											v-else
										>
											<Lucide icon="Home" class="w-4 h-4" />
										</div>
										<div class="ml-3">{{ chapter.name }}</div>
										<div
											class="w-48 ml-auto text-xs text-right truncate text-slate-500"
										>
											{{ chapter.realm.name }}
										</div>
									</a>
								</div>
							</div>
							<div v-if="searchData.Events.length > 0">
								<div class="mb-2 font-medium">Events</div>
								<div class="mb-5" v-for="event in searchData.Events" :key="event.id">
									<a
										:href="`/events/${event.id}`"
										class="flex items-center mt-2"
									>
										<div class="w-8 h-8 image-fit" v-if="event.image">
											<img
												alt="event.name"
												class="rounded-full"
												:src="event.image"
											/>
										</div>
										<div
											class="flex items-center justify-center w-8 h-8 rounded-full bg-dark dark:bg-dark text-warning"
											v-else
										>
											<Lucide icon="Calendar" class="w-4 h-4" />
										</div>
										<div class="ml-3">{{ event.name }}</div>
										<div
											class="w-48 ml-auto text-xs text-right truncate text-slate-500"
										>
											{{ dayjs(event.event_started_at).format('MMM DD, YYYY') }}
										</div>
									</a>
								</div>
							</div>
							<div v-if="searchData.Personas.length > 0">
								<div class="mb-2 font-medium">Personas</div>
								<div class="mb-5" v-for="persona in searchData.Personas" :key="persona.id">
									<a
										:href="`/personas/${persona.id}`"
										class="flex items-center mt-2"
									>
										<div class="w-8 h-8 image-fit" v-if="persona.heraldry || persona.image">
											<img
												alt="persona.name"
												class="rounded-full"
												:src="persona.heraldry ? persona.heraldry : persona.image"
											/>
										</div>
										<div
											class="flex items-center justify-center w-8 h-8 rounded-full bg-success/20 dark:bg-success/10 text-dark"
											v-else
										>
											<Lucide icon="User" class="w-4 h-4" />
										</div>
										<div class="ml-3">{{ persona.name }}</div>
										<div
											class="w-48 ml-auto text-xs text-right truncate text-slate-500"
										>
											{{ persona.chapter_full_abbreviation }}
										</div>
									</a>
								</div>
							</div>
							<div v-if="searchData.Realms.length > 0">
								<div class="mb-2 font-medium">Realms</div>
								<div class="mb-5" v-for="realm in searchData.Realms" :key="realm.id">
									<a
										:href="`/realms/` + realm.id"
										class="flex items-center mt-2"
									>
										<div class="w-8 h-8 image-fit" v-if="realm.heraldry">
											<img
												alt="realm.name"
												class="rounded-full"
												:src="realm.heraldry"
											/>
										</div>
										<div
											class="flex items-center justify-center w-8 h-8 rounded-full bg-warning/20 dark:bg-warning/10 text-dark"
											v-else
										>
											<Lucide icon="Shield" class="w-4 h-4" />
										</div>
										<div class="ml-3">{{ realm.name }}</div>
										<div
											class="w-48 ml-auto text-xs text-right truncate text-slate-500"
										>
											{{ realm.abbreviation }}
										</div>
									</a>
								</div>
							</div>
							<div v-if="searchData.Units.length > 0">
								<div class="mb-2 font-medium">Units</div>
								<div class="mb-5" v-for="unit in searchData.Units" :key="unit.id">
									<a
										:href="`/units/${unit.id}`"
										class="flex items-center mt-2"
									>
										<div class="w-8 h-8 image-fit" v-if="unit.heraldry">
											<img
												alt="unit.name"
												class="rounded-full"
												:src="unit.heraldry"
											/>
										</div>
										<div
											class="flex items-center justify-center w-8 h-8 rounded-full bg-danger/20 dark:bg-danger/10 text-dark"
											v-else
										>
											<Lucide icon="Link" class="w-4 h-4" />
										</div>
										<div class="ml-3">{{ unit.name }}</div>
										<div
											class="w-48 ml-auto text-xs text-right truncate text-slate-500"
										>
											{{ unit.type }}
										</div>
									</a>
								</div>
							</div>
							<div v-if="searchData.Users.length > 0">
								<div class="mb-2 font-medium">Users</div>
								<div class="mb-5" v-for="user in searchData.Users" :key="user.id">
									<a
										:href="`/users/${user.id}`"
										class="flex items-center mt-2"
									>
									<div
										class="flex items-center justify-center w-8 h-8 rounded-full bg-primary/10 dark:bg-primary/20 text-dark"
									>
										<Lucide icon="Users" class="w-4 h-4" />
									</div>
										<div class="ml-3">{{ user.name }}</div>
										<div
											class="w-48 ml-auto text-xs text-right truncate text-slate-500"
										>
											{{ user.email }}
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</TransitionRoot>
			</div>
			<!-- END: Search -->
				<!-- BEGIN: Notifications -->
				<Popover v-if="auth.isLoggedIn" class="mr-4 intro-x sm:mr-6">
					<Popover.Button
						class="relative text-white/70 outline-none block before:content-[''] before:w-[8px] before:h-[8px] before:rounded-full before:absolute before:top-[-2px] before:right-0 before:bg-danger"
					>
						<Lucide icon="Bell" class="w-5 h-5 dark:text-slate-500" />
					</Popover.Button>
					<Popover.Panel class="w-[280px] sm:w-[350px] p-5 mt-2">
						<div class="mb-5 font-medium">Messages</div>
<!--						<div-->
<!--							v-for="(faker, fakerKey) in _.take(fakerData, 5)"-->
<!--							:key="fakerKey"-->
<!--							:class="[-->
<!--								'cursor-pointer relative flex items-center',-->
<!--								{ 'mt-5': fakerKey },-->
<!--							]"-->
<!--						>-->
<!--							<div class="relative flex-none w-12 h-12 mr-1 image-fit">-->
<!--								<img-->
<!--									alt="faker.users[0].name"-->
<!--									class="rounded-full"-->
<!--									:src="faker.photos[0]"-->
<!--								/>-->
<!--								<div-->
<!--									class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full bg-success dark:border-darkmode-600"-->
<!--								></div>-->
<!--							</div>-->
<!--							<div class="ml-2 overflow-hidden">-->
<!--								<div class="flex items-center">-->
<!--									<a href="" class="mr-5 font-medium truncate">-->
<!--										{{ faker.users[0].name }}-->
<!--									</a>-->
<!--									<div class="ml-auto text-xs text-slate-400 whitespace-nowrap">-->
<!--										{{ faker.times[0] }}-->
<!--									</div>-->
<!--								</div>-->
<!--								<div class="w-full truncate text-slate-500 mt-0.5">-->
<!--									{{ faker.news[0].shortContent }}-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->
						<div
							:class="[
								'cursor-pointer relative flex items-center',
								{ 'mt-5': 0 },
							]"
						>
							<div class="relative flex-none w-12 h-12 mr-1 image-fit">
								<img
									:alt="'Chibasama Ryúichiro'"
									class="rounded-full"
									:src="'https://ork.amtgard.com/assets/players/007947.jpg'"
								/>
								<div
									class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full bg-success dark:border-darkmode-600"
								></div>
							</div>
							<div class="ml-2 overflow-hidden">
								<div class="flex items-center">
									<a href="" class="mr-5 font-medium truncate">
										Chibasama Ryúichiro
									</a>
									<div class="ml-auto text-xs text-slate-400 whitespace-nowrap">
										3/30/24 9:11am
									</div>
								</div>
								<div class="w-full truncate text-slate-500 mt-0.5">
									Coming Soon! Contact players, officers, or admins internally!
								</div>
							</div>
						</div>
					</Popover.Panel>
				</Popover>
				<!-- END: Notifications -->
				<!-- BEGIN: Account Menu -->
				<Menu v-if="auth.isLoggedIn">
					<Menu.Button
						class="block w-8 h-8 overflow-hidden scale-110 rounded-full shadow-lg image-fit zoom-in intro-x"
					>
						<img
							alt="Midone Tailwind HTML Admin Template"
							:src="user.persona.image"
						/>
					</Menu.Button>
					<Menu.Items
						class="w-56 mt-px relative bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white"
					>
						<Menu.Header class="font-normal">
							<div class="font-medium">{{ user.persona.name }}</div>
							<div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">
								{{ user.persona.mundane }}
							</div>
						</Menu.Header>
						<Menu.Divider class="bg-white/[0.08]" />
						<Menu.Item @click="navigateToProfile" class="hover:bg-white/5">
							<Lucide icon="User" class="w-4 h-4 mr-2" /> Profile
						</Menu.Item>
						<Menu.Item class="hover:bg-white/5">
							<Lucide icon="Lock" class="w-4 h-4 mr-2" /> Reset Password
						</Menu.Item>
						<Menu.Item class="hover:bg-white/5">
							<Lucide icon="HelpCircle" class="w-4 h-4 mr-2" /> Help
						</Menu.Item>
						<Menu.Divider class="bg-white/[0.08]" />
						<Menu.Item @click="logout" class="hover:bg-white/5">
							<Lucide icon="ToggleRight" class="w-4 h-4 mr-2" /> Logout
						</Menu.Item>
					</Menu.Items>
				</Menu>
				<!-- END: Account Menu -->
				<!-- Login Link -->
				<router-link v-if="!auth.isLoggedIn" to="/login" class="text-primary dark:text-slate-300 text-white/90">Login</router-link>
		</div>
	</div>
	<!-- END: Top Bar -->
</template>