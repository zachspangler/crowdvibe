import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {EventAttendanceService} from "../services/event.attendance.service";
import {ProfileService} from "../services/profile.service";
import {Status} from "../classes/status";
import {FormBuilder} from "@angular/forms";
import {EventAttendance} from "../classes/eventAttendance";


@Component({
	templateUrl: "./templates/event.html"
})

export class EventComponent implements OnInit{

		event: Event = new Event(null, null, null, null, null, null, null, null, null, null);
		eventAttendances : EventAttendance[] = [];

		constructor(private formBuilder: FormBuilder, private eventService: EventService, private eventAttendanceService : EventAttendanceService, private profileService : ProfileService, private route: ActivatedRoute) {}


		getEventByEventId() : void {
			let eventId : string = this.route.snapshot.params["eventId"];
			this.eventService.getEvent(eventId)
				.subscribe(event =>this.event = event);
		}

		getEventAttendanceByEventId() : void {
			let eventId : string = this.route.snapshot.params["eventId"];
			this.eventAttendanceService.getEventAttendanceByEventId(eventId)
				.subscribe(eventAttendances =>{
					this.eventAttendances = eventAttendances

				});
		}




		ngOnInit() : void {
			this.getEventByEventId();
}

}