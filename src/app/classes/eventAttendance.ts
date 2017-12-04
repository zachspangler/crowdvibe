export class EventAttendance {
	constructor(public id: string,
					public eventAttendanceEventId: string,
					public eventAttendanceProfileId: string,
					public eventAttendanceCheckIn: number,
					public eventAttendanceNumberAttending: number,
	) {}
}