export const DueTips = {
	persona_id: "ID of the Dues payer",
	recipient_type: "Type of who recieved the payment, Chapter or Realm",
	recipient_id: "ID of the entity that accepted this payment",
	dues_on: "When the dues were paid",
	amount: "Amount paid in USD",
	type: "How the dues were paid, in Cash (including digital), Assets, or Checking (ACH transfers or checks)",
	memo: "Any additional unusual notes about the Transaction",
}

export const IssuanceTips = {
	issuable: "Issuance (Award or Title) that is being given out.",
	issuable_type: "The Issuance type; Award or Title.",
	issuable_id: "The Issuance.",
	whereable: "Where the Issuance was given out.",
	whereable_type: "Where it was Issued, if known; Event, Location, or Meetup.",
	whereable_id: "Where it was Issued.",
	issuer: "The authority (Chapter, Realm, Unit, Persona) Issuing the honor.",
	issuer_type: "Issuing authority; Chapter, Persona, Realm, or Unit.",
	issuer_id: "The Issuing authority.",
	recipient: "Persona or Unit receiving the Issuance",
	recipient_type: "The nature of the Issuance recipient; Persona or Unit.",
	recipient_id: "The Issuance recipient.",
	signator: "For Issuances not from Personas, the Persona that authorized the Issuance.",
	signator_id: "Persona signing the Issuance, if any.",
	custom_name: "Where label options are avaiable, or customization allowed, the chosen label, else empty.",
	rank: "For laddered Issuances, the order number, else empty.",
	parent: "For Persona Issuances, the Issuer's authorizing Title linked to this Issuance; this describes a belted line.",
	parent_id: "For Persona Issuances, The ID of the Title Issuance from which this Issuance was given.",
	issued_on: "When the Issuance was made or is to be made public (if in the future).",
	reason: "A historical record of what the Issuance was for.",
	image: "An image of the Issuance phyrep, if any.",
	revoked_by: "ID of the Persona that revoked the Issuance, if any.",
	revoked_on: "Date the revocation is effective, if any.",
	revocation: "Cause for the revocation, if any."
}

export const PersonaTips = {
	name: "Your full persona name, free of corpora or RoP titles",
	mundane: "The name or alias you use to sign in with",
	slug: "A unique URL appropriate string used to access the profile.  These are first-come first serve.  Honorifics are fine here.  Communitiy standards and the terms of use for the site are to be followed",
	pronoun_id: "The pronouns you prefer to use",
	honorific_id: "The title you prefer to be refered with",
	image: "An image or artwork of the player or persona",
	heraldry: "An image or artwork of the persona's personal heraldry",
	email: "Changes to your access email will require validation",
	password: "Passwords must be between 6 and 191 characters, must include at least one of each: regular character, number, special character, and uppercase letter, and you cannot use a recently used password",
	password_confirm: "Make sure it matches the other one"
}

export const RecommendationTips = {
	honor: "Select the Award or Title you think they should receive",
	rank: "What rank you feel they've earned.  Their next rank will be autofilled.",
	reason: "What they did to deserve the selected honor"
}

export const SocialTips = {
	sociable_type: "Whom the Social is for; Chapter ,Event, Persona, Realm, or Unit",
	sociable_id: "ID of Social owner",
	media: "The social media platform; Discord, Facebook, Instagram, TiTok, Youtube, or Web",
	value: "The properly formatted username for the platform, or a link (for Web)"
}

export const TransactionTips = {
	description: "Description of the sort of transaction and for whom (ex: Dues Paid for xyz)",
	memo: "If necessary, notes about the Transaction",
	transaction_on: "When the Transaction occured",
}