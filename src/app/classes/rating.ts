export class Rating {
	constructor(public id: string,
					public ratingEventAttendanceId: string,
					public ratingRateeProfileId: string,
					public ratingRaterProfileId: string,
					public ratingEvent: boolean,
					public ratingScore: number
	) {}
}