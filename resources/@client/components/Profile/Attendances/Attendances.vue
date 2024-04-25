<script setup lang="ts">
	import { ref, computed, watchEffect, onMounted } from "vue";
	import { Tab, Menu } from "@/components/Base/Headless";
	import { Tab as HeadlessTab } from "@headlessui/vue";
	import Button from "@/components/Base/Button";
	import { 
		Attendance,
		Persona
	} from '@/interfaces';
	import { hslToHex, formatDate } from "@/utils/helper";
	import Lucide from "@/components/Base/Lucide";
	import Table from "@/components/Base/Table";
	import { useColorSchemeStore } from "@/stores/color-scheme";
	import AttendanceLineChart from "@/components/AttendanceLineChart";
	import { getColor } from "@/utils/colors";
	import { type ChartData } from "chart.js/auto";
	import { useStateStore } from '@/stores/state';
	import axios from 'axios';
	import Loader from "@/components/Base/Loader";
	
	const state = useStateStore()
	const props = defineProps<{
		persona_id: number
	}>()
	const persona = ref<Persona>()
	const isLoading = ref<boolean>(false)
	
	onMounted(() => {
		fetchPersonaData()
	})
	
	const fetchPersonaData = async () => {
		try {
			isLoading.value = true
			let withArray = [
				'attendances',
				'attendances.attendable'
			];
			let withJoin = withArray.map(item => `with[]=${item}`).join('&');
			await axios.get("/api/personas/" + props.persona_id + "?" + withJoin)
				.then(response => {
					isLoading.value = false
					persona.value = response.data.data;
				});
		} catch (error: any) {
			isLoading.value = false
			state.storeState('error', error)
			console.error('Error fetching user data:', error);
		}
	};

	const currentDate = new Date();
	const oneYearAgo = new Date(currentDate.getTime() - (365 * 24 * 60 * 60 * 1000));
	const colorScheme = computed(() => useColorSchemeStore().colorScheme);
	
	const monthNames: string[] = [
		"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
	];
	
	const showYear = ref(currentDate.getFullYear())
	const selectShowYear = (year: number) => {
		showYear.value = year
	}
	
	const yearGroupedAttendances = ref<{ [year: number]: Attendance[] }>({});
	const getYearGroupedAttendances = () => {
		const grouped: { [year: number]: Attendance[] } = {};
		if(persona.value?.attendances){
			for (const attendance of persona.value.attendances as Attendance[]) {
				const year = new Date(attendance.attended_at).getFullYear()
				if (!grouped[year]) {
					grouped[year] = []
				}
				grouped[year].push(attendance)
			}
		}
		yearGroupedAttendances.value = grouped
	}
	
	const sortAttendancesBy = (attribute: string) => {
		if(persona.value?.attendances) {
			const targetAttendances = { ...yearGroupedAttendances.value };
			switch (attribute) {
				case 'attended_at':
					for (const year in targetAttendances) {
						if (Object.prototype.hasOwnProperty.call(targetAttendances, year)) {
							targetAttendances[year].sort((a, b) => {
								const dateA = a.attended_at ? new Date(a.attended_at).getTime() : 0;
								const dateB = b.attended_at ? new Date(b.attended_at).getTime() : 0;
								return dateA - dateB;
							});
						}
					}
					yearGroupedAttendances.value = targetAttendances
					break;
				case 'name':
					for (const year in targetAttendances) {
						if (Object.prototype.hasOwnProperty.call(targetAttendances, year)) {
							targetAttendances[year].sort((a, b) => {
								const nameA = (a.attendable.name || '').toUpperCase();
								const nameB = (b.attendable.name || '').toUpperCase();
								if (!nameA && nameB) {
									return -1;
								}
								if (nameA && !nameB) {
									return 1;
								}
								if (nameA < nameB) {
									return -1;
								}
								if (nameA > nameB) {
									return 1;
								}
								return 0;
							})
						}
					}
					yearGroupedAttendances.value = targetAttendances
					break;
				case 'credits':
					for (const year in targetAttendances) {
						if (Object.prototype.hasOwnProperty.call(targetAttendances, year)) {
							targetAttendances[year].sort((a, b) => {
								const rankA = a.credits ? a.credits : 0;
								const rankB = b.credits ? b.credits : 0;
								return rankB - rankA;
							});
						}
					}
					yearGroupedAttendances.value = targetAttendances
					break;
				default:
					// Do nothing if an invalid attribute is provided
					break;
			}
		}
	}
	
	const uniqueYears = ref<number[]>([]);
	const getUniqueYears = () => {
		const years = new Set<number>()
		if(persona.value?.attendances){
			for (const attendance of persona.value.attendances) {
				const year = new Date(attendance.attended_at).getFullYear()
				years.add(year)
			};
		}
		uniqueYears.value = Array.from(years).sort((a, b) => b - a)
	}
	
	const updateAttendanceChart = (year: number | null | string) => {
		if (year === null) {
			year = currentDate.getFullYear()
		}
		if (!isNaN(Number(year))) {
			const startDate = new Date(Number(year), 0, 1);
			const endDate = new Date(Number(year), 11, 31);
			if (persona.value?.attendances) {
				const attendancesForYear = persona.value.attendances.filter(attendance => {
					const attendedDate = new Date(attendance.attended_at);
					return attendedDate >= startDate && attendedDate <= endDate;
				});
				const counts = Array.from({ length: 12 }, () => 0);
				for (const attendance of attendancesForYear) {
					const monthIndex = new Date(attendance.attended_at).getMonth();
					counts[monthIndex]++;
				}
				const attendanceDataForYear = {
					labels: monthNames,
					datasets: [
						{
							label: `Attendances for ${year}`,
							data: counts,
							borderWidth: 2,
							borderColor: colorScheme.value ? getColor("primary", 0.8) : "",
							backgroundColor: "transparent",
							pointBorderColor: "transparent",
							tension: 0.4,
						}
					]
				};
				attendanceYearData.value = attendanceDataForYear;
			}
		} else if (year === 'all') {
			const datasets = []
			const yearCount = uniqueYears.value.length
			for (let i = 0; i < yearCount; i++) {
			    const tYear = uniqueYears.value[i];
				if (persona.value?.attendances) {
					const hue = (i / yearCount) * 255
				    const borderColor = `${hslToHex(hue, 50, 50)}`
					const startDate = new Date(tYear, 0, 1)
					const endDate = new Date(tYear, 11, 31)
					const attendancesForYear = persona.value.attendances.filter(attendance => {
						const attendedDate = new Date(attendance.attended_at);
						return attendedDate >= startDate && attendedDate <= endDate;
					});
					const counts = Array.from({ length: 12 }, () => 0);
					for (const attendance of attendancesForYear) {
						const monthIndex = new Date(attendance.attended_at).getMonth();
						counts[monthIndex]++;
					}
					datasets.push({
						label: `${tYear}`,
						data: counts,
						borderWidth: 1,
						borderColor: borderColor,
						backgroundColor: borderColor,
						pointBorderColor: borderColor,
						tension: 0.4,
					})
				}
			}
			const attendanceDataForYear = {
				labels: monthNames,
				datasets: datasets
			};
			attendanceYearData.value = attendanceDataForYear;
		}
	}

	const attendanceYearData = ref<ChartData>()
	const getAttendanceYearData = () => {
		if(persona.value?.attendances) {
			const recentAttendances = persona.value.attendances.filter(attendance => {
				const attendedDate = new Date(attendance.attended_at);
				return attendedDate >= oneYearAgo && attendedDate <= currentDate;
			});
			const uniqueMonths = recentAttendances.map(attendance => new Date(attendance.attended_at).getMonth());
			const uniqueSortedMonths:number[] = Array.from(new Set(uniqueMonths)).sort();

			const counts = Array.from({ length: 12 }, () => 0);
			// Iterate over recent attendances and count attendances for each month
			for (const attendance of recentAttendances) {
				const monthIndex = new Date(attendance.attended_at).getMonth();
				counts[monthIndex]++;
			}
			attendanceYearData.value = {
				labels: uniqueSortedMonths.map(month => monthNames[month]),
				datasets: [
					{
						label: "Attendances Last 12 Months",
						data: counts,
						borderWidth: 2,
						borderColor: colorScheme.value ? getColor("primary", 0.8) : "",
						backgroundColor: "transparent",
						pointBorderColor: "transparent",
						tension: 0.4,
					}
				]
			}
		}
	}
	
	const deleteConfirmationModal = ref(false)
	const setDeleteConfirmationModal = (value: boolean) => {
		deleteConfirmationModal.value = value
	};
	
	watchEffect(() => {
	    if (props.persona_id) {
			getUniqueYears()
			getYearGroupedAttendances()
			selectShowYear(currentDate.getFullYear())
			getAttendanceYearData()
		}
	})
