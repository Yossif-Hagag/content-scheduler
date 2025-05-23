<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @method static \Database\Factories\AboutStateFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutState newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutState newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutState onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutState query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutState withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutState withoutTrashed()
 */
	class AboutState extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Database\Factories\ArticalFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Artical newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Artical newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Artical onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Artical query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Artical withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Artical withoutTrashed()
 */
	class Artical extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Database\Factories\GeneralInformationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneralInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneralInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneralInformation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneralInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneralInformation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneralInformation withoutTrashed()
 */
	class GeneralInformation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\TypesOfHeritageSites|null $type
 * @method static \Database\Factories\HeritageSitesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeritageSites newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeritageSites newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeritageSites onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeritageSites query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeritageSites withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HeritageSites withoutTrashed()
 */
	class HeritageSites extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Database\Factories\StatisticsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistics onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistics query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistics withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistics withoutTrashed()
 */
	class Statistics extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Database\Factories\StudioFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio withoutTrashed()
 */
	class Studio extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\TypesOfTouristPlaces|null $type
 * @method static \Database\Factories\TouristPlacesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TouristPlaces newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TouristPlaces newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TouristPlaces onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TouristPlaces query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TouristPlaces withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TouristPlaces withoutTrashed()
 */
	class TouristPlaces extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HeritageSites> $heritageSites
 * @property-read int|null $heritage_sites_count
 * @method static \Database\Factories\TypesOfHeritageSitesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypesOfHeritageSites newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypesOfHeritageSites newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypesOfHeritageSites onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypesOfHeritageSites query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypesOfHeritageSites withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypesOfHeritageSites withoutTrashed()
 */
	class TypesOfHeritageSites extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TouristPlaces> $touristPlaces
 * @property-read int|null $tourist_places_count
 * @method static \Database\Factories\TypesOfTouristPlacesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypesOfTouristPlaces newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypesOfTouristPlaces newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypesOfTouristPlaces onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypesOfTouristPlaces query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypesOfTouristPlaces withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TypesOfTouristPlaces withoutTrashed()
 */
	class TypesOfTouristPlaces extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Views newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Views newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Views query()
 */
	class Views extends \Eloquent {}
}

