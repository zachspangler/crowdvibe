import {Component, OnInit} from "@angular/core";
import {Status} from "../classes/status";
import {EventService} from "../services/event.service";
import {BrowserModule} from '@angular/platform-browser';
import * as enLocale from 'date-fns/locale/en';
import {DatepickerOptions} from 'ng2-datepicker';
import {Event} from "../classes/event";
import {getTime} from 'date-fns';

@Component({
	selector: "create-event",
	templateUrl: "./templates/create-event.html"
})

export class CreateEventComponent {

	eventStartDateTime: Date;
	eventEndDateTime: Date;
	options: DatepickerOptions = {
		locale: enLocale
	};

	// eventStartDateTime = getTime(this.eventStartDateTime);
	// eventEndDateTime = getTime(this.eventEndDateTime);

	event: Event = new Event(null, null, null, null, null, null, null, null, null, null);
	status: Status = null;



	constructor(private eventService: EventService) {
		console.log("Event Constructed")
	}

	createEvent(): void {
		this.eventService.createEvent(this.event)
			.subscribe(status => this.status = status);
	}

	editEvent(): void {
		this.eventService.editEvent(this.event)
			.subscribe(status => this.status = status);
	}
}
