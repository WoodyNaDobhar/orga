import {
    required,
    minLength,
    maxLength,
    integer,
    email,
    minValue,
    sameAs,
    helpers
} from "@vuelidate/validators";

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