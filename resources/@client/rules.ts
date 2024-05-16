import {
	required,
	minLength,
	maxLength,
	integer,
	email,
	minValue,
	sameAs,
	helpers,
	requiredIf
} from "@vuelidate/validators";
import { IssuanceSuperSimple } from "./interfaces";

const slugValidator = helpers.withMessage(
	'The slug must contain only letters, numbers, underscores, and hyphens.',
	helpers.regex(/^[A-Za-z0-9_-]*$/)
);

export const IssuanceRules = {
	id: {
	},
	issuable_type: {
		required,
		validate: (value: string) => {
			return ['Award', 'Title'].includes(value);
		}
	},
	issuable_id: {
		required,
	},
	whereable_type: {
		validate: (value: string) => {
			return ['Event', 'Meetup', 'Location'].includes(value);
		}
	},
	whereable_id: {
	},
	issuer_type: {
		required,
		validate: (value: string) => {
			return ['Chapter', 'Realm', 'Persona', 'Unit'].includes(value);
		}
	},
	issuer_id: {
		required,
	},
	recipient_type: {
		required,
		validate: (value: string) => {
			return ['Persona', 'Unit'].includes(value);
		}
	},
	recipient_id: {
		required,
	},
	signator_id: {
	},
	custom_name: {
	},
	rank: {
	},
	parent_id: {
	},
	issued_on: {
		required,
	},
	reason: {
	},
	image: {
	},
	revoked_by: {
	},
	revoked_on: {
	},
	revocation: {
	},
}

export const PersonaRules = {
	id: {
	},
	chapter_id: {
		required,
	},
	name: {
		required,
		maxLength: maxLength(191),
	},
	mundane: {
		required,
		maxLength: maxLength(191),
	},
	slug: {
		maxLength: maxLength(25),
		slugValidator
	},
	pronoun_id: {
		required,
	},
	honorific_id: {
	},
	heraldry: {
	},
	image: {
	},
	is_active: {
	},
	reeve_qualified_expires_at: {
	},
	corpora_qualified_expires_at: {
	},
	joined_chapter_at: {
	}
};

export const RecommendationRules = {
	honor: {
		required: helpers.withMessage('Please select an honor', required)
	},
	rank: {
		integer: helpers.withMessage('Rank must be an integer', required)
	},
	reason: {
		required: helpers.withMessage('Let the rest of us know why', required)
	},
};

export const Register = {
	email: {
		required,
		email,
		minLength: minLength(5),
		maxLength: maxLength(191),
	},
	invite_token: {
		required,
	},
	device_name: {
		required,
	},
	pronoun_id: {
		required,
		integer,
		minValue: minValue(1),
	},
	password: {
		required,
		minLength: minLength(6),
	},
	password_confirm: {
		required,
		minLength: minLength(6),
		maxLength: maxLength(191),
	},
	is_agreed: {
		sameAs: sameAs(true)
	},
};

export const SocialRules = {
	id: {
	},
	sociable_type: {
		required,
	},
	sociable_id: {
		required,
	},
	media: {
		required,
	},
	value: {
		required
	},
};

export const UserRules = {
	id: {
		required
	},
	persona_id: {
		required,
	},
	email: {
		required,
		email,
		maxLength: maxLength(191),
	},
	email_verified_at: {
	},
	is_restricted: {
	},
};
function withParams(arg0: { type: string; }, arg1: (value: any) => boolean) {
	throw new Error("Function not implemented.");
}

