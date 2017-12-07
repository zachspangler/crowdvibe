export class Event {
	constructor(
					public eventAddress: string,
					public eventAttendeeLimit: number,
					public eventDetail: string,
					public eventEndDateTime: string,
					public eventImage: string,
					public eventName: string,
					public eventPrice: number,
					public eventStartDateTime: string
	) {}
}