</script>

<template>
					<Tab.Group class="col-span-12 intro-y box lg:col-span-6" style="height: 100%; overflow-y: scroll;">
						<Loader 
							:active="isLoading"
							message="Loading Attendance Data"
						/>
						<div
							class="flex items-center px-5 py-5 border-b sm:py-0 border-slate-200/60 dark:border-darkmode-400"
						>
							<h2 class="mr-auto text-base font-medium py-5">Attendances</h2>
							<Menu 
								class="ml-auto sm:hidden"
							>
								<Menu.Button tag="a" class="block w-5 h-5" href="#">
									<Lucide
										icon="MoreHorizontal"
										class="w-5 h-5 text-slate-500"
									/>
								</Menu.Button>
								<Menu.Items 
									class="w-40"
								>
									<Menu.Item class="w-full" :as="HeadlessTab"> Last 6 Months </Menu.Item>
									<Menu.Item class="w-full" :as="HeadlessTab"> By Year </Menu.Item>
									<Menu.Item class="w-full" :as="HeadlessTab"> Graph </Menu.Item>
								</Menu.Items>
							</Menu>
							<Tab.List
								variant="link-tabs"
								class="hidden w-auto ml-auto sm:flex"
							>
								<Tab :fullWidth="false">
									<Tab.Button class="py-5 cursor-pointer"> Last 6 Months </Tab.Button>
								</Tab>
								<Tab :fullWidth="false">
									<Tab.Button class="py-5 cursor-pointer"> By Year </Tab.Button>
								</Tab>
								<Tab :fullWidth="false">
									<Tab.Button class="py-5 cursor-pointer"> Graph </Tab.Button>
								</Tab>
							</Tab.List>
						</div>
						<div class="p-5" style="padding-top: 0px">
							<Tab.Panels>
								<!-- Begin: Last 6 Panel -->
								<Tab.Panel>
									<div class="grid grid-cols-12 gap-6 mt-5">
										<div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap justify-between">
											<span class="relative">&nbsp;</span>
											<Menu>
												<Menu.Button :as="Button" class="px-2 !box">
													<span class="flex items-center justify-center w-5 h-5">
														<Lucide icon="Shuffle" class="w-4 h-4" />
													</span>
												</Menu.Button>
												<Menu.Items class="w-40">
													<Menu.Item @click="sortAttendancesBy('attended_at')">
														<Lucide icon="Sunrise" class="w-4 h-4 mr-2" /> Date
													</Menu.Item>
													<Menu.Item @click="sortAttendancesBy('name')">
														<Lucide icon="MapPin" class="w-4 h-4 mr-2" /> Attended
													</Menu.Item>
													<Menu.Item @click="sortAttendancesBy('credits')">
														<Lucide icon="ChevronsDown" class="w-4 h-4 mr-2" /> Credits
													</Menu.Item>
												</Menu.Items>
											</Menu>
										</div>
										<!-- BEGIN: Last Six Months List -->
										<div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
											<Table class="border-spacing-y-[10px] border-separate -mt-2" bordered hover>
												<Table.Thead>
													<Table.Tr>
														<Table.Th class="whitespace-nowrap"> Date </Table.Th>
														<Table.Th class="whitespace-nowrap"> Attended </Table.Th>
														<Table.Th class="whitespace-nowrap text-center"> Credits </Table.Th>
														<Table.Th class="whitespace-nowrap text-center"> Actions </Table.Th>
													</Table.Tr>
												</Table.Thead>
												<Table.Tbody>
													<Table.Tr
														v-for="(attendance, index) in persona?.attendances?.filter(attendance => new Date(attendance.attended_at) >= new Date(new Date().setMonth(new Date().getMonth() - 6)))"
														:key="index"
														class="intro-x"
													>
														<Table.Td
															class="py-3 px-5 border-b dark:border-darkmode-300 box text-left rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
														>
															<a href="" class="font-medium whitespace-nowrap">
																{{ formatDate(attendance.attended_at, "MMMM DD, YYYY") }}
															</a>
														</Table.Td>
														<Table.Td
															class="box px-1 rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
														>
															<div style="overflow: hidden; height: 18px">
																{{ attendance.attendable.name }}
															</div>
														</Table.Td>
														<Table.Td
															class="box px-1 rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
														>
															{{ attendance.credits }}
														</Table.Td>
														<Table.Td
															:class="[
																'box px-1 w-15 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
																'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
															]"
														>
															<div class="flex items-center justify-center px-3">
																<a v-if="attendance.can_update" class="flex items-center mr-3" href="#">
																	<Lucide icon="CheckSquare" class="w-4 h-4 mr-1" />
																</a>
																<a
																	v-if="attendance.can_delete"
																	class="flex items-center text-danger"
																	href="#"
																	@click="
																		(event) => {
																			event.preventDefault();
																			setDeleteConfirmationModal(true);
																		}
																	"
																>
																	<Lucide icon="Trash2" class="w-4 h-4 mr-1" />
																</a>
															</div>
														</Table.Td>
													</Table.Tr>
												</Table.Tbody>
											</Table>
										</div>
										<!-- END: Attendance List -->
									</div>
								</Tab.Panel>
								<!-- END: Last 6 Panel -->
								<!-- Begin: Years Panels -->
								<Tab.Panel>
									<div 
										class="grid grid-cols-12 gap-6 mt-5"
									>
										<div 
											class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap justify-between"
										>
											<Menu>
												<Menu.Button :as="Button" class="px-2 !box">
													<span class="flex items-center justify-center w-5 h-5 px-5">
														{{ showYear }}
													</span>
												</Menu.Button>
												<Menu.Items class="h-32 overflow-y-auto" placement="right-start">
													<Menu.Item v-for="(year, index) in uniqueYears" :key="index" @click="selectShowYear(year)">
														{{ year }}
													</Menu.Item>
												</Menu.Items>
											</Menu>
											<Menu>
												<Menu.Button :as="Button" class="px-2 !box">
													<span class="flex items-center justify-center w-5 h-5">
														<Lucide icon="Shuffle" class="w-4 h-4" />
													</span>
												</Menu.Button>
												<Menu.Items class="w-40">
													<Menu.Item @click="sortAttendancesBy('attended_at')">
														<Lucide icon="Sunrise" class="w-4 h-4 mr-2" /> Date
													</Menu.Item>
													<Menu.Item @click="sortAttendancesBy('name')">
														<Lucide icon="MapPin" class="w-4 h-4 mr-2" /> Attended
													</Menu.Item>
													<Menu.Item @click="sortAttendancesBy('credits')">
														<Lucide icon="ChevronsDown" class="w-4 h-4 mr-2" /> Credits
													</Menu.Item>
												</Menu.Items>
											</Menu>
										</div>
										<!-- BEGIN: Years List -->
										<div 
											class="col-span-12 overflow-auto intro-y lg:overflow-visible"
										>
											<div
												v-for="(yearAttendances, year) in yearGroupedAttendances" :key="year"
											>
												<Table 
													v-if="showYear == year"
													class="border-spacing-y-[10px] border-separate -mt-2" bordered hover
												>
													<Table.Thead>
														<Table.Tr>
															<Table.Th class="whitespace-nowrap"> Date </Table.Th>
															<Table.Th class="whitespace-nowrap"> Attended </Table.Th>
															<Table.Th class="whitespace-nowrap text-center"> Credits </Table.Th>
															<Table.Th class="whitespace-nowrap text-center"> Actions </Table.Th>
														</Table.Tr>
													</Table.Thead>
													<Table.Tbody>
														<Table.Tr
															v-for="(attendance, index) in yearAttendances"
															:key="index"
															class="intro-x"
														>
															<Table.Td
																class="py-3 px-5 border-b dark:border-darkmode-300 box text-left rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
															>
																<a href="" class="font-medium whitespace-nowrap">
																	{{ formatDate(attendance.attended_at, "MMMM DD, YYYY") }}
																</a>
															</Table.Td>
															<Table.Td
																class="box px-1 rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
															>
																<div style="overflow: hidden; height: 18px">
																	{{ attendance.attendable.name }}
																</div>
															</Table.Td>
															<Table.Td
																class="box px-1 rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
															>
																{{ attendance.credits }}
															</Table.Td>
															<Table.Td
																:class="[
																	'box px-1 w-15 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
																	'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
																]"
															>
																<div class="flex items-center justify-center px-3">
																	<a v-if="attendance.can_update" class="flex items-center mr-3" href="#">
																		<Lucide icon="CheckSquare" class="w-4 h-4 mr-1" />
																	</a>
																	<a
																		v-if="attendance.can_delete"
																		class="flex items-center text-danger"
																		href="#"
																		@click="
																			(event) => {
																				event.preventDefault();
																				setDeleteConfirmationModal(true);
																			}
																		"
																	>
																		<Lucide icon="Trash2" class="w-4 h-4 mr-1" />
																	</a>
																</div>
															</Table.Td>
														</Table.Tr>
													</Table.Tbody>
												</Table>
											</div>
										</div>
										<!-- END: Years List -->
									</div>
								</Tab.Panel>
								<!-- END: Years Panel -->
								<!-- BEGIN: Graph Panel -->
								<Tab.Panel>
									<div 
										class="grid grid-cols-12 gap-6 mt-5"
									>
										<div 
											class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap justify-between"
										>
											<Menu>
												<Menu.Button :as="Button" class="px-2 !box">
													<span class="flex items-center justify-center w-5 h-5 px-5">
														{{ showYear }}
													</span>
												</Menu.Button>
												<Menu.Items class="h-32 overflow-y-auto" placement="right-start">
													<Menu.Item v-for="(year, index) in uniqueYears" :key="index" @click="updateAttendanceChart(year)">
														{{ year }}
													</Menu.Item>
												</Menu.Items>
											</Menu>
											<Menu>
												<Menu.Button :as="Button" class="px-2 !box">
													<span class="flex items-center justify-center w-5 h-5">
														<Lucide icon="Search" class="w-4 h-4" />
													</span>
												</Menu.Button>
												<Menu.Items class="w-40">
													<Menu.Item @click="updateAttendanceChart(showYear)">
														<Lucide icon="Calendar" class="w-4 h-4 mr-2" /> Year
													</Menu.Item>
													<Menu.Item @click="updateAttendanceChart('all')">
														<Lucide icon="Activity" class="w-4 h-4 mr-2" /> All
													</Menu.Item>
												</Menu.Items>
											</Menu>
										</div>
										<div 
											class="col-span-12 overflow-auto intro-y lg:overflow-visible"
										>
											<AttendanceLineChart 
												:data="attendanceYearData"
												:height="275" 
												class="mt-6 -mb-6"
											/>
										</div>
									</div>
								</Tab.Panel>
								<!-- END: Graph Panel -->
							</Tab.Panels>
						</div>
					</Tab.Group>
</template>
