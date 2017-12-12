import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {EventAttendanceService} from "../services/event.attendance.service";
import {Status} from "../classes/status";
import {AttendanceProfiles} from "../classes/attendanceProfiles";


@Component({
	templateUrl: "./templates/event.html"
})

export class EventComponent implements OnInit {

	event: Event = new Event(null, null, null, null, null, null, null, null, null, null);
	attendanceProfiles: AttendanceProfiles [] = [];
	status: Status = null;

	constructor(private eventService: EventService, private eventAttendanceService: EventAttendanceService, private route: ActivatedRoute) {}

	ngOnInit(): void {
		this.route.params.forEach((params: Params) => {
			let eventId = params["eventId"];
			this.eventService.getEvent(eventId)
				.subscribe(event => this.event = event);

			this.eventAttendanceService.getEventAttendanceByEventAttendanceEventId(eventId)
				.subscribe(attendanceProfiles => this.attendanceProfiles = attendanceProfiles);
		});
	}
}

	// listAttendance(): void {
	// 	let eventAttendanceEventId : string = this.route.snapshot.params["id"];
	// 	this.eventAttendanceService.getEventAttendanceByEventId(eventAttendanceEventId)
	// 		.subscribe(eventAttendance => this.eventAttendance = eventAttendance);
	// }

	// getHost() {
	// 	let profileHost: string = this.route.snapshot.params["eventProfileId"];
	// 	this.profileService.getProfile(profileHost)
	// 		.subscribe(profile => this.profile = profile);
	// }

// export class EventComponent implements OnInit{

// 		event: Event = new Event(null, null, null, null, null, null, null, null, null, null);
// 		attendanceProfiles : AttendanceProfiles[] = [];
//
// 		constructor(private formBuilder: FormBuilder, private eventService: EventService, private eventAttendanceService : EventAttendanceService, private profileService : ProfileService, private route: ActivatedRoute) {}
//
//
// 		getEventByEventId() : void {
// 			let eventId : string = this.route.snapshot.params["eventId"];
// 			this.eventService.getEvent(eventId)
// 				.subscribe(event =>this.event = event);
// 		}
//
// 		getEventAttendanceByEventId() : void {
// 			let eventId : string = this.route.snapshot.params["eventId"];
// 			this.eventAttendanceService.getEventAttendanceByProfileId(eventId)
// 				.subscribe(eventAttendances =>{
// 					this.attendanceProfiles = eventAttendances
//
// 				});
// 		}
//
//
//
// // 		ngOnInit() : void {
// // 			this.getEventByEventId();
// // 			this.getEventAttendanceByEventId();
// // }

// }