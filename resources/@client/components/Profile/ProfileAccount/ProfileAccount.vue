<script setup lang="ts">
	import ProfileAccountPersona from "@/components/Profile/ProfileAccountPersona";
	import ProfileAccountSettings from "@/components/Profile/ProfileAccountSettings";
	import ProfileAccountPassword from "@/components/Profile/ProfileAccountPassword";
	import ProfileAccountWaiver from "@/components/Profile/ProfileAccountWaiver";
	import ProfileAccountRetainers from "@/components/Profile/ProfileAccountRetainers";
	import ProfileAccountDues from "@/components/Profile/ProfileAccountDues";
	import ProfileAccountSocials from "@/components/Profile/ProfileAccountSocials";
	import { ref } from "vue";
	import Lucide from "@/components/Base/Lucide";
	import { Persona, PersonaSuperSimple } from "@/interfaces";
	import { useAuthStore } from "@/stores/auth";
	
	const auth = useAuthStore()
	const isActive = ref<string>('persona')

	const props = defineProps<{
		persona: Persona | undefined
	}>()

	const setActive = (target: string) => {
        isActive.value = target;
    };

	interface AccountEmit {
		(e: "updated", value: Persona): void;
	}

	const emit = defineEmits<AccountEmit>();

	const updatePersona = (updatedPersona: Persona) => {
		emit("updated", updatedPersona);
	};
</script>
<template>
	<div class="grid grid-cols-12 gap-6">
		<!-- BEGIN: Edit Profile Menu -->
		<div
			class="flex flex-col-reverse col-span-12 lg:col-span-4 2xl:col-span-3 lg:block"
		>
			<div class="mt-5 intro-y box">
				<div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
					<a class="flex items-center mt-5" :class="{ 'text-primary font-medium': isActive === 'persona' }" href="#" @click.prevent="setActive('persona')">
						<Lucide icon="Activity" class="w-4 h-4 mr-2" /> Persona Information
					</a>
					<a class="flex items-center mt-5" :class="{ 'text-primary font-medium': isActive === 'retainers' }" href="#" @click.prevent="setActive('retainers')">
						<Lucide icon="Activity" class="w-4 h-4 mr-2" /> Retainers
					</a>
				</div>
				<div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
					<a class="flex items-center mt-5" :class="{ 'text-primary font-medium': isActive === 'socials' }" href="#" @click.prevent="setActive('socials')">
						<Lucide icon="Lock" class="w-4 h-4 mr-2" /> Social Networks
					</a>
					<a v-if="persona && persona?.id === auth.getUser.persona.id" class="flex items-center mt-5" :class="{ 'text-primary font-medium': isActive === 'settings' }" href="#" @click.prevent="setActive('settings')">
						<Lucide icon="Box" class="w-4 h-4 mr-2" /> Account Settings
					</a>
					<a v-if="persona?.id === auth.getUser.persona.id" class="flex items-center mt-5" :class="{ 'text-primary font-medium': isActive === 'password' }" href="#" @click.prevent="setActive('password')">
						<Lucide icon="Lock" class="w-4 h-4 mr-2" /> Change Password
					</a>
					<a class="flex items-center mt-5" :class="{ 'text-primary font-medium': isActive === 'waiver' }" href="#" @click.prevent="setActive('waiver')">
						<Lucide icon="Settings" class="w-4 h-4 mr-2" /> Waivers
					</a>
					<a class="flex items-center mt-5" :class="{ 'text-primary font-medium': isActive === 'dues' }" href="#" @click.prevent="setActive('dues')">
						<Lucide icon="Box" class="w-4 h-4 mr-2" /> Dues
					</a>
				</div>
			</div>
		</div>
		<!-- END: Edit Profile Menu -->
		<div class="col-span-12 lg:col-span-8 2xl:col-span-9">
			<ProfileAccountPersona :persona="persona" @updated="updatePersona" v-if="isActive === 'persona'" />
			<ProfileAccountSettings :persona="persona" v-if="isActive === 'settings'" />
			<ProfileAccountPassword :persona="persona" v-if="isActive === 'password'" />
			<ProfileAccountWaiver :persona="persona" v-if="isActive === 'waiver'" />
			<ProfileAccountRetainers :persona="persona" @updated="updatePersona" v-if="isActive === 'retainers'" />
			<ProfileAccountDues :persona="persona" @updated="updatePersona" v-if="isActive === 'dues'" />
			<ProfileAccountSocials :persona="persona" @updated="updatePersona" v-if="isActive === 'socials'" />
		</div>
	</div>
</template>