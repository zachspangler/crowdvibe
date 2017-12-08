import {Component, OnInit} from "@angular/core";
import {NgForm} from "@angular/forms";

@Component({
	templateUrl: "./templates/edit-event.html",
	selector: "edit-event"
})

export class EditEventComponent implements OnInit {

	constructor() { }

	ngOnInit() {

	}
	onEditEvent(form: NgForm) {
		const eventName =form.value.eventName;
		const eventDetail = form.value.eventDetail;
		const eventPrice = form.value.eventPrice;
		const eventImage = form.value.eventPrice;
		const eventStartDateTime = form.value.eventStartDateTime;
		const eventEndDateTime = form.value.eventEndDateTime;
		const eventAttendee = form.value.eventAttendeeLimit;
		const eventAddress = form.value.eventAddress;
	}
}