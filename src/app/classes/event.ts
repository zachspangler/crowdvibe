export class Event {
	constructor(public id: string,
					public eventProfileId: string,
					public eventAttendeeLimit: number,
					public eventDetail: string,
					public eventEndDateTime: string,
					public eventImage: string,
					public eventLat: number,
					public eventLong: number,
					public eventName: string,
					public eventPrice: number,
					public eventStartDateTime: string
	) {}
}