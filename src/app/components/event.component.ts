import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {EventAttendanceService} from "../services/event.attendance.service";
import {Status} from "../classes/status";
import {AttendanceProfiles} from "../classes/attendanceProfiles";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";


@Component({
	templateUrl: "./templates/event.html"
})

export class EventComponent implements OnInit {

	event: Event = new Event(null, null, null, null, null, null, null, null, null, null);
	profile: Profile = new Profile(null, null, null, null, null, null, null, null);
	attendanceProfiles: AttendanceProfiles [] = [];
	status: Status = null;
	eventAttendanceNumberAttend : number = 0;

	constructor(private eventService: EventService, private eventAttendanceService: EventAttendanceService, private profileService: ProfileService, private route: ActivatedRoute) {}

	ngOnInit(): void {
		this.route.params.forEach((params: Params) => {
			let eventId = params["eventId"];
			this.eventService.getEvent(eventId)
				.subscribe(event => this.event = event);

			//this is for event attendance cards
			this.eventAttendanceService.getEventAttendanceByEventAttendanceEventId(eventId)
				.subscribe(attendanceProfiles => this.attendanceProfiles = attendanceProfiles);

			//get Host for the event
			// this.profileService.getProfile(this.event.eventProfileId)
			// 	.subscribe(profile => this.profile = profile);

			//get number of people attending the event
			for (let attendance of this.attendanceProfiles) {
				this.eventAttendanceNumberAttend += attendance.eventAttendanceNumber
			}
			this.getNumberAttending();
		});
	}

	getNumberAttending() {
		for (let attendance of this.attendanceProfiles) {
			let eachAttending = attendance.eventAttendanceNumber;
			this.eventAttendanceNumberAttend += eachAttending;
		}
		console.log(this.eventAttendanceNumberAttend);
	}
}