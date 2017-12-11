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

	startDate: Date;
	endDate: Date;
	options: DatepickerOptions = {
		locale: enLocale
	};
	eventStartDateTime : number = getTime(this.startDate);
	eventEndDateTime : number = getTime(this.endDate);

	event: Event = new Event(null, null, null, null, null, null, null, null, null, null);
	status: Status = null;



	constructor(private eventService: EventService) {
		console.log("Event Constructed")
	}

	createEvent(): void {
		console.log(this.startDate, this.endDate);
		console.log(this.eventStartDateTime, this.eventEndDateTime);
		let createAnEvent = new Event(null, null, this.event.eventAddress, this.event.eventAttendeeLimit, this.event.eventDetail, this.eventEndDateTime, this.event.eventImage,  this.event.eventName, this.event.eventPrice, this.eventStartDateTime);
		this.eventService.createEvent(createAnEvent)
			.subscribe(status => this.status = status);
	}

	editEvent(): void {
		this.eventService.editEvent(this.event)
			.subscribe(status => this.status = status);
	}
}
