<script setup lang="ts">
	import { Persona, PersonaSuperSimple, PronounSuperSimple } from "@/interfaces";
	import _ from "lodash";
	import { ref, onMounted, reactive, toRefs } from "vue";
	import Button from "@/components/Base/Button";
	import {
		FormSelect,
		FormInput,
		FormLabel,
	} from "@/components/Base/Form";
	import Lucide from "@/components/Base/Lucide";
	import Tippy from "@/components/Base/Tippy";
	import { useAuthStore } from '@/stores/auth';
	import { useStateStore } from '@/stores/state';
	import axios from 'axios';
	import { useVuelidate } from "@vuelidate/core";
	import { PersonaRules } from "@/rules";
	import { PersonaTips } from "@/tips";
	import Dropzone from "@/components/Base/Dropzone";
	import { showToast } from "@/utils/toast";

	const auth = useAuthStore()
	const state = useStateStore()
	const props = defineProps<{
		persona: Persona | undefined
	}>()
	const pronouns = ref<PronounSuperSimple[]>([]);
	const defaultHeraldry = 'https://ork.amtgard.com/assets/heraldry/player/000000.jpg'
	const defaultImage = 'https://ork.amtgard.com/assets/image/player/000000.jpg'
	
	const personaFormData = reactive<PersonaSuperSimple>({
		id: props.persona?.id || 0,
		chapter_id: props.persona?.chapter_id || 0,
		name: props.persona?.name || '',
		mundane: props.persona?.mundane || '',
		pronoun_id: props.persona?.pronoun_id || 0,
		honorific_id: props.persona?.honorific_id || 0,
		heraldry: props.persona?.heraldry || '',
		image: props.persona?.image || '',
		is_active: props.persona?.is_active || 1,
		reeve_qualified_expires_at: props.persona?.reeve_qualified_expires_at || '',
		corpora_qualified_expires_at: props.persona?.corpora_qualified_expires_at || '',
		joined_chapter_at: props.persona?.joined_chapter_at || ''
	});
	
	const validate = useVuelidate(PersonaRules, toRefs(personaFormData));
	
	onMounted(async () => {
		try {
			await axios.get('/api/pronouns')
				.then(response => {
					pronouns.value = response.data.data
				})
				.catch(error => {
					state.storeState('error', error)
					showToast(false, 'Error fetching pronouns: ' + error)
					console.log('Error fetching pronouns:', error);
				})
		} catch (error) {
			state.storeState('error', 'Error fetching pronouns: ' + error)
			showToast(false, 'Error fetching pronouns: ' + error)
			console.error('Error fetching pronouns:', error);
		}
	});

	const removeHeraldry = () => {
		personaFormData.heraldry = defaultHeraldry;
	};

	const removeImage = () => {
		personaFormData.image = defaultImage;
	};

	const updateHeraldry = (file: any) => {
		let response = JSON.parse(file.xhr.response)
		if (response.success) {
			personaFormData.heraldry = response.data
			showToast(true, 'Heraldry uploaded.')
			console.log(personaFormData)
			saveAccount()
		}else{
			state.storeState('error', response.data.message)
			showToast(false, 'Error uploading heraldry: ' + response.data.message)
			console.error('Error uploading heraldry:', response.data.message);
		}
	};

	const updateImage = (file: any) => {
		let response = JSON.parse(file.xhr.response)
		if (response.success) {
			personaFormData.image = response.data
			showToast(true, 'Image uploaded.')
			saveAccount()
		}else{
			state.storeState('error', response.data.message)
			showToast(false, 'Error uploading image: ' + response.data.message)
			console.error('Error uploading image:', response.data.message);
		}
	};

	const saveAccount = async () => {
		validate.value.$touch();
		if (validate.value.$invalid) {
			showToast(false, "Please check the form.")
		} else {
			try {
				await axios.put('/api/personas/' + props.persona?.id, personaFormData)
					.then(response => {
						showToast(true, response.data.message)
					})
					.catch(error => {
						state.storeState('error', error.response.data.message)
						console.log('Error saving persona:', error)
						showToast(false, error.response.data.message) 
					});
			} catch (error: any) {
				state.storeState('error', error)
				console.log('Error saving persona:', error)
				showToast(false, error)
			}
		}
	};
