<?php

// Defines
// Const
const GHS_GAME_CATS = array(
	0 => 'Action',
	1 => 'Action-Adventure',
	2 => 'Adventure',
	3 => 'Arcade',
	4 => 'Puzzle',
	5 => 'FPS',
	6 => 'Platformer',
	7 => 'RPG',
	8 => 'Simulation',
	9 => 'Strategy',
	10 => 'Sports',
	11 => 'MMO',
	12 => 'Open World',
);

const GHS_ESRB_RATINGS = array(
	0 => [
		'Rating' => 'E',
		'Name' => 'Everyone',
		'Desc' => 'Content is generally suitable for all ages. May contain minimal cartoon, fantasy or mild violence and/or infrequent use of mild language.'
	],
	1 => [
		'Rating' => 'E10+',
		'Name' => 'Everyone 10+',
		'Desc' => 'Content is generally suitable for ages 10 and up. May contain more cartoon, fantasy or mild violence, mild language and/or minimal suggestive themes.'
	],
	2 => [
		'Rating' => 'T',
		'Name' => 'Teen',
		'Desc' => 'Content is generally suitable for ages 13 and up. May contain violence, suggestive themes, crude humor, minimal blood, simulated gambling and/or infrequent use of strong language.'
	],
	3 => [
		'Rating' => 'M',
		'Name' => 'Mature 17+',
		'Desc' => 'Content is generally suitable for ages 17 and up. May contain intense violence, blood and gore, sexual content and/or strong language.'
	],
	4 => [
		'Rating' => 'AO',
		'Name' => 'Adults Only 18+',
		'Desc' => 'Content suitable only for adults ages 18 and up. May include prolonged scenes of intense violence, graphic sexual content and/or gambling with real currency.'
	],
	5 => [
		'Rating' => 'RP',
		'Name' => 'Rating Pending',
		'Desc' => 'Not yet assigned a final ESRB rating. Appears only in advertising, marketing and promotional materials related to a physical (e.g., boxed) video game that is expected to carry an ESRB rating, and should be replaced by a game\'s rating once it has been assigned.'
	],
	6 => [
		'Rating' => 'RP17+',
		'Name' => 'Rating Pending — Likely Mature 17+',
		'Desc' => 'Not yet assigned a final ESRB rating but anticipated to be rated Mature 17+. Appears only in advertising, marketing, and promotional materials related to a physical (e.g., boxed) video game that is expected to carry an ESRB rating, and should be replaced by a game’s rating once it has been assigned.'
	],
);

