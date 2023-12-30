<?php 

$ropLadders = [21, 22, 23, 24, 25, 26, 27, 243, 239]; //the ids in ork3 of awards that are standardized
$ropTitles = [1,2,3,4,5,6,12,13,14,15,16,17,18,19,20,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,203,240,241,242,244,245]; //the ids in the ork3 of titles that are standardized
$knownCollectiveGDs = [16, 21, 17, 10];//the ids in ork3 of kingdoms with Grand Duchies that are collective (realms).
//$knownAwards[AwardName][KingdomID][] as per the name and kingdomID in ork3
$knownAwards = [
		'Order of the Flame' => [
				1 => [
						'name' => 'The Flame',
						'is_ladder' => 0
				],
				3 => [
						'name' => 'Flame',
						'is_ladder' => 0
				],
				4 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				5 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				6 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				7 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				8 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				10 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				11 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				12 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				14 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				16 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				17 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				18 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				19 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				20 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				21 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				22 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				24 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				25 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				27 => [
						'name' => 'Flame',
						'is_ladder' => 0
				],
				31 => [
						'name' => 'Flame',
						'is_ladder' => 0
				],
				36 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				],
				38 => [
						'name' => 'Order of the Flame',
						'is_ladder' => 0
				]
		],
		'Order of the Griffin' => [
				1 => [
						'name' => 'Order of the Griffin',
						'is_ladder' => 1
				],
				3 => [
						'name' => 'Order of the Griffin',
						'is_ladder' => 1
				],
				4 => [
						'name' => 'Order of the Griffin',
						'is_ladder' => 1
				],
				5 => [
						'name' => 'Order of the Griffin',
						'is_ladder' => 1
				],
				6 => [
						'name' => 'Order of the Griffin',
						'is_ladder' => 1
				],
				7 => [
						'name' => 'Order of the Griffon|Order of the Gryphon',
						'is_ladder' => 1
				],
				8 => [
						'name' => 'Order of the Griffon|Order of the Gryphon',
						'is_ladder' => 1
				],
				10 => [
						'name' => 'Order of the Griffin',
						'is_ladder' => 1
				],
				11 => [
						'name' => 'Order of the Gryphon',
						'is_ladder' => 1
				],
				12 => [
						'name' => 'Order of the Griffin',
						'is_ladder' => 1
				],
				14 => [
						'name' => 'Order of the Griffon|Order of the Gryphon',
						'is_ladder' => 1
				],
				16 => [
						'name' => 'Order of the Griffon|Order of the Gryphon',
						'is_ladder' => 1
				],
				17 => [
						'name' => 'Order of the Griffon',
						'is_ladder' => 1
				],
				18 => [
						'name' => 'Order of the Gryphon',
						'is_ladder' => 1
				],
				19 => [
						'name' => 'Order of the Griffon|Order of the Gryphon',
						'is_ladder' => 1
				],
				20 => [
						'name' => 'Order of the Griffin',
						'is_ladder' => 1
				],
				21 => [
						'name' => 'Order of the Griffon',
						'is_ladder' => 1
				],
				22 => [
						'name' => 'Order of the Griffin',
						'is_ladder' => 1
				],
				24 => [
						'name' => 'Order of the Griffon',
						'is_ladder' => 1
				],
				25 => [
						'name' => 'Order of the Griffon|Order of the Gryphon',
						'is_ladder' => 1
				],
				27 => [
						'name' => 'Order of the Griffon|Order of the Gryphon',
						'is_ladder' => 1
				],
				31 => [
						'name' => 'Griffon',
						'is_ladder' => 1
				],
				36 => [
						'name' => 'Order of the Griffon',
						'is_ladder' => 1
				],
				38 => [
						'name' => 'Order of the Griffin',
						'is_ladder' => 1
				]
		],
		'Order of the Hydra' => [
				1 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				3 => [
						'name' => 'Hydra',
						'is_ladder' => 1
				],
				4 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				5 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				6 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				7 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				8 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				10 => null,
				11 => null,
				12 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				14 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				16 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				17 => null,
				18 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				19 => null,
				20 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				21 => null,
				22 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				24 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				25 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				27 => [
						'name' => 'Hydra',
						'is_ladder' => 1
				],
				31 => [
						'name' => 'Hydra',
						'is_ladder' => 1
				],
				36 => [
						'name' => 'Order of the Hydra',
						'is_ladder' => 1
				],
				38 => null
		],
		'Order of the Jovius' => [
				1 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				3 => [
						'name' => 'Jovious',
						'is_ladder' => 1
				],
				4 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				5 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				6 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				7 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				8 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				10 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				11 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				12 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				14 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				16 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				17 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				18 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				19 => [
						'name' => 'Order of the Jovius',
						'is_ladder' => 1
				],
				20 => [
						'name' => 'Order of the Jovius',
						'is_ladder' => 1
				],
				21 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				22 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				24 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				25 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				27 => [
						'name' => 'Jovious',
						'is_ladder' => 1
				],
				31 => [
						'name' => 'Jovious',
						'is_ladder' => 1
				],
				36 => [
						'name' => 'Order of the Jovious',
						'is_ladder' => 1
				],
				38 => [
						'name' => 'Order of the Jovius',
						'is_ladder' => 1
				]
		],
		'Order of the Mask' => [
				1 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				3 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				4 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				5 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				6 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				7 => [
						'name' => 'Order of the Mask|Order of the Masque',
						'is_ladder' => 1
				],
				8 => [
						'name' => 'Order of the Mask|Order of the Masque',
						'is_ladder' => 1
				],
				10 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				11 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				12 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				14 => [
						'name' => 'Order of the Mask|Order of the Masque',
						'is_ladder' => 1
				],
				16 => [
						'name' => 'Order of the Mask|Order of the Masque',
						'is_ladder' => 1
				],
				17 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				18 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				19 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				20 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				21 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				22 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				24 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				25 => [
						'name' => 'Order of the Mask|Order of the Masque',
						'is_ladder' => 1
				],
				27 => [
						'name' => 'Mask',
						'is_ladder' => 1
				],
				31 => [
						'name' => 'Mask',
						'is_ladder' => 1
				],
				36 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				],
				38 => [
						'name' => 'Order of the Mask',
						'is_ladder' => 1
				]
		],
		'Order of the Zodiac' => [
				1 => [
						'name' => 'The Zodiac',
						'is_ladder' => 1
				],
				3 => null,
				4 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				5 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				6 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				7 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				8 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				10 => null,
				11 => null,
				12 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				14 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				16 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				17 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				18 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				19 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				20 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				21 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				22 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				24 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				25 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				27 => [
						'name' => 'Zodiac',
						'is_ladder' => 1
				],
				31 => [
						'name' => 'Zodiac',
						'is_ladder' => 1
				],
				36 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				],
				38 => [
						'name' => 'Order of the Zodiac',
						'is_ladder' => 1
				]
		],
		'Order of the Dreamkeeper' => [
				1 => null,
				3 => null,
				4 => null,
				5 => null,
				6 => [
						'name' => 'Dreamkeeper',
						'is_ladder' => 1
				],
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Order of the Walker in the Middle' => [
				1 => [
						'type' => 'award',
						'name' => 'Walker in the Middle',
						'is_ladder' => 0
				],
				3 => null,
				4 => [
						'type' => 'award',
						'name' => 'Walker of the Middle',
						'is_ladder' => 0
				],
				5 => [
						'type' => 'award',
						'name' => 'Order of the Walker in the Middle',
						'is_ladder' => 0
				],
				6 => [
						'type' => 'award',
						'name' => 'Walker of the Middle',
						'is_ladder' => 0
				],
				7 => [
						'type' => 'award',
						'name' => 'Order of the Walker of the Middle',
						'is_ladder' => 0
				],
				8 => [
						'type' => 'award',
						'name' => 'Order of the Walker of the Middle',
						'is_ladder' => 0
				],
				10 => null,
				11 => null,
				12 => null,
				14 => [
						'type' => 'award',
						'name' => 'Order of the Walker of the Middle',
						'is_ladder' => 0
				],
				16 => [
						'type' => 'award',
						'name' => 'Order of the Walker of the Middle',
						'is_ladder' => 0
				],
				17 => [
						'type' => 'award',
						'name' => 'Order of the Walker of the Middle',
						'is_ladder' => 0
				],
				18 => [
						'type' => 'award',
						'name' => 'Walker in the Middle',
						'is_ladder' => 0
				],
				19 => [
						'type' => 'award',
						'name' => 'Walker of the Middle',
						'is_ladder' => 0
				],
				20 => [
						'type' => 'award',
						'name' => 'Order of the Walker of the Middle',
						'is_ladder' => 0
				],
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
];
//titles as they appear in ork3 with kingdom-specific details, as per my best reading of their corpora.  It's kinda a nightmare.
//$knownTitles[TitleName][KingdomID][] as per the name and kingdomID in ork3
$knownTitles = [
		'Master Jovius' => [
				1 => [
						'name' => 'Master Jovious',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 0,
						'peerage' => 'Master'
				],
				3 => null,
				4 => null,
				5 => [
						'name' => 'Master Thespian',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				6 => [
						'name' => 'Master Jovious',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				7 => null,
				10 => null,
				11 => [
						'name' => 'Master Jovious',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				12 => [
						'name' => 'Master Jovious',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				14 => null,
				16 => null,
				17 => [
						'name' => 'Master Jovious',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => [
						'name' => 'Master Thespian',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				25 => null,
				27 => null,
				31 => null,
				36 => [
						'name' => 'Master Jovious',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				38 => null
		],
		'Master Zodiac' => [
				1 => null,
				3 => null,
				4 => null,
				5 => [
						'name' => 'Master Zodiac',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				6 => [
						'name' => 'Master Zodiac',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				7 => null,
				10 => null,
				11 => null,
				12 => [
						'name' => 'Master Zodiac',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				14 => null,
				16 => null,
				17 => [
						'name' => 'Master Zodiac',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => [
						'name' => 'Master Zodiac',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				25 => [
						'name' => 'Master Zodiac',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Master Mask' => [
				1 => [
						'name' => 'Master Mask|Master Thespian',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 0,
						'peerage' => 'Master'
				],
				3 => [
						'name' => 'Master Mask',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				4 => [
						'name' => 'Master Mask',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				5 => [
						'name' => 'Master Thespian',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				6 => [
						'name' => 'Master Mask',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				7 => null,
				10 => null,
				11 => [
						'name' => 'Master Mask',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				12 => [
						'name' => 'Master Mask',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				14 => null,
				16 => null,
				17 => [
						'name' => 'Master Mask',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => [
						'name' => 'Master Thespian',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				25 => null,
				27 => null,
				31 => null,
				36 => [
						'name' => 'Master Mask',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				38 => null
		],
		'Master Hydra' => [
				1 => [
						'name' => 'Master Hydra',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				3 => null,
				4 => [
						'name' => 'Master Hydra',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				5 => [
						'name' => 'Master Hydra',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				6 => [
						'name' => 'Master Hydra',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				7 => [
						'name' => 'Master Hydra',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				8 => [
						'name' => 'Master Hydra',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				10 => null,
				11 => null,
				12 => [
						'name' => 'Master Hydra',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				14 => null,
				16 => [
						'name' => 'Master Hydra',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => [
						'name' => 'Master Hydra',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				24 => null,
				25 => [
						'name' => 'Master Hydra',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				27 => null,
				31 => null,
				36 => [
						'name' => 'Master Hydra',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				38 => null
		],
		'Master Griffin' => [
				1 => [
						'name' => 'Master Griffin',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				3 => [
						'name' => 'Master Griffin',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				4 => [
						'name' => 'Master Griffin',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				5 => [
						'name' => 'Master Griffin',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				6 => [
						'name' => 'Master Griffin',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				7 => null,
				10 => null,
				11 => [
						'name' => 'Master Gryphon',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				12 => [
						'name' => 'Master Griffon',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				14 => null,
				16 => [
						'name' => 'Master Griffon',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				17 => [
						'name' => 'Master Griffon',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => [
						'name' => 'Master Griffon',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				24 => null,
				25 => [
						'name' => 'Master Griffon|Master Gryphon',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				27 => null,
				31 => null,
				36 => [
						'name' => 'Master Griffon',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				38 => null
		],
		'Order of the Walker in the Middle' => [
				1 => null,
				3 => [
						'name' => 'Walker of the Middle',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'None'
				],
				4 => null,
				5 => null,
				6 => null,
				7 => null,
				10 => [
						'name' => 'Walker of the Middle',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'None'
				],
				11 => [
						'name' => 'Walker of the Middle',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'None'
				],
				12 => [
						'name' => 'Walker of the Middle',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => [
						'name' => 'Walker of the Middle',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'None'
				],
				22 => [
						'name' => 'Walker of the Middle',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				24 => [
						'name' => 'Walker in the Middle',
						'reign_limit' => null,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				25 => null,
				27 => null,
				31 => null,
				36 => [
						'name' => 'Walker of the Middle',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				38 => [
						'name' => 'Walker of the Middle',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'None'
				]
		],
		'Weaponmaster' => [
				1 => [
						'name' => 'Kingdom Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				3 => null,
				4 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				5 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				6 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				7 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				8 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				10 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				11 => null,
				12 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				14 => null,
				16 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				17 => null,
				18 => null,
				19 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				20 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				21 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				22 => null,
				24 => [
						'name' => 'Weaponmaster of Winter\'s Edge',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				25 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				27 => null,
				31 => null,
				36 => [
						'name' => 'Grand Warmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				38 => [
						'name' => 'Weaponmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				]
		],
		'Dragonmaster' => [
				1 => null,
				3 => null,
				4 => [
						'name' => 'Dragonmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				5 => null,
				6 => [
						'name' => 'Dragonmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				7 => [
						'name' => 'Burning Lands Arts and Sciences Champion',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				8 => [
						'name' => 'Burning Lands Arts and Sciences Champion',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				10 => null,
				11 => null,
				12 => [
						'name' => 'Dragonmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				14 => null,
				16 => [
						'name' => 'Arts and Sciences Champion',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				17 => [
						'name' => 'Dragon Master',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				18 => null,
				19 => [
						'name' => 'Dragonmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				20 => [
						'name' => 'Dragonmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				21 => [
						'name' => 'Dragonmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				22 => null,
				24 => [
						'name' => 'Dragonmaster of Winter\'s Edge',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				25 => [
						'name' => 'Dragonmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				27 => null,
				31 => null,
				36 => [
						'name' => 'Cultural Champion',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				38 => [
						'name' => 'Dragonmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				]
		],
		'Ducal Defender' => [
				1 => [
						'name' => 'Ducal Defender',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				3 => null,
				4 => null,
				5 => null,
				6 => null,
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Grand Ducal Defender' => [
				1 => [
						'name' => 'Grand Ducal Defender',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				3 => null,
				4 => null,
				5 => null,
				6 => null,
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Defender' => [
				1 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				3 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'None'
				],
				4 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				6 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				7 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				8 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				10 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'None'
				],
				11 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'None'
				],
				12 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				14 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				16 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				17 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				18 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				19 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				20 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				21 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				22 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				24 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				25 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'None'
				],
				27 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'None'
				],
				31 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				36 => [
						'name' => 'Defender',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				38 => null
		],
		'Steward' => [
				1 => null,
				3 => null,
				4 => null,
				5 => null,
				6 => null,
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => [
						'name' => 'Steward',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Protector' => [
				1 => null,
				3 => null,
				4 => null,
				5 => null,
				6 => [
						'name' => 'Protector',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => [
						'name' => 'Protector',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Dragonrider' => [
				1 => null,
				3 => null,
				4 => null,
				5 => null,
				6 => null,
				7 => null,
				10 => null,
				11 => null,
				12 => [
						'name' => 'Dragonrider',
						'reign_limit' => null,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Esquire' => [
				1 => null,
				3 => null,
				4 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				6 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				7 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				8 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				10 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				11 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				12 => null,
				14 => null,
				16 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				17 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				18 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				19 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				20 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				21 => null,
				22 => null,
				24 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				25 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				27 => null,
				31 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				36 => null,
				38 => [
						'name' => 'Esquire',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Nobility'
				]
		],
		'Master' => [
				1 => null,
				3 => null,
				4 => [
						'name' => 'Master|Mistress',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'Master',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				6 => null,
				7 => [
						'name' => 'Master',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				8 => [
						'name' => 'Master',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				10 => [
						'name' => 'Master',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				11 => null,
				12 => null,
				14 => null,
				16 => [
						'name' => 'Master',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				17 => [
						'name' => 'Master',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				18 => null,
				19 => [
						'name' => 'Master',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				20 => [
						'name' => 'Master',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				21 => null,
				22 => null,
				24 => [
						'name' => 'Master of the Court|Mistress of the Court',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				25 => [
						'name' => 'Master',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				27 => null,
				31 => [
						'name' => 'Master',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				36 => null,
				38 => [
						'name' => 'Master',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'Nobility'
				]
		],
		'Lord' => [
				1 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				3 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				4 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				6 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				7 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				8 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				10 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				11 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				12 => [
						'name' => 'Lady|Lord',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				14 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				16 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				17 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				18 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				19 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				20 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				21 => [
						'name' => 'Lord|Lady|Noble',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				22 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				24 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				25 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				27 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				31 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				36 => [
						'name' => 'Lord|Lady',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				38 => [
						'name' => 'Liege',
						'reign_limit' => null,
						'rank' => 30,
						'is_active' => 1,
						'peerage' => 'Nobility'
				]
		],
		'Baronet' => [
				1 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				3 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				4 => [
						'name' => 'Baronet|Baronetess',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				6 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				7 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				8 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				10 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				11 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				12 => [
						'name' => 'Baronetess|Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				14 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				16 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				17 => [
						'name' => 'Baronet|Baronetess',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				18 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				19 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				20 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				21 => [
						'name' => 'Baronet|Baronetess|Constable',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				22 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				24 => [
						'name' => 'Baronet|Baronetess',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				25 => [
						'name' => 'Baronet|Baronetess',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				27 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				31 => [
						'name' => 'Baronet',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				36 => [
						'name' => 'Baronet|Baronetess',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				38 => [
						'name' => 'Baronetex',
						'reign_limit' => null,
						'rank' => 40,
						'is_active' => 1,
						'peerage' => 'Nobility'
				]
		],
		'Baron' => [
				1 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				3 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				4 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'Baron',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				6 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				7 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				8 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				10 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				11 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				12 => [
						'name' => 'Baroness|Baron',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				14 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				16 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				17 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				18 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				19 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				20 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				21 => [
						'name' => 'Baron|Baroness|Viceroy',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				22 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				24 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				25 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				27 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				31 => [
						'name' => 'Baron',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				36 => [
						'name' => 'Baron|Baroness',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				38 => [
						'name' => 'Baronex',
						'reign_limit' => null,
						'rank' => 50,
						'is_active' => 1,
						'peerage' => 'Nobility'
				]
		],
		'Viscount' => [
				1 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				3 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				4 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'Viscount',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Gentry'
				],
				6 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				7 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				8 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				10 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				11 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				12 => [
						'name' => 'Viscountess|Viscount',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				14 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				16 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				17 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				18 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				19 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				20 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				21 => [
						'name' => 'Viscount|Viscountess|Vicarius',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				22 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				24 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				25 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				27 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				31 => [
						'name' => 'Viscount',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				36 => [
						'name' => 'Viscount|Viscountess',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				38 => [
						'name' => 'Viscountex',
						'reign_limit' => null,
						'rank' => 60,
						'is_active' => 1,
						'peerage' => 'Nobility'
				]
		],
		'Marquis' => [
				1 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				3 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				4 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'Marquis',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				6 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				7 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				8 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				10 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				11 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				12 => [
						'name' => 'Marquise|Marquis',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				14 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				16 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				17 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				18 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				19 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				20 => [
						'name' => 'Marquis',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				21 => [
						'name' => 'Marquess|Marchioness|Warden',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				22 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				24 => [
						'name' => 'Marquis|Marchioness',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				25 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				27 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				31 => [
						'name' => 'Marquis',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				36 => [
						'name' => 'Marquis|Marquise',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				38 => [
						'name' => 'Marquex',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				]
		],
		'Count' => [
				1 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				3 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				4 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'Count',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				6 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				7 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				8 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				10 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				11 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				12 => [
						'name' => 'Countess|Count',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				14 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				16 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				17 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				18 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				19 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				20 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				21 => [
						'name' => 'Count|Countess|Castellan',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				22 => [
						'name' => 'Count|Countess|Jarl',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				24 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				25 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				27 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				31 => [
						'name' => 'Count',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				36 => [
						'name' => 'Count|Countess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				38 => [
						'name' => 'Countex',
						'reign_limit' => null,
						'rank' => 70,
						'is_active' => 1,
						'peerage' => 'Nobility'
				]
		],
		'Duke' => [
				1 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				3 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				4 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'Duke',
						'reign_limit' => null,
						'rank' => 80,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				6 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				7 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				8 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				10 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				11 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				12 => [
						'name' => 'Duchess|Duke',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				14 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				16 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				17 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				18 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				19 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				20 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				21 => [
						'name' => 'Duke|Duchess|Dux',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				22 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				24 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				25 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				27 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				31 => [
						'name' => 'Duke',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				36 => [
						'name' => 'Duke|Duchess',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				38 => [
						'name' => 'Dux',
						'reign_limit' => null,
						'rank' => 90,
						'is_active' => 1,
						'peerage' => 'Nobility'
				]
		],
		'Archduke' => [
				1 => [
						'name' => 'Arch-Duke',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				3 => [
						'name' => 'Arch Duke|Arch Duchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				4 => [
						'name' => 'Arch Duke|Arch Duchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'ArchDuke',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				6 => [
						'name' => 'Arch-Duke|Arch-Duchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				7 => [
						'name' => 'Arch Duke',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				8 => [
						'name' => 'Arch Duke',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				10 => [
						'name' => 'Archduke|Archduchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				11 => [
						'name' => 'Archduke|Archduchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				12 => [
						'name' => 'Archduchess|Archduke',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				14 => [
						'name' => 'Arch Duke|Arch Duchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				16 => [
						'name' => 'Arch Duke',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				17 => [
						'name' => 'Archduke|Archduchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				18 => [
						'name' => 'Arch Duke|Arch Duchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				19 => [
						'name' => 'Arch Duke|Arch Duchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				20 => [
						'name' => 'Arch Duke',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				21 => [
						'name' => 'Arch Duke|Arch Duchess|Arci Dux',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				22 => [
						'name' => 'Arch Duke|Arch Duchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				24 => [
						'name' => 'Archduke|Archduchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				25 => [
						'name' => 'Archduke|Archduchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				27 => [
						'name' => 'Arch Duke|Arch Duchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				31 => [
						'name' => 'Archduke',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				36 => [
						'name' => 'Arch Duke|Arch Duchess',
						'reign_limit' => null,
						'rank' => 100,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				38 => null
		],
		'Grand Duke' => [
				1 => [
						'name' => 'Grand Duke',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				3 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				4 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'Grand Duke',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				6 => [
						'name' => 'Grand-Duke|Grand-Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				7 => [
						'name' => 'Grand Duke',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				8 => [
						'name' => 'Grand Duke',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				10 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				11 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				12 => [
						'name' => 'Grand Duchess|Grand Duke',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				14 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				16 => [
						'name' => 'Grand Duke',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				17 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				18 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				19 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				20 => [
						'name' => 'Grand Duke',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				21 => [
						'name' => 'Grand Duke|Grand Duchess|Magnus Dux',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				22 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				24 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				25 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				27 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				31 => [
						'name' => 'Grand Duke',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				36 => [
						'name' => 'Grand Duke|Grand Duchess',
						'reign_limit' => null,
						'rank' => 110,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				38 => null
		],
		'Grand Marquis' => [
				1 => null,
				3 => null,
				4 => [
						'name' => 'Grand Marquis|Grand Marquise',
						'reign_limit' => null,
						'rank' => 120,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				5 => [
						'name' => 'Grand Marquis',
						'reign_limit' => null,
						'rank' => 120,
						'is_active' => 1,
						'peerage' => 'Nobility'
				],
				6 => null,
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Warmaster' => [
				1 => null,
				3 => null,
				4 => [
						'name' => 'Warmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				5 => null,
				6 => [
						'name' => 'Warmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				7 => null,
				10 => null,
				11 => null,
				12 => [
						'name' => 'Warmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				14 => null,
				16 => [
						'name' => 'Warmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				17 => null,
				18 => null,
				19 => [
						'name' => 'Warmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				20 => null,
				21 => [
						'name' => 'Warmaster',
						'reign_limit' => 1,
						'rank' => 0,
						'is_active' => 1,
						'peerage' => 'None'
				],
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Weigher of the Scales' => [
				1 => null,
				3 => [
						'name' => 'Weigher of the Scales',
						'reign_limit' => null,
						'rank' => 5,
						'is_active' => 1,
						'peerage' => 'None'
				],
				4 => null,
				5 => null,
				6 => null,
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Dreamkeeper' => [
				1 => null,
				3 => null,
				4 => [
						'name' => 'Dreamkeeper',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'None'
				],
				5 => null,
				6 => [
						'name' => 'Master Dreamkeeper',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				7 => null,
				10 => [
						'name' => 'Dreamkeeper',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'None'
				],
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => [
						'name' => 'Dreamkeeper',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'None'
				],
				31 => [
						'name' => 'Dreamkeeper',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'None'
				],
				36 => null,
				38 => null
		],
		'Master Roach' => [
				1 => null,
				3 => null,
				4 => null,
				5 => null,
				6 => null,
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => [
						'name' => 'Master Roach',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Master Mantis' => [
				1 => null,
				3 => null,
				4 => null,
				5 => null,
				6 => null,
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => [
						'name' => 'Master Mantis',
						'reign_limit' => null,
						'rank' => 10,
						'is_active' => 1,
						'peerage' => 'Master'
				],
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Cultural Olympian' => [
				1 => null,
				3 => null,
				4 => null,
				5 => null,
				6 => null,
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'Grand Olympian' => [
				1 => null,
				3 => null,
				4 => null,
				5 => null,
				6 => null,
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'War Event Winner' => [
				1 => null,
				3 => null,
				4 => null,
				5 => null,
				6 => null,
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		],
		'War Olympian' => [
				1 => null,
				3 => null,
				4 => null,
				5 => null,
				6 => null,
				7 => null,
				10 => null,
				11 => null,
				12 => null,
				14 => null,
				16 => null,
				17 => null,
				18 => null,
				19 => null,
				20 => null,
				21 => null,
				22 => null,
				24 => null,
				25 => null,
				27 => null,
				31 => null,
				36 => null,
				38 => null
		]
];
//$knownRealmChapterrypeOffices[kingdomID][ChaptertypeName][OfficeName][]
$knownRealmChaptertypesOffices = [
		1 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baron|Baroness'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Board of Directors Chief Executive Officer' => [
								'duration' => 6
						],
						'Board of Directors Chief Financial Officer' => [
								'duration' => 6
						],
						'Board of Directors Secretary' => [
								'duration' => 6
						],
						'Board of Directors Kingdom Quartermaster' => [
								'duration' => 6
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Royal Guard' => [
								'duration' => 6
						],
						'Captain of the Guard' => [
								'duration' => 6
						],
						'Regent\'s Defender' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						]
				],
				'Outpost' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1
						],
						'Clerk' => [
								'duration' => 6,
								'order' => 2
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1
						],
						'Shire Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Clerk' => [
								'duration' => 6,
								'order' => 2
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Baronial Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Seneschal' => [
								'duration' => 6,
								'order' => 2
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Ducal Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						],
						'Ducal Defender' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Grand Duchy' => [
						'Grand Duke|Grand Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Count|Countess'
						],
						'Grand Ducal Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baron|Baroness'
						],
						'General Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet'
						],
						'Grand Ducal Defender' => [
								'duration' => 6,
								'order' => 3
						]
				]
		],
		3 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Count|Countess'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Scribe' => [
								'duration' => 6
						],
						'Herald' => [
								'duration' => 6
						],
						'Rules Representative' => [
								'duration' => 6
						],
						'Historian' => [
								'duration' => 6
						],
						'Senator' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'Board of Directors Elected Director' => [
								'duration' => 24
						],
						'Board of Directors Ex Officio Director' => [
								'duration' => 6
						]
				],
				'Shire' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Herald' => [
								'duration' => 6
						]
				],
				'Barony' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Herald' => [
								'duration' => 6
						]
				],
				'Duchy' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Herald' => [
								'duration' => 6
						]
				],
				'Principality' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Herald' => [
								'duration' => 6
						],
						'Board of Directors Member' => [
								'duration' => 6
						]
				]
		],
		4 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Royal Consort' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baron|Baroness'
						],
						'Champion of the Realm' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Scribe' => [
								'duration' => 6
						],
						'Captain of the Monarch\'s Guard' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Monarch\'s Guard' => [
								'duration' => 6
						],
						'Consort\'s Defender' => [
								'duration' => 6
						],
						'Court Bard' => [
								'duration' => 6
						],
						'Court Jester' => [
								'duration' => 6
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Shire Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1
						],
						'Baronial Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Baronial Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1
						],
						'Ducal Consort' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Ducal Champion' => [
								'duration' => 6,
								'order' => 3
						]
				]
		],
		5 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baron|Baroness'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Count|Countess'
						],
						'Champion of the Realm' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Kingdom Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Captain of the King\'s Guard' => [
								'duration' => 6
						],
						'King\'s Guard' => [
								'duration' => 6
						],
						'Regent\'s Protector' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Principal Herald' => [
								'duration' => 6
						],
						'Royal Historian' => [
								'duration' => 6
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						],
						'Board of Directors Vice President' => [
								'duration' => 12
						],
						'Board of Directors President' => [
								'duration' => 12
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Lord|Lady'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Esquire'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Master|Mistress'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Master|Mistress'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord|Lady'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Master|Mistress'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Grand Duchy' => [
						'Grand Duke|Grand Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Count|Countess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baron|Baroness'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Lord|Lady'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Principality' => [
						'Prince|Princess' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				]
		],
		6 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baron|Baroness'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors President' => [
								'duration' => null
						],
						'Board of Directors Vice President' => [
								'duration' => null
						],
						'Board of Directors Secretary' => [
								'duration' => null
						],
						'Board of Directors Treasurer' => [
								'duration' => null
						],
						'Interkingdom Rules Representative' => [
								'duration' => null
						],
						'Guildmaster of [A&S]' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'Circle of Monarchs Representative' => [
								'duration' => 6
						],
						'Head of Security' => [
								'duration' => 6
						],
						'Security' => [
								'duration' => 6
						],
						'Captain of the Guard' => [
								'duration' => 6
						],
						'Crown\'s Guard' => [
								'duration' => 6
						],
						'Regent\'s Defender' => [
								'duration' => 6
						],
						'Scribe' => [
								'duration' => 6
						],
						'Court Bard' => [
								'duration' => 6
						],
						'Court Jester' => [
								'duration' => 6
						],
						'Heir Apparent' => [
								'duration' => 6
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Lord|Lady'
						],
						'Shire Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Esquire'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Esquire'
						],
						'Shire Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Protector'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Baronial Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord|Lady'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Esquire'
						],
						'Baronial Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Protector'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Duchy Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						],
						'Duchy Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Protector'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				]
		],
		7 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent|Consort|Prince|Princess' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baron|Baroness'
						],
						'Champion of the Realm' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Scribe' => [
								'duration' => 6
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Captain of the Monarch\'s Guard' => [
								'duration' => 6
						],
						'Glass Guildmaster' => [
								'duration' => 6
						],
						'Guildmaster of [A&S]' => [
								'duration' => 6
						],
						'Monarch\'s & Consort\'s Guard' => [
								'duration' => 6
						],
						'Circle of Steel Member' => [
								'duration' => 6
						],
						'Consort/Regent\'s Defender' => [
								'duration' => 6
						],
						'Court Bard' => [
								'duration' => 6
						],
						'Court Jester' => [
								'duration' => 6
						],
						'Rules Representative' => [
								'duration' => 6
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Shire Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1
						],
						'Baronial Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Baronial Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1
						],
						'Ducal Consort' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Ducal Champion' => [
								'duration' => 6,
								'order' => 3
						]
				]
		],
		8 => [
				'Freehold' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Shire Champion' => [
								'duration' => 6,
								'order' => 3
						]
				]
		],
		10 => [
				'Kingdom' => [
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Kingdom Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Kingdom Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Kingdom Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Kingdom Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Kingdom Quartermaster' => [
								'duration' => 12
						],
						'Kingdom Storyteller' => [
								'duration' => 6
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Board of Directors Quartermaster' => [
								'duration' => 12
						],
						'Board of Directors Chairperson' => [
								'duration' => 12
						],
						'Board of Directors Vice Chairperson' => [
								'duration' => 12
						],
						'Board of Directors Case Analyst' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Lord|Lady'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Master'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Esquire'
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord|Lady'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Master'
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Master'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						]
				],
				'Grand Duchy' => [
						'Grand Duke|Grand Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Marquis|Marquess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baron|Baroness'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Master'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet'
						]
				],
				'Principality' => [
						'Prince|Princess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Count|Countess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Marquis|Marquess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Master'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet'
						]
				]
		],
		11 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Marquis|Marquess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Circle of Monarchs Secretary' => [
								'duration' => 6
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Board of Directors Member' => [
								'duration' => 6
						],
						'Board of Directors Treasurer' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Crown Guard' => [
								'duration' => 6
						],
						'Court Bard' => [
								'duration' => 6
						],
						'Court Jester' => [
								'duration' => 6
						],
						'Court Herald' => [
								'duration' => 6
						],
						'Prime Minister\'s Scribe' => [
								'duration' => 6
						],
						'Regent\'s Defender' => [
								'duration' => 6
						]
				],
				'Shire' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Lord|Lady'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Esquire'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Esquire'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						]
				],
				'Barony' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord|Lady'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Lord|Lady'
						]
				],
				'County' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Baronet'
						]
				],
				'Duchy' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Viscount|Viscountess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baron|Baroness'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baron|Baroness'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Baron|Baroness'
						]
				],
				'Grand Duchy' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Marquis|Marquess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Viscount|Viscountess'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Viscount|Viscountess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Viscount|Viscountess'
						]
				]
		],
		12 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baron|Baroness'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Heir Apparent' => [
								'duration' => 6
						],
						'Captain of the Royal Guard' => [
								'duration' => 6
						],
						'Royal Guard' => [
								'duration' => 6
						],
						'Regent\'s Defender' => [
								'duration' => 6
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'Guildmaster of Smiths' => [
								'duration' => 6
						],
						'Guildmaster of Garbers' => [
								'duration' => 6
						],
						'Guildmaster of Engineers' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Scribe' => [
								'duration' => 6
						],
						'Circle of Steel Representative' => [
								'duration' => 6
						],
						'Court Herald' => [
								'duration' => 6
						],
						'Guildmaster of [A&S]' => [
								'duration' => 6
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors President' => [
								'duration' => 12
						],
						'Board of Directors Vice President' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Board of Directors Liaison Officer' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Lord/Lady'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord/Lady'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Principality' => [
						'Prince|Princess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Count|Countess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baron|Baroness'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						]
				]
		],
		14 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Marquis|Marquess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Senator' => [
								'duration' => 12
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'Rules Representative' => [
								'duration' => 12
						],
						'Captain of the Guard' => [
								'duration' => 6
						],
						'Regent\'s Defender' => [
								'duration' => 6
						],
						'Crown Guard' => [
								'duration' => 6
						],
						'Scribe' => [
								'duration' => 6
						],
						'Crown Bard' => [
								'duration' => 6
						],
						'Crown Herald' => [
								'duration' => 6
						],
						'Crown Jester' => [
								'duration' => 6
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors President' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Board of Directors Membership Officer' => [
								'duration' => 12
						],
						'Board of Directors Monarch Alternate' => [
								'duration' => 12
						],
						'Board of Directors Prime Minister Alternate' => [
								'duration' => 12
						]
				],
				'Shire' => [
						'Sheriff|Mayor' => [
								'duration' => 6,
								'order' => 1
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Baronial Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Baronial Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Baronial Seneschal' => [
								'duration' => 6,
								'order' => 2
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Ducal Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Ducal Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Ducal Seneschal' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						]
				],
				'Grand Duchy' => [
						'Grand Duke|Grand Duchess' => [
								'duration' => 6,
								'order' => 1
						],
						'Grand Ducal Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Grand Ducal Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Grand Ducal Seneschal' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet'
						]
				],
				'Principality' => [
						'Crown Prince|Crown Princess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Count|Countess'
						],
						'Crown Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baron|Baroness'
						],
						'Crown Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Crown Seneschal' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet'
						]
				]
		],
		16 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent|Consort' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baron|Baroness'
						],
						'Champion of the Realm' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Scribe' => [
								'duration' => 6
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Captain of the Monarch\'s Guard' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Guildmaster of [A&S]' => [
								'duration' => 6
						],
						'Monarch\'s/Consort\'s Guard' => [
								'duration' => 6
						],
						'Circle of Steel Member' => [
								'duration' => 6
						],
						'Regent/Consort\'s Defender' => [
								'duration' => 6
						],
						'Court Bard' => [
								'duration' => 6
						],
						'Court Jester' => [
								'duration' => 6
						],
						'Rules Representative' => [
								'duration' => null
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1
						],
						'Baronial Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1
						],
						'Ducal Consort' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Ducal Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Principality' => [
						'Prince|Princess' => [
								'duration' => 6,
								'order' => 1
						],
						'Prince Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2
						],
						'Prince Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Grand Duchy' => [
						'Grand Duke|Grand Duchess' => [
								'duration' => 6,
								'order' => 1
						],
						'Grand Ducal Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2
						],
						'Grand Ducal Champion' => [
								'duration' => 6,
								'order' => 3
						]
				]
		],
		17 => [
				'Kingdom' => [
						'Board of Directors Member' => [
								'duration' => 36
						],
						'Board of Directors Trustee' => [
								'duration' => null
						],
						'Board of Directors Trustee Program Liason' => [
								'duration' => 12
						],
						'Board of Directors President' => [
								'duration' => 24
						],
						'Board of Directors Vice-President' => [
								'duration' => 24
						],
						'Board of Directors Secretary' => [
								'duration' => 24
						],
						'Board of Directors Treasurer' => [
								'duration' => 24
						],
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Count|Countess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Senator' => [
								'duration' => 12,
								'title' => 'Count|Countess'
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'Rules Representative' => [
								'duration' => null
						],
						'Corpora Comittee Chair' => [
								'duration' => 6
						],
						'Corpora Comittee Member' => [
								'duration' => 6
						],
						'Guildmaster of Masks' => [
								'duration' => 6
						],
						'Court Herald' => [
								'duration' => 6
						],
						'Guard' => [
								'duration' => 6
						],
						'Court Chronicler' => [
								'duration' => 6
						],
						'Royal Commissioner (Recruiting/Retention)' => [
								'duration' => 6
						],
						'Royal Commissioner (Diversity/Inclusion)' => [
								'duration' => 6
						],
						'Guildmaster of Novices' => [
								'duration' => 6
						],
						'Kingdom Spotlight' => [
								'duration' => 6
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Master|Mistress'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Esquire'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet|Baronetess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Master|Mistress'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet|Baronetess'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet|Baronetess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Master|Mistress'
						]
				],
				'Grand Duchy' => [
						'Grand Duke|Grand Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet|Baronetess'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet|Baronetess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Master|Mistress'
						]
				],
				'Principality' => [
						'Prince|Princess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet|Baronetess'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet|Baronetess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Master|Mistress'
						]
				]
		],
		18 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Viscount|Viscountess'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Captain of the Guard' => [
								'duration' => 6
						],
						'Guard Member' => [
								'duration' => 6
						],
						'Regent Defender' => [
								'duration' => 6
						],
						'Court Herald' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Guildmaster of [A&S]' => [
								'duration' => 6
						],
						'Heir Apparent' => [
								'duration' => 6
						],
						'Marshall' => [
								'duration' => 6
						],
						'Quartermaster' => [
								'duration' => 6
						],
						'Representative to AI' => [
								'duration' => 6
						],
						'Rules Representative to AI' => [
								'duration' => 6
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'Circle of Steel Representative' => [
								'duration' => 6
						],
						'Event Committee Member' => [
								'duration' => 12
						],
						'Event Committee Head' => [
								'duration' => 12
						],
						'Event Committee Treasurer' => [
								'duration' => 12
						],
						'Fundraiser Committee Member' => [
								'duration' => 12
						],
						'Board of Directors Member' => [
								'duration' => 24
						],
						'Board of Directors Chairman of the Board' => [
								'duration' => 12
						],
						'Board of Directors Vice-Chairman of the Board' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Board of Directors Liason Officer' => [
								'duration' => 12
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Esquire'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Protector'
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord|Lady'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Protector'
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Protector'
						]
				],
				'Principality' => [
						'Prince|Princess' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Protector'
						]
				]
		],
		19 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Marquis|Marquess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Ambassador of Tal Dagore' => [
								'duration' => 12
						],
						'Rules Representative of Tal Dagore' => [
								'duration' => 12
						],
						'V9 Representative of Tal Dagore' => [
								'duration' => 12
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors Board President' => [
								'duration' => 12
						],
						'Board of Directors Vice President' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Lord|Lady'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord|Lady'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet'
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Principality' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minster' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Board of Directors Member' => [
								'duration' => 6
						]
				]
		],
		20 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baron|Baroness'
						],
						'Champion of the Realm' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors President' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Rules Representative' => [
								'duration' => 12
						],
						'Chief Herald of the College of Arms' => [
								'duration' => 6
						],
						'Speaker of Knights' => [
								'duration' => 6
						],
						'Food Fight Representative' => [
								'duration' => 12
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Lord|Lady'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Master|Mistress'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Esquire'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord|Lady'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Master|Mistress'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Master|Mistress'
						]
				],
				'Principality' => [
						'Prince|Princess' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				]
		],
		21 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Steward'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Steward'
						],
						'Heir Apparent' => [
								'duration' => 6
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'Captain of the Royal Guard' => [
								'duration' => 6
						],
						'Royal Guard' => [
								'duration' => 6
						],
						'Regent\'s Defender' => [
								'duration' => 6
						],
						'Scribe' => [
								'duration' => 6
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors President' => [
								'duration' => 12
						],
						'Board of Directors Vice President' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Board of Directors Liason Officer' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Lord|Lady'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord|Lady'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Grand Duchy' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Principality' => [
						'Prince|Princess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Marquis|Marquess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baron|Baroness'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Steward'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors President' => [
								'duration' => 12
						],
						'Board of Directors Vice President' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Board of Directors Liason Officer' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						]
				]
		],
		22 => [
				'Kingdom' => [
						'Emperor|Empress' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Imperial Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Imperial Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Count|Countess'
						],
						'Imperial Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'InterKingdom Rules Committee Representative' => [
								'duration' => 6
						],
						'Captain of the Guard' => [
								'duration' => 6
						],
						'Guard Member' => [
								'duration' => 6
						],
						'Regent Defender' => [
								'duration' => 6
						],
						'Court Scribe' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Guildmaster of [A&S]' => [
								'duration' => 6
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors President' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1
						],
						'Provincial Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Provincial Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Provincial Treasurer' => [
								'duration' => 6
						],
						'Provincial Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Provincial Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Provincial Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Provincial Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Provincial Treasurer' => [
								'duration' => 6
						],
						'Provincial Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Provincial Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Provincial Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet'
						],
						'Provincial Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet'
						],
						'Provincial Treasurer' => [
								'duration' => 6
						],
						'Provincial Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Provincial Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Principality' => [
						'Prince|Princess' => [
								'duration' => 6,
								'order' => 1
						],
						'Principality Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Principality Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Principality Treasurer' => [
								'duration' => 6
						],
						'Principality Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Principality Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				]
		],
		24 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baron|Baroness'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Count|Countess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Baronet|Baronetess'
						],
						'Captain of the Guard' => [
								'duration' => 6
						],
						'Regent\'s Apprentice' => [
								'duration' => 6
						],
						'Crown Guard Member' => [
								'duration' => 6
						],
						'Principal Herald' => [
								'duration' => 6
						],
						'Court Herald' => [
								'duration' => 6
						],
						'Scribe' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Senator' => [
								'duration' => 6
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors President' => [
								'duration' => 12
						],
						'Board of Directors Vice President' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Board of Directors Surrogate' => [
								'duration' => 12
						],
						'Board of Directors Alternate' => [
								'duration' => 12
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Lord|Lady'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Esquire'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Master|Mistress'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Esquire'
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet|Baronetess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Master|Mistress'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Esquire'
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord|Lady'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet|Baronetess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Master|Mistress'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Master|Mistress'
						]
				],
				'Grand Duchy' => [
						'Grand Duke|Grand Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Count|Countess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet|Baronetess'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baron|Baroness'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Lord|Lady'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Lord|Lady'
						]
				],
				'Principality' => [
						'Prince|Princess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Count|Countess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet|Baronetess'
						],
						'Supreme Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baron|Baroness'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Lord|Lady'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Lord|Lady'
						]
				]
		],
		25 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Viscount|Viscountess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Viscount|Viscountess'
						],
						'Champion of the Realm' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Viscount|Viscountess'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Board of Directors Operations Officer' => [
								'duration' => 6
						],
						'Board of Directors Financial Officer' => [
								'duration' => 6
						],
						'Board of Directors Member' => [
								'duration' => 12
						],
						'Board of Directors President' => [
								'duration' => 6
						],
						'Board of Directors Secretary' => [
								'duration' => 6
						],
						'Board of Directors Treasurer' => [
								'duration' => 6
						],
						'Operations Officer' => [
								'duration' => 6
						],
						'Assistant Operations Officer' => [
								'duration' => 6
						],
						'Adjudication Chief' => [
								'duration' => 6
						],
						'Quartermaster' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Kingdom Rules Representative' => [
								'duration' => 6
						],
						'Viridian Outlands Corpora Clarification Committee Member' => [
								'duration' => 6
						],
						'Viridian Outlands Corpora Clarification Committee Board Member' => [
								'duration' => null
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Lord|Lady'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Master'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Esquire'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet|Baronetess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord|Lady'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Master'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Master'
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet|Baronetess'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Lord|Lady'
						]
				],
				'Principality' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Count|Countess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Marquis|Marquess'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baron|Baroness'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Baron|Baroness'
						]
				]
		],
		27 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Count|Countess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Board of Directors Member' => [
								'duration' => 24
						],
						'Board of Directors Ex Officio' => [
								'duration' => 24
						],
						'Board of Directors President' => [
								'duration' => 12
						],
						'Board of Directors Treasurer' => [
								'duration' => 12
						],
						'Board of Directors Secretary' => [
								'duration' => 12
						],
						'The Rules Representative' => [
								'duration' => 12
						],
						'The Kingdom Senator' => [
								'duration' => 12
						]
				],
				'Outpost' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Shire' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Barony' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Duchy' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Grand Duchy' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				]
		],
		31 => [
				'Kingdom' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Count|Countess'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Board of Directors Member' => [
								'duration' => 24
						],
						'Board of Directors CEO' => [
								'duration' => 24
						],
						'Board of Directors CFO' => [
								'duration' => 24
						],
						'Board of Directors Secretary' => [
								'duration' => 24
						],
						'The Rules Representative' => [
								'duration' => 6
						]
				],
				'Shire' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Lord|Lady'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Master|Mistress'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Esquire'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Esquire'
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						]
				],
				'Barony' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord|Lady'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Master|Mistress'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Esquire'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Esquire'
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						]
				],
				'Duchy' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet'
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Master|Mistress'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Master|Mistress'
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						]
				]
		],
		34 => [
				'Kingdom' => [
						'Champion of Hats' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Champion of Art' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Champion of Wacks' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Champion of Records' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion of Rules' => [
								'duration' => 6,
								'order' => 5
						],
						'Champion of Knights' => [
								'duration' => 6
						]
				],
				'Burg' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Shire' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Barony' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Duchy' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				],
				'Grand Duchy' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						]
				]
		],
		36 => [
				'Kingdom' => [
						'Kingdom Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Kingdom Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet|Barnetess'
						],
						'Kingdom Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Count|Countess'
						],
						'Kingdom Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Defender'
						],
						'Kingdom Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Baronet|Barnetess'
						],
						'Heir Apparent' => [
								'duration' => 6
						],
						'Captain of the Guard' => [
								'duration' => 6
						],
						'Members of the Guard' => [
								'duration' => 6
						],
						'Regent\'s Defender' => [
								'duration' => 6
						],
						'Guildmaster of [A&S]' => [
								'duration' => 6
						],
						'Guildmaster of [Class]' => [
								'duration' => 6
						],
						'Scribe' => [
								'duration' => 6
						],
						'Court Herald' => [
								'duration' => 6
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'Circle of Steel Representative' => [
								'duration' => 6
						],
						'Ambassador' => [
								'duration' => 6
						],
						'Grand Librarian' => [
								'duration' => 6
						],
						'Chief Executive Officer' => [
								'duration' => 24
						],
						'Regional Executive Officer' => [
								'duration' => 6
						],
						'Administrative Officer' => [
								'duration' => 24
						],
						'Board of Directors President' => [
								'duration' => 24
						],
						'Board of Directors Secretary-Treasurer' => [
								'duration' => 24
						],
						'Board of Directors Vice President' => [
								'duration' => 6
						],
						'Board of Directors Board Liaison' => [
								'duration' => 6
						]
				],
				'Shire' => [
						'Sheriff' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Barony' => [
						'Baron|Baroness' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Duchy' => [
						'Duke|Duchess' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				],
				'Grand Duchy' => [
						'Grand Duke|Grand Duchess' => [
								'duration' => 6,
								'order' => 1
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4
						],
						'Chancellor' => [
								'duration' => 6,
								'order' => 2
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5
						]
				]
		],
		38 => [
				'Kingdom' => [
						'Kingdom Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Duke|Duchess'
						],
						'Kingdom Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Marquis|Marquess'
						],
						'Kingdom Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Count|Countess'
						],
						'Kingdom Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Viscount|Viscountess'
						],
						'Kingdom Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Viscount|Viscountess'
						],
						'Kingdom Ambassador' => [
								'duration' => 6
						],
						'Guildmaster of Knights' => [
								'duration' => 6
						],
						'Board of Directors Member' => [
								'duration' => 48
						]
				],
				'Shire' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Lord|Lady'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Master|Mistress'
						]
				],
				'Barony' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baronet'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Lord|Lady'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Lord|Lady'
						]
				],
				'Duchy' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Baron|Baroness'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Baronet'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Lord|Lady'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Lord|Lady'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Lord|Lady'
						]
				],
				'Principality' => [
						'Monarch' => [
								'duration' => 6,
								'order' => 1,
								'title' => 'Marquis|Marquess'
						],
						'Prime Minister' => [
								'duration' => 6,
								'order' => 2,
								'title' => 'Count|Countess'
						],
						'Guildmaster of Reeves' => [
								'duration' => 6,
								'order' => 5,
								'title' => 'Viscount|Viscountess'
						],
						'Regent' => [
								'duration' => 6,
								'order' => 4,
								'title' => 'Baronet'
						],
						'Champion' => [
								'duration' => 6,
								'order' => 3,
								'title' => 'Baronet'
						]
				]
		]
];
//$knownCurrentReigns[kingdomID][]
$knownCurrentReigns = [
		1 => [
				'label' => 'Reign LV',
				'begins' => '2023-06-02',
				'midreign' => '2023-08-25',
				'ends' => '2023-12-10'
		],
		3 => [
				'label' => '64th Reign',
				'begins' => '2023-06-01',
				'midreign' => '2023-09-01',
				'ends' => '2023-12-01'
		],
		4 => [
				'label' => 'Reign 57',
				'begins' => '2023-09-01',
				'midreign' => '2023-12-01',
				'ends' => '2024-03-01'
		],
		5 => [
				'label' => null,
				'begins' => '2023-08-25',
				'midreign' => '2023-11-11',
				'ends' => '2024-01-27'
		],
		6 => [
				'label' => null,
				'begins' => '2023-06-01',
				'midreign' => '2023-09-22',
				'ends' => '2023-12-01'
		],
		7 => [
				'label' => null,
				'begins' => '2023-10-01',
				'midreign' => '2024-01-01',
				'ends' => '2024-04-01'
		],
		8 => [
				'label' => null,
				'begins' => '2023-10-01',
				'midreign' => '2024-01-01',
				'ends' => '2024-04-01'
		],
		10 => [
				'label' => null,
				'begins' => '2023-09-01',
				'midreign' => '2023-12-01',
				'ends' => '2023-03-01'
		],
		11 => [
				'label' => 'Reign #64',
				'begins' => '2023-09-01',
				'midreign' => '2023-12-01',
				'ends' => '2023-03-01'
		],
		12 => [
				'label' => null,
				'begins' => '2023-05-12',
				'midreign' => '2023-09-01',
				'ends' => '2023-12-10'
		],
		14 => [
				'label' => 'Reign 67',
				'begins' => '2023-11-11',
				'midreign' => '2024-02-04',
				'ends' => '2024-05-26'
		],
		16 => [
				'label' => null,
				'begins' => '2023-09-01',
				'midreign' => '2023-12-01',
				'ends' => '2024-03-01'
		],
		17 => [
				'label' => null,
				'begins' => '2023-10-01',
				'midreign' => '2024-01-01',
				'ends' => '2024-04-01'
		],
		18 => [
				'label' => null,
				'begins' => '2023-11-11',
				'midreign' => '2024-02-04',
				'ends' => '2024-05-26'
		],
		19 => [
				'label' => null,
				'begins' => '2023-07-01',
				'midreign' => '2023-10-28',
				'ends' => '2024-01-01'
		],
		20 => [
				'label' => null,
				'begins' => '2023-09-23',
				'midreign' => '2023-12-30',
				'ends' => '2024-03-23'
		],
		21 => [
				'label' => 'Reign XXXIII',
				'begins' => '2023-11-01',
				'midreign' => '2024-02-01',
				'ends' => '2024-05-01'
		],
		22 => [
				'label' => null,
				'begins' => '2023-09-01',
				'midreign' => '2023-12-01',
				'ends' => '2024-03-01'
		],
		24 => [
				'label' => null,
				'begins' => '2023-10-20',
				'midreign' => '2024-02-16',
				'ends' => '2024-04-14'
		],
		25 => [
				'label' => null,
				'begins' => '2023-10-01',
				'midreign' => '2024-02-01',
				'ends' => '2024-04-01'
		],
		27 => [
				'label' => 'Reign # 13',
				'begins' => '2023-08-01',
				'midreign' => '2023-11-01',
				'ends' => '2024-02-01'
		],
		31 => [
				'label' => 'Reign #27',
				'begins' => '2023-08-01',
				'midreign' => '2023-11-01',
				'ends' => '2024-02-01'
		],
		36 => [
				'label' => null,
				'begins' => '2023-08-01',
				'midreign' => '2023-11-01',
				'ends' => '2024-02-01'
		],
		38 => [
				'label' => null,
				'begins' => '2023-10-01',
				'midreign' => '2024-02-01',
				'ends' => '2024-04-01'
		]
];

$countries = [
		'AF' => 'Afghanistan',
		'AX' => 'Aland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua And Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BA' => 'Bosnia And Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, Democratic Republic',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Cote D\'Ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island & Mcdonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran, Islamic Republic Of',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle Of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KR' => 'Korea',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libyan Arab Jamahiriya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia, Federated States Of',
		'MD' => 'Moldova',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'AN' => 'Netherlands Antilles',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory, Occupied',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Reunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthelemy',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts And Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin',
		'PM' => 'Saint Pierre And Miquelon',
		'VC' => 'Saint Vincent And Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome And Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia And Sandwich Isl.',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard And Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad And Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks And Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis And Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
];
?>