</script>
<template>
	<div class="col-span-12 lg:col-span-8 2xl:col-span-9">
		<div class="intro-y box lg:mt-5">
			<div
				class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400"
			>
				<h2 class="mr-auto text-base font-medium">Persona</h2>
			</div>
			<div class="p-5">
				<div class="flex flex-col xl:flex-row">
					<form class="validate-form" enctype="multipart/form-data" @submit.prevent="saveAccount">
						<div class="flex-1 mt-6 xl:mt-0">
							<div class="grid grid-cols-12 gap-x-5">
								<div class="col-span-12 2xl:col-span-6">
									<div>
										<FormLabel htmlFor="name">
											Persona Name
											<Tippy
												:content="PersonaTips.name"
												class="inline-block"
											>
												<Lucide icon="HelpCircle" class="w-4 h-4" />
											</Tippy>
										</FormLabel>
										<FormInput
											id="name"
											name="name"
											v-model.trim="validate.name.$model"
											type="text"
											:placeholder="PersonaTips.name"
											:class="{
												'border-danger': validate.name.$error,
											}"
										/>
										<template v-if="validate.name.$error">
											<div
												v-for="(error, index) in validate.name.$errors"
												:key="index"
												class="mt-2 text-danger"
											>
												{{ error.$message }}
											</div>
										</template>
									</div>
									<div class="mt-3">
										<FormLabel htmlFor="pronoun_id">
											Pronouns
											<Tippy
												:content="PersonaTips.pronoun_id"
												class="inline-block"
											>
												<Lucide icon="HelpCircle" class="w-4 h-4" />
											</Tippy>
										</FormLabel>
										<FormSelect 
											id="pronoun_id" 
											v-model.trim="validate.pronoun_id.$model"
											name="pronoun_id"
											:class="{
												'border-danger': validate.pronoun_id.$error,
											}"
											placeholder="Pronouns"
										>
											<option value="0" disabled selected>Pronouns</option>
											<option
												v-for="(pronoun, pronounKey) in pronouns"
												:key="pronounKey"
												:value="pronoun.id"
											>
												{{ pronoun.subject + '/' + pronoun.object }}
											</option>
										</FormSelect>
									</div>
								</div>
								<div class="col-span-12 2xl:col-span-6">
									<div class="mt-3 2xl:mt-0">
										<FormLabel htmlFor="mundane">
											Mundane Name
											<Tippy
												:content="PersonaTips.mundane"
												class="inline-block"
											>
												<Lucide icon="HelpCircle" class="w-4 h-4" />
											</Tippy>
										</FormLabel>
										<FormInput
											id="mundane"
											name="mundane"
											v-model.trim="validate.mundane.$model"
											type="text"
											:placeholder="PersonaTips.mundane"
											:class="{
												'border-danger': validate.mundane.$error,
											}"
										/>
									</div>
									<div class="mt-3">
										<FormLabel htmlFor="persona-honorifics">
											Preferred Honorific
											<Tippy
												:content="PersonaTips.honorific_id"
												class="inline-block"
											>
												<Lucide icon="HelpCircle" class="w-4 h-4" />
											</Tippy>
										</FormLabel>
										<FormSelect 
											id="honorific_id" 
											name="honorific_id"
											v-model.trim="validate.honorific_id.$model"
											placeholder="Pronouns"
											:class="{
												'border-danger': validate.honorific_id.$error,
											}"
										>
											<option value="0" disabled selected>Titles</option>
											<option
												v-for="(title, index) in persona?.titleIssuances"
												:key="index"
												:value="title.id"
											>
												{{ title.name }}
											</option>
										</FormSelect>
									</div>
								</div>
							</div>
							<Button variant="primary" type="submit" class="w-20 mt-3">
								Save
							</Button>
						</div>
						<div class="mx-auto w-52 xl:mr-0 xl:ml-6">
							<div
								class="p-5 border-2 border-dashed rounded-md shadow-sm border-slate-200/60 dark:border-darkmode-400"
							>
								<span v-if="personaFormData.image && !personaFormData.image?.includes('000000.jpg')">
									<div
										class="relative h-40 mx-auto cursor-pointer image-fit zoom-in"
									>
										<img
											class="rounded-md"
											:alt="persona?.name"
											:src="personaFormData?.image || defaultImage"
										/>
										<Tippy
											as="div"
											@click="removeImage"
											content="Remove this image?"
											class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 -mt-2 -mr-2 text-white rounded-full bg-danger"
										>
											<Lucide icon="X" class="w-4 h-4" />
										</Tippy>
									</div>
									<div class="relative mx-auto mt-5 cursor-pointer">
										<Button variant="primary" type="button" class="w-full">
											Change Image
										</Button>
										<FormInput
											id="image"
											name="image"
											type="file"
											class="absolute top-0 left-0 w-full h-full opacity-0"
										/>
									</div>
								</span>
								<span v-else>
									<Dropzone 
										refKey="dropzoneImageRef" 
										:options="{
											url: 'http://orga.localhost/api/image',
											thumbnailWidth: 150,
											maxFilesize: 1,
											maxFiles: 1,
											params: () => ({
												context: 'image',
												target: persona?.id
											}),
											headers: { 
												Authorization: `Bearer ${auth.token}`
											}
										}"
										@completed="updateImage"
										class="dropzone"
									>
										<div class="text-lg font-medium">
											Drop image here or click to upload.
										</div>
									</Dropzone>
								</span>
							</div>
							<div
								class="p-5 border-2 border-dashed rounded-md shadow-sm border-slate-200/60 dark:border-darkmode-400"
							>
								<span v-if="personaFormData.heraldry && !personaFormData.heraldry?.includes('000000.jpg')">
									<div
										class="relative h-40 mx-auto cursor-pointer image-fit zoom-in"
									>
										<img
											class="rounded-md"
											:alt="persona?.name"
											:src="personaFormData?.heraldry || defaultHeraldry"
										/>
										<Tippy
											as="div"
											@click="removeHeraldry"
											content="Remove this heraldry?"
											class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 -mt-2 -mr-2 text-white rounded-full bg-danger"
										>
											<Lucide icon="X" class="w-4 h-4" />
										</Tippy>
									</div>
									<div class="relative mx-auto mt-5 cursor-pointer">
										<Button variant="primary" type="button" class="w-full">
											Change Heraldry
										</Button>
										<FormInput
											id="heraldry"
											name="heraldry"
											type="file"
											class="absolute top-0 left-0 w-full h-full opacity-0"
										/>
									</div>
								</span>
								<span v-else>
									<Dropzone 
										refKey="dropzoneHeraldryRef" 
										:options="{
											url: 'http://orga.localhost/api/image',
											thumbnailWidth: 150,
											maxFilesize: 1,
											maxFiles: 1,
											params: () => ({
												context: 'heraldry',
												target: persona?.id
											}),
											headers: { 
												Authorization: `Bearer ${auth.token}`
											}
										}"
										@completed="updateHeraldry"
										class="dropzone"
									>
										<div class="text-lg font-medium">
											Drop heraldry here or click to upload.
										</div>
									</Dropzone>
								</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>