const GHS_PEGI_RATINGS = array(
	0 => [
		'Rating' => 'PEGI3',
		'Name' => 'PEGI 3',
		'Desc' => 'The majority of games rated PEGI 3 do not contain issues that require a content warning. Games given this rating are considered suitable for all age groups. There may be very mild and unrealistic violence in a child-like setting. There may also be nudity when shown in a completely natural and non-sexual manner, for example during breastfeeding. Games rated at PEGI 3 may also contain in-game purchases. If a game contains such purchases, this will be indicated by an icon on the box, as shown below. Where these purchases are for randomly selected items, you will also see the text \'In-game Purchases (Includes Random Items)\' beneath the PEGI rating and content icons.'
	],
	1 => [
		'Rating' => 'PEGI7',
		'Name' => 'PEGI 7',
		'Desc' => 'Games rated PEGI 7 may contain unrealistic violence, often directed towards fantasy characters. Violence towards human characters will be unrealistic and undetailed, of a minor nature, or only implied. For example, a city being bombed or cars crashing, where the violence to humans is not actually shown. Games may also be rated PEGI 7 because they contain elements, including sounds, that might be scary or frightening to younger children. Games rated at PEGI 7 may also contain in-game purchases. If a game contains such purchases, this will be indicated by an icon on the box, as shown below. Where these purchases are for randomly selected items, you will also see the text \'In-game Purchases (Includes Random Items)\' beneath the PEGI rating and content icons.'
	],
	2 => [
		'Rating' => 'PEGI12',
		'Name' => 'PEGI 12',
		'Desc' => 'Games rated PEGI 12 may contain more detailed and realistic-looking violence towards fantasy characters. However, any violence towards human characters must look unrealistic or be minor in nature. There may be moderate horror sequences, such as characters in danger and jump scares, as well as disturbing images, such as sight of injuries or dead bodies. Milder forms of swearing may be present but not the strongest terms. While sex may not be shown, there may be sexual innuendo and sexual activity can be implied (eg a couple getting into bed). The type of suggestive posing and dancing that\'s familiar from music videos may also be allowed, although there will be no sexual nudity. Games rated at PEGI 12 may also contain in-game purchases. If a game contains such purchases, this will be indicated by an icon on the box, as shown below. Where these purchases are for randomly selected items, you will also see the text \'In-game Purchases (Includes Random Items)\' beneath the PEGI rating and content icons.'
	],
	3 => [
		'Rating' => 'PEGI!',
		'Name' => 'Parental Guidance',
		'Desc' => 'In addition to the numerical PEGI ratings, you will also see the \'Parental Guidance Recommended \' rating for some non-game apps, introduced by PEGI for storefronts that use IARC (https://www.globalratings.com/). This serves as a warning that these apps can offer a broad and unpredictable variety of user-generated or curated content. Typically, this warning applies to products such as Facebook, Twitter or YouTube.'
	],
	4 => [
		'Rating' => 'PEGI16',
		'Name' => 'PEGI 16',
		'Desc' => 'Games rated PEGI 16 may contain more realistic and sustained violence against human characters, including sight of blood. The stronger forms of violence, such as torture and a focus on pain and injury, will not normally be allowed unless they are against fantasy characters. Games at this level will not necessarily show any negative consequences to crime. There may also be intense and sustained horror sequences or strong gory images. Strong language can occur, including the crudest sexual expletives. Sexual activity may be shown provided there is no sight of genitals. Depictions of erotic nudity may feature. There may be depictions of the use of illegal drugs, as well as prominent use of tobacco and alcohol. Games rated at PEGI 16 may also contain in-game purchases. If a game contains such purchases, this will be indicated by an icon on the box, as shown below. Where these purchases are for randomly selected items, you will also see the text \'In-game Purchases (Includes Random Items)\' beneath the PEGI rating and content icons.'
	],
	5 => [
		'Rating' => 'PEGI18',
		'Name' => 'PEGI 18',
		'Desc' => 'Games rated PEGI 18 can contain very strong content and are only suitable for adults. This could include torture and the infliction of severe pain and injury to human characters. It could also include violence towards defenceless or vulnerable human characters, including children. Sexual violence and sexual threats may also occur. Very strong and crude language may feature throughout. There may be strong depictions of sexual activity with sight of genitals*. Games rated PEGI 18 may also feature detailed descriptions of criminal techniques, as well as the teaching and glamorisation of gambling, and the glamorisation and promotion of illegal drug use. Games rated at PEGI 18 may also contain in-game purchases. If a game contains such purchases, this will be indicated by an icon on the box, as shown below. Where these purchases are for randomly selected items, you will also see the text \'In-game Purchases (Includes Random Items)\' beneath the PEGI rating and content icons. '
	],
);

const GHS_CERO_RATINGS = array(
	0 => [
		'Rating' => 'CEROA',
		'Name' => 'CERO A',
		'Desc' => 'Titles rated A have been assessed to be suitable for gamers of all ages.'
	],
	1 => [
		'Rating' => 'CEROB',
		'Name' => 'CERO B',
		'Desc' => 'Titles rated B have been assessed to be suitable for gamers ages 12 and up.'
	],
	2 => [
		'Rating' => 'CEROC',
		'Name' => 'CERO C',
		'Desc' => 'Titles rated C have been assessed to be suitable for gamers ages 15 and up.'
	],
	3 => [
		'Rating' => 'CEROD',
		'Name' => 'CERO D',
		'Desc' => 'Titles rated D have been assessed to be suitable for gamers ages 17 and up.'
	],
	4 => [
		'Rating' => 'CEROZ',
		'Name' => 'CERO Z',
		'Desc' => 'Titles rated Z have been assessed to be suitable only for gamers ages 18 and up. These titles contain explicit content and are banned for sale to any person under the age of 18.'
	],
	5 => [
		'Rating' => 'CERO_Statistical',
		'Name' => 'CERO - Statistical',
		'Desc' => 'Titles with this mark are Statictical software releases and have not been reviewed under the typical terms of CERO. Programs rated in this manner may or may not be appropriate for all ages.'
	],
	6 => [
		'Rating' => 'CERO_Sampler',
		'Name' => 'CERO - Sampler',
		'Desc' => 'Titles rated with this mark are Trial Versions of software. Programs rated in this manner may or may not be appropriate for all ages, and they also may not contain all of the content that will be considered for the CERO rating of the final game release.'
	],
	7 => [
		'Rating' => 'CERO_RP',
		'Name' => 'CERO - Rating Pending',
		'Desc' => 'Titles rated with this mark have not yet been rated, as they are not yet complete in production and have not yet been evaluated by CERO. Programs marked in this manner may or may not be appropriate for all ages. Please check back for the final rating at a later date.'
	],
);

const GHS_AUSSIE_RATINGS = array();

const GHS_UK_RATINGS = array();
