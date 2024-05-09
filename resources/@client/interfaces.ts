export interface Account {
	id: number
	parent_id?: number | null
	accountable_type: "Realm" | "Chapter" | "Unit"
	accountable_id: number
	name: string
	type: "Imbalance" | "Income" | "Expense" | "Asset" | "Liability" | "Equity"
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	parent?: AccountSimple
	splits?: SplitSimple[]
	accountable: RealmSimple | ChapterSimple | UnitSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface AccountSimple {
	id: number
	parent_id?: number | null
	accountable_type: "Realm" | "Chapter" | "Unit"
	accountable_id: number
	name: string
	type: "Imbalance" | "Income" | "Expense" | "Asset" | "Liability" | "Equity"
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface AccountSuperSimple {
	id: number
	parent_id: number | null
	accountable_type: "Realm" | "Chapter" | "Unit"
	accountable_id: number
	name: string
	type: "Imbalance" | "Income" | "Expense" | "Asset" | "Liability" | "Equity"
}
export interface Archetype {
	id: number
	name: string
	is_active: 0 | 1
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	attendances?: AttendanceSimple[]
	reconciliations?: ReconciliationSimple[]
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface ArchetypeSimple {
	id: number
	name: string
	is_active: 0 | 1
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface ArchetypeSuperSimple {
	id: number
	name: string
	is_active: 0 | 1
}
export interface Attendance {
	id: number
	persona_id: number
	archetype_id: number
	attendable_type: "Meetup" | "Event"
	attendable_id: number
	attended_at: string
	credits: number
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	attendable: MeetupSimple | EventSimple
	archetype: ArchetypeSimple
	persona: PersonaSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface AttendanceSimple {
	id: number
	persona_id: number
	archetype_id: number
	attendable_type: "Meetup" | "Event"
	attendable_id: number
	attended_at: string
	credits: number
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface AttendanceSuperSimple {
	id: number
	persona_id: number
	archetype_id: number
	attendable_type: "Meetup" | "Event"
	attendable_id: number
	attended_at: string
	credits: number
}
export interface Award {
	id: number
	awarder_type: "Realm" | "Chapter" | "Unit"
	awarder_id?: number | null
	name: string
	is_active: 0 | 1
	is_ladder: 0 | 1
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	awarder: RealmSimple | ChapterSimple | UnitSimple
	issuances?: IssuanceSimple[]
	recommendations?: RecommendationSimple[]
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface AwardSimple {
	id: number
	awarder_type: "Realm" | "Chapter" | "Unit"
	awarder_id: number | null
	name: string
	is_active: 0 | 1
	is_ladder: 0 | 1
	created_by: number
	updated_by: number | null
	deleted_by: number | null
	created_at: string
	updated_at: string | null
	deleted_at: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
	rank: null
	peerage: null
}
export interface AwardSuperSimple {
	id: number
	awarder_type: "Realm" | "Chapter" | "Unit"
	awarder_id: number | null
	name: string
	is_active: 0 | 1
	is_ladder: 0 | 1
}
export interface Chapter {
	id: number
	realm_id: number
	chaptertype_id: number
	location_id: number
	name: string
	abbreviation: string
	full_abbreviation: string
	heraldry: string
	is_active: 0 | 1
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	accounts?: Account[]
	awards?: Award[]
	chaptertype?: ChaptertypeSimple
	events?: Event[]
	issuances?: Issuance[]
	location?: LocationSimple
	meetups?: Meetup[]
	nearbyGuests?: Guest[]
	personas?: Persona[]
	realm?: Realm
	reign?: Reign
	reigns?: Reign[]
	socials?: Social[]
	sponsors?: Event[]
	suspensions?: Suspension[]
	titles?: Title[]
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface ChapterSimple {
	id: number
	realm_id: number
	chaptertype_id: number
	location_id: number
	name: string
	abbreviation: string
	full_abbreviation: string
	heraldry: string
	is_active: 0 | 1
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface ChapterSuperSimple {
	id: number
	realm_id: number
	chaptertype_id: number
	location_id: number
	name: string
	abbreviation: string
	full_abbreviation: string
	heraldry: string
	is_active: 0 | 1
}
export interface Chaptertype {
	id: number
	realm_id: number
	name: string
	rank?: number | null
	minimumattendance: number
	minimumcutoff?: number | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	chapters?: ChapterSimple[]
	offices?: OfficeSimple[]
	realm: RealmSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface ChaptertypeSimple {
	id: number
	realm_id: number
	name: string
	rank?: number | null
	minimumattendance: number
	minimumcutoff?: number | null
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface ChaptertypeSuperSimple {
	id: number
	realm_id: number
	name: string
	rank: number | null
	minimumattendance: number
	minimumcutoff?: number | null
}
export interface Crat {
	id: number
	event_id: number
	persona_id: number
	name: string
	is_autocrat: 0 | 1
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	event: EventSimple
	persona: PersonaSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface CratSimple {
	id: number
	event_id: number
	persona_id: number
	name: string
	is_autocrat: 0 | 1
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface CratSuperSimple {
	id: number
	event_id: number
	persona_id: number
	name: string
	is_autocrat: 0 | 1
}
export interface Due {
	id: number
	persona_id: number
	transaction_id: number
	dues_on: string
	intervals?: number | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	persona: PersonaSimple
	transaction: TransactionSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface DueSimple {
	id: number
	persona_id: number
	transaction_id: number
	dues_on: string
	intervals?: number | null
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface DueSuperSimple {
	id: number
	persona_id: number
	transaction_id: number
	dues_on: string
	intervals: number | null
}
export interface Event {
	id: number
	eventable_type: 'Chapter' | 'Realm' | 'Persona' | 'Unit'
	eventable_id: number
	sponsorable_type?: 'Chapter' | 'Realm'
	sponsorable_id?: number
	location_id?: number
	name: string
	description?: string
	image?: string
	is_active: 0 | 1
	is_demo: 0 | 1
	event_started_at: string
	event_ended_at: string
	price?: number
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	attendances?: AttendanceSimple[]
	crats?: CratSimple[]
	eventable: ChapterSimple | RealmSimple | PersonaSimple | UnitSimple
	guests?: AccountSimple[]
	issuances?: IssuanceSimple[]
	location?: LocationSimple
	socials?: SocialSimple[]
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface EventSimple {
	id: number
	eventable_type: 'Realm' | 'Chapter' | 'Unit' | 'Persona'
	eventable_id: number
	sponsorable_type?: 'Chapter' | 'Realm'
	sponsorable_id?: number
	location_id?: number
	name: string
	description?: string
	image?: string
	is_active: 0 | 1
	is_demo: 0 | 1
	event_started_at: string
	event_ended_at: string
	price?: number
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface EventSuperSimple {
	id: number
	eventable_type: 'Realm' | 'Chapter' | 'Unit' | 'Persona'
	eventable_id: number
	sponsorable_type: 'Chapter' | 'Realm' | null
	sponsorable_id: number
	location_id: number | null
	name: string
	description: string | null
	image: string | null
	is_active: 0 | 1
	is_demo: 0 | 1
	event_started_at: string
	event_ended_at: string
	price: number | null
}
export interface Guest {
	id: number
	event_id: number
	chapter_id?: number | null
	waiver_id: number
	is_followedup: 0 | 1
	notes?: string | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	event: EventSimple
	chapter: ChapterSimple
	waiver: WaiverSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface GuestSimple {
	id: number
	event_id: number
	chapter_id?: number | null
	waiver_id: number
	is_followedup: 0 | 1
	notes?: string | null
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface GuestSuperSimple {
	id: number
	event_id: number
	chapter_id: number | null
	waiver_id: number
	is_followedup: 0 | 1
	notes: string | null
}
export interface Issuance {
	id: number
	issuable_type: 'Award' | 'Title'
	issuable_id: number
	whereable_type?: 'Event' | 'Meetup' | 'Location' | null
	whereable_id?: number | null
	issuer_type: 'Chapter' | 'Realm' | 'Persona' | 'Unit'
	issuer_id: number
	recipient_type: 'Persona' | 'Unit'
	recipient_id: number
	signator_id?: number | null
	name: string
	custom_name?: string | null
	rank?: number | null
	parent_id: number | null
	issued_at: string
	reason?: string | null
	image: string
	revoked_by?: number | null
	revoked_at?: string | null
	revocation?: string | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	issuable: AwardSimple | TitleSimple
	issuer: ChapterSimple | RealmSimple | PersonaSimple | UnitSimple
	recipient: PersonaSimple | UnitSimple
	revoker?: PersonaSimple | null
	signator?: PersonaSimple | null
	whereable?: EventSimple | LocationSimple | MeetupSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface IssuanceSimple {
	id: number
	issuable_type: 'Award' | 'Title'
	issuable_id: number
	whereable_type?: 'Event' | 'Meetup' | 'Location' | null
	whereable_id?: number | null
	issuer_type: 'Chapter' | 'Realm' | 'Persona' | 'Unit'
	issuer_id: number
	recipient_type: 'Persona' | 'Unit'
	recipient_id: number
	signator_id?: number | null
	name: string
	custom_name?: string | null
	rank?: number | null
	parent_id: number | null
	issued_at: string
	reason?: string | null
	image: string
	revoked_by?: number | null
	revoked_at?: string | null
	revocation?: string | null
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	issuable: AwardSimple | TitleSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface IssuanceSuperSimple {
	id: number
	issuable_type: 'Award' | 'Title'
	issuable_id: number
	whereable_type: 'Event' | 'Meetup' | 'Location' | null
	whereable_id: number | null
	issuer_type: 'Chapter' | 'Realm' | 'Persona' | 'Unit'
	issuer_id: number
	recipient_type: 'Persona' | 'Unit'
	recipient_id: number
	signator_id: number | null
	custom_name: string | null
	rank: number | null
	parent_id: number | null
	issued_at: string
	reason: string | null
	image: string
	revoked_by: number | null
	revoked_at: string | null
	revocation: string | null
}
export interface Location {
	id: number
	name?: string | null
	address?: string | null
	city?: string | null
	province?: string | null
	postal_code?: string | null
	country?: string | null
	google_geocode?: string | null
	latitude?: number | null
	longitude?: number | null
	location?: string | null
	map_url?: string | null
	directions?: string | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	chapters?: ChapterSimple[]
	events?: EventSimple[]
	issuances?: IssuanceSimple[]
	meetups?: MeetupSimple[]
	waivers?: WaiverSimple[]
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface LocationSimple {
	id: number
	name?: string | null
	address?: string | null
	city?: string | null
	province?: string | null
	postal_code?: string | null
	country?: string | null
	google_geocode?: string | null
	latitude?: number | null
	longitude?: number | null
	location?: string | null
	map_url?: string | null
	directions?: string | null
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface LocationSuperSimple {
	id: number
	name: string | null
	address: string | null
	city: string | null
	province: string | null
	postal_code: string | null
	country: string | null
	google_geocode: string | null
	latitude: number | null
	longitude: number | null
	location: string | null
	map_url: string | null
	directions: string | null
}
export interface Meetup {
	id: number
	chapter_id: number
	location_id?: number | null
	name: string
	is_active: 0 | 1
	purpose: 'Park Day' | 'Fighter Practice' | 'A&S Gathering' | 'Other'
	recurrence: 'Weekly' | 'Monthly' | 'Week-of-Month'
	week_of_month?: number | null
	week_day: 'None' | 'Monday' | 'Tuesday' | 'Wednesday' | 'Thursday' | 'Friday' | 'Saturday' | 'Sunday'
	month_day?: number | null
	occurs_at: string
	description?: string | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	attendances?: Attendance[]
	chapter: ChapterSimple
	issuances?: IssuanceSimple[]
	location?: LocationSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface MeetupSimple {
	id: number
	chapter_id: number
	location_id?: number | null
	name: string
	is_active: 0 | 1
	purpose: 'Park Day' | 'Fighter Practice' | 'A&S Gathering' | 'Other'
	recurrence: 'Weekly' | 'Monthly' | 'Week-of-Month'
	week_of_month?: number | null
	week_day: 'None' | 'Monday' | 'Tuesday' | 'Wednesday' | 'Thursday' | 'Friday' | 'Saturday' | 'Sunday'
	month_day?: number | null
	occurs_at: string
	description?: string | null
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface MeetupSuperSimple {
	id: number
	chapter_id: number
	location_id: number | null
	name: string
	is_active: 0 | 1
	purpose: 'Park Day' | 'Fighter Practice' | 'A&S Gathering' | 'Other'
	recurrence: 'Weekly' | 'Monthly' | 'Week-of-Month'
	week_of_month: number | null
	week_day: 'None' | 'Monday' | 'Tuesday' | 'Wednesday' | 'Thursday' | 'Friday' | 'Saturday' | 'Sunday'
	month_day: number | null
	occurs_at: string
	description: string | null
}
export interface Member {
	id: number
	persona_id: number
	unit_id: number
	is_head: 0 | 1
	is_voting: 0 | 1
	joined_at?: string | null
	left_at?: string | null
	notes?: string | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	persona: PersonaSimple
	unit: Unit
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface MemberSimple {
	id: number
	persona_id: number
	unit_id: number
	is_head: 0 | 1
	is_voting: 0 | 1
	joined_at?: string | null
	left_at?: string | null
	notes?: string | null
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface MemberSuperSimple {
	id: number
	persona_id: number
	unit_id: number
	is_head: 0 | 1
	is_voting: 0 | 1
	joined_at: string | null
	left_at: string | null
	notes: string | null
}
export interface Office {
	id: number
	officeable_type: "Chaptertype" | "Realm" | "Unit"
	officeable_id: number
	name: string
	duration?: number | null
	is_forgiven?: 0 | 1
	is_midreign?: 0 | 1
	order?: number | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	officeable: ChaptertypeSimple | RealmSimple | UnitSimple
	officers: OfficerSimple[]
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface OfficeSimple {
	id: number
	officeable_type: "Chaptertype" | "Realm" | "Unit"
	officeable_id: number
	name: string
	duration?: number | null
	is_forgiven?: 0 | 1
	is_midreign?: 0 | 1
	order?: number | null
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface OfficeSuperSimple {
	id: number
	officeable_type: "Chaptertype" | "Realm" | "Unit"
	officeable_id: number
	name: string
	duration: number | null
	is_forgiven: 0 | 1 | null
	is_midreign: 0 | 1 | null
	order: number | null
}
export interface Officer {
	id: number
	officerable_type: "Reign" | "Unit"
	officerable_id: number
	office_id: number
	persona_id: number
	label?: string | null
	starts_on?: string | null
	ends_on?: string | null
	notes?: string | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	office: OfficeSimple
	officerable: ReignSimple | UnitSimple
	persona: PersonaSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface OfficerSimple {
	id: number
	officerable_type: "Reign" | "Unit"
	officerable_id: number
	office_id: number
	persona_id: number
	label?: string | null
	starts_on?: string | null
	ends_on?: string | null
	notes?: string | null
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface OfficerSuperSimple {
	id: number
	officerable_type: "Reign" | "Unit"
	officerable_id: number
	office_id: number
	persona_id: number
	label: string | null
	starts_on: string | null
	ends_on: string | null
	notes: string | null
}
export interface Persona {
	id: number
	chapter_id: number
	honorific_id?: number | null
	pronoun_id?: number | null
	mundane?: string | null
	name: string
	slug?: string | null
	heraldry: string
	image: string
	is_active: 0 | 1
	is_officer: 0 | 1
	is_paid: 0 | 1
	is_suspended: 0 | 1
	is_waivered: 0 | 1
	reeve_qualified_expires_at?: string | null
	corpora_qualified_expires_at?: string | null
	joined_chapter_at?: string | null
	chapter_full_abbreviation: string
	awards: AwardsReport
	credits: CreditReport
	roptitles?: TitleSimple[]
	titles?: Title[]
	score: number
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	attendances?: Attendance[]
	awardIssuances?: IssuanceSimple[]
	chapter?: Chapter
	crats?: CratSimple[]
	dues?: DueSimple[]
	events?: EventSimple[]
	honorific?: IssuanceSimple
	issuances?: IssuanceSimple[]
	retainers?: Issuance[]
	issuanceRevokeds?: IssuanceSimple[]
	issuanceSigneds?: IssuanceSimple[]
	memberships?: Member[]
	officers?: OfficerSimple[]
	pronoun?: PronounSimple
	recommendations?: Recommendation[]
	reconciliations?: ReconciliationSimple[]
	ropawards?: TitleSimple[]
	splits?: SplitSimple[]
	socials?: SocialSimple[]
	suspensions?: SuspensionSimple[]
	suspensionIssueds?: SuspensionSimple[]
	titleIssuances?: Issuance[]
	user?: UserSimple
	waivers?: Waiver[]
	waiverVerifieds?: WaiverSimple[]
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface PersonaSimple {
	id: number
	chapter_id: number
	honorific_id?: number | null
	pronoun_id?: number | null
	mundane?: string | null
	name: string
	slug?: string | null
	heraldry: string
	image: string
	is_active: 0 | 1
	is_officer: 0 | 1
	is_paid: 0 | 1
	is_suspended: 0 | 1
	is_waivered: 0 | 1
	reeve_qualified_expires_at?: string | null
	corpora_qualified_expires_at?: string | null
	joined_chapter_at?: string | null
	chapter_full_abbreviation: string
	awards: AwardsReport
	credits: CreditReport
	score: number
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
	abbreviation: null
	full_abbreviation: null
}
export interface PersonaSuperSimple {
	id: number
	chapter_id: number
	honorific_id: number | null
	pronoun_id: number | null
	mundane: string | null
	name: string
	slug: string | null
	heraldry: string
	image: string
	is_active: 0 | 1
	reeve_qualified_expires_at: string | null
	corpora_qualified_expires_at: string | null
	joined_chapter_at: string | null
}
export interface ArchetypeCredit {
	credits: number
	level: number
}
export interface ArchetypeCredits {
	[key: string]: ArchetypeCredit
}
export interface CreditReport {
	count: number
	attendance_count: number
	archetypes: ArchetypeCredits
}
export interface AwardInfo {
	rank: number
	issuances: Issuance[]
}
export interface AwardsReport {
	[awardName: string]: AwardInfo
}
export interface Pronoun {
	id: number
	subject: string
	object: string
	possessive: string
	possessivepronoun: string
	reflexive: string
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface PronounSimple {
	id: number
	subject: string
	object: string
	possessive: string
	possessivepronoun: string
	reflexive: string
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface PronounSuperSimple {
	id: number
	subject: string
	object: string
	possessive: string
	possessivepronoun: string
	reflexive: string
}
export interface Realm {
	id: number
	parent_id?: number | null
	name: string
	abbreviation: string
	color: string
	heraldry: string
	is_active: 0 | 1
	credit_minimum?: number | null
	credit_maximum?: number | null
	daily_minimum?: number | null
	weekly_minimum?: number | null
	average_period_type?: 'Week' | 'Month' | null
	average_period?: number | null
	dues_amount?: number | null
	dues_intervals_type?: 'Week' | 'Month' | null
	dues_intervals?: number | null
	dues_take?: number | null
	waiver_duration?: number | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	accounts?: AccountSimple[]
	ropawards?: AwardSimple[]
	roptitles?: TitleSimple[]
	awards?: AwardSimple[]
	chapters?: ChapterSimple[]
	chaptertypes?: ChaptertypeSimple[]
	events?: EventSimple[]
	issuances?: IssuanceSimple[]
	offices?: OfficeSimple[]
	reign?: ReignSimple
	reigns?: ReignSimple[]
	socials?: SocialSimple[]
	sponsors?: EventSimple[]
	suspensions?: SuspensionSimple[]
	titles?: TitleSimple[]
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface RealmSimple {
	id: number
	parent_id: number
	name: string
	abbreviation: string
	color: string
	heraldry: string
	is_active: 0 | 1
	credit_minimum?: number | null
	credit_maximum?: number | null
	daily_minimum?: number | null
	weekly_minimum?: number | null
	average_period_type?: 'Week' | 'Month' | null
	average_period?: number | null
	dues_amount?: number | null
	dues_intervals_type?: 'Week' | 'Month' | null
	dues_intervals?: number | null
	dues_take?: number | null
	waiver_duration?: number | null
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
	full_abbreviation: null
}
export interface RealmSuperSimple {
	id: number
	parent_id: number
	name: string
	abbreviation: string
	color: string
	heraldry: string
	is_active: 0 | 1
	credit_minimum: number | null
	credit_maximum: number | null
	daily_minimum: number | null
	weekly_minimum: number | null
	average_period_type: 'Week' | 'Month' | null
	average_period: number | null
	dues_amount: number | null
	dues_intervals_type: 'Week' | 'Month' | null
	dues_intervals: number | null
	dues_take: number | null
	waiver_duration: number | null
}
export interface Recommendation {
	id: number
	persona_id: number
	recommendable_type: 'Award' | 'Title'
	recommendable_id: number
	rank?: number | null
	is_anonymous: 0 | 1
	reason: string
	created_by: number
	createdBy: UserSimple | null
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	persona: PersonaSimple
	recommendable: AwardSimple | TitleSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface RecommendationSimple {
	id: number
	persona_id: number
	recommendable_type: 'Award' | 'Title'
	recommendable_id: number
	rank?: number | null
	is_anonymous: 0 | 1
	reason: string
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface RecommendationSuperSimple {
	id: number
	persona_id: number
	recommendable_type: 'Award' | 'Title'
	recommendable_id: number
	rank: number | null
	is_anonymous: 0 | 1
	reason: string
}
export interface RecommendFormData {
	honor: string
	persona_id: number | null
	recommendable_type: string | null
	recommendable_id: number | null
	rank: number | null
	reason: string | null
}
export interface Reconciliation {
	id: number
	archetype_id: number
	persona_id: number
	credits: number
	notes?: string | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	archetype: ArchetypeSimple
	persona: PersonaSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface ReconciliationSimple {
	id: number
	archetype_id: number
	persona_id: number
	credits: number
	notes?: string | null
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface ReconciliationSuperSimple {
	id: number
	archetype_id: number
	persona_id: number
	credits: number
	notes: string | null
}
export interface Reign {
	id: number
	reignable_type: "Chapter" | "Realm"
	reignable_id: number
	name?: string | null
	starts_on: string
	midreign_on: string
	ends_on: string
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	officers: OfficerSimple[]
	reignable: ChapterSimple | RealmSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface ReignSimple {
	id: number
	reignable_type: "Chapter" | "Realm"
	reignable_id: number
	name?: string | null
	starts_on: string
	midreign_on: string
	ends_on: string
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface ReignSuperSimple {
	id: number
	reignable_type: "Chapter" | "Realm"
	reignable_id: number
	name: string | null
	starts_on: string
	midreign_on: string
	ends_on: string
}
export interface Social {
	id: number
	sociable_type: "Chapter" | "Event" | "Persona" | "Realm" | "Unit"
	sociable_id: number
	media: "Discord" | "Facebook" | "Instagram" | "TicToc" | "YouTube" | "Web"
	value: string
	link: string
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	sociable: SocialSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface SocialSimple {
	id: number
	sociable_type: "Chapter" | "Event" | "Persona" | "Realm" | "Unit"
	sociable_id: number
	media: "Discord" | "Facebook" | "Instagram" | "TicToc" | "YouTube" | "Web"
	value: string
	link: string
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface SocialSuperSimple {
	id: number
	sociable_type: "Chapter" | "Event" | "Persona" | "Realm" | "Unit"
	sociable_id: number
	media: "Discord" | "Facebook" | "Instagram" | "TicToc" | "YouTube" | "Web"
	value: string
	link: string
}
export interface Split {
	id: number
	account_id: number
	persona_id: number
	transaction_id: number
	amount: number
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	account: AccountSimple
	persona: PersonaSimple
	transaction: TransactionSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface SplitSimple {
	id: number
	account_id: number
	persona_id: number
	transaction_id: number
	amount: number
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface SplitSuperSimple {
	id: number
	account_id: number
	persona_id: number
	transaction_id: number
	amount: number
}
export interface Suspension {
	id: number
	persona_id: number
	suspendable_type: 'Chapter' | 'Realm' | 'Persona' | 'Unit'
	suspendable_id: number
	suspended_by: number
	suspended_at?: string
	expires_at?: string
	cause: string
	is_propogating: 0 | 1
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	persona: PersonaSimple
	realm?: RealmSimple
	suspendedBy: PersonaSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface SuspensionSimple {
	id: number
	persona_id: number
	suspendable_type: 'Chapter' | 'Realm' | 'Persona' | 'Unit'
	suspendable_id: number
	suspended_by: number
	suspended_at?: string
	expires_at?: string
	cause: string
	is_propogating: 0 | 1
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface SuspensionSuperSimple {
	id: number
	persona_id: number
	suspendable_type: 'Chapter' | 'Realm' | 'Persona' | 'Unit'
	suspendable_id: number
	suspended_by: number
	suspended_at: string
	expires_at: string
	cause: string
	is_propogating: 0 | 1
}
export interface Title {
	id: number
	titleable_type: 'Chapter' | 'Persona' | 'Realm' | 'Unit'
	titleable_id: number
	name: string
	rank?: number
	peerage: 'Gentry' | 'Knight' | 'Master' | 'Nobility' | 'None' | 'Paragon' | 'Retainer'
	is_roaming: 0 | 1
	is_active: 0 | 1
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	issuances: IssuanceSimple[]
	titleable: ChapterSimple | PersonaSimple | RealmSimple | UnitSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface TitleSimple {
	id: number
	titleable_type: 'Chapter' | 'Persona' | 'Realm' | 'Unit'
	titleable_id: number
	name: string
	rank: number | null
	peerage: 'Gentry' | 'Knight' | 'Master' | 'Nobility' | 'None' | 'Paragon' | 'Retainer'
	is_roaming: 0 | 1
	is_active: 0 | 1
	created_by: number
	updated_by: number | null
	deleted_by: number | null
	created_at: string
	updated_at: string | null
	deleted_at: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface TitleSuperSimple {
	id: number
	titleable_type: 'Chapter' | 'Persona' | 'Realm' | 'Unit'
	titleable_id: number
	name: string
	rank: number
	peerage: 'Gentry' | 'Knight' | 'Master' | 'Nobility' | 'None' | 'Paragon' | 'Retainer'
	is_roaming: 0 | 1
	is_active: 0 | 1
}
export interface TitleSelectOption {
	label: string
	options?: { 
		value: number 
		text: string 
	}[]
}
export interface Tournament {
	id: number
	tournamentable_type: 'Chapter' | 'Event' | 'Realm'
	tournamentable_id: number
	name: string
	description?: string
	occured_at: string
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	tournamentable: ChapterSimple | EventSimple | RealmSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface TournamentSimple {
	id: number
	tournamentable_type: 'Chapter' | 'Event' | 'Realm'
	tournamentable_id: number
	name: string
	description?: string
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface TournamentSuperSimple {
	id: number
	tournamentable_type: 'Chapter' | 'Event' | 'Realm'
	tournamentable_id: number
	name: string
	description?: string
}
export interface Transaction {
	id: number
	description: string
	memo?: string
	transaction_at: string
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	dues: DueSimple[]
	splits: SplitSimple[]
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface TransactionSimple {
	id: number
	description: string
	memo?: string
	transaction_at: string
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface TransactionSuperSimple {
	id: number
	description: string
	memo: string
	transaction_at: string
}
export interface Unit {
	id: number
	type: "Company" | "Event" | "Household"
	name: string
	heraldry: string
	description?: string | null
	history?: string | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	accounts: AccountSimple[]
	awardIssuances: IssuanceSimple[]
	awards?: AwardSimple[]
	events: EventSimple[]
	retainers: IssuanceSimple[]
	issuanceReceived: IssuanceSimple[]
	members: MemberSimple[]
	officers: OfficerSimple[]
	offices: OfficeSimple[]
	socials: SocialSimple[]
	titles: TitleSimple[]
	titleIssueds: IssuanceSimple[]
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface UnitSimple {
	id: number
	type: "Company" | "Event" | "Household"
	name: string
	heraldry: string
	description?: string
	history?: string
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
	abbreviation: null
	full_abbreviation: null
}
export interface UnitSuperSimple {
	id: number
	type: "Company" | "Event" | "Household"
	name: string
	heraldry: string
	description: string | null
	history: string | null
}
export interface User {
	id: number
	persona_id: number
	name?: string | null
	email: string
	email_verified_at?: string | null
	password: string
	is_restricted: 0 | 1
	token?: string | null
		jsPermissions?: string | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface UserSimple {
	id: number
	persona_id: number
	name?: string | null
	email: string
	email_verified_at?: string | null
	password: string
	is_restricted: 0 | 1
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface UserSuperSimple {
	id: number
	persona_id: number
	email: string
	email_verified_at: string | null
	is_restricted: 0 | 1
}
export interface Waiver {
	id: number
	guest_id?: number | null
	location_id?: number | null
	pronoun_id?: number | null
	persona_id?: number | null
	waiverable_type: 'Realm' | 'Event'
	waiverable_id: number
	file: string
	player: string
	email?: string | null
	phone?: string | null
	dob?: string | null
	age_verified_at?: string | null
	age_verified_by?: number | null
	guardian?: string | null
	emergency_name?: string | null
	emergency_relationship?: string | null
	emergency_phone?: string | null
	signed_at: string
	expires_at: string | null
	created_by: number
	createdBy: UserSimple
	updated_by?: number | null
	updatedBy?: UserSimple | null
	deleted_by?: number | null
	deletedBy?: UserSimple | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	ageVerifiedBy?: PersonaSimple | null
	guest?: GuestSimple | null
	location?: LocationSimple | null
	persona?: PersonaSimple | null
	pronoun?: PronounSimple | null
	waiverable: RealmSimple | EventSimple
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface WaiverSimple {
	id: number
	guest_id?: number | null
	location_id?: number | null
	pronoun_id?: number | null
	persona_id?: number | null
	waiverable_type: 'Realm' | 'Event'
	waiverable_id: number
	file: string
	player: string
	email?: string | null
	phone?: string | null
	dob?: string | null
	age_verified_at?: string | null
	age_verified_by?: number | null
	guardian?: string | null
	emergency_name?: string | null
	emergency_relationship?: string | null
	emergency_phone?: string | null
	signed_at: string
	expires_at: string | null
	created_by: number
	updated_by?: number | null
	deleted_by?: number | null
	created_at: string
	updated_at?: string | null
	deleted_at?: string | null
	can_list: 0 | 1
	can_view: 0 | 1
	can_create: 0 | 1
	can_update: 0 | 1
	can_delete: 0 | 1
	can_restore: 0 | 1
	can_nuke: 0 | 1
}
export interface WaiverSuperSimple {
	id: number
	guest_id: number | null
	location_id: number | null
	pronoun_id: number | null
	persona_id: number | null
	waiverable_type: 'Realm' | 'Event'
	waiverable_id: number
	file: string
	player: string
	email: string | null
	phone: string | null
	dob: string | null
	age_verified_at: string | null
	age_verified_by: number | null
	guardian: string | null
	emergency_name: string | null
	emergency_relationship: string | null
	emergency_phone: string | null
	signed_at: string
	expires_at: string | null
}
export interface HonorSelectOption {
	label: string
	options?: { 
		value: number 
		text: string 
		type: string 
		is_ladder: number 
	}[]
}