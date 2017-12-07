import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {setTimeout} from "timers";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

//declare $ for jquery
declare let $: any;

@Component({
	selector: "create-event",
	templateUrl: "./templates/create-event.html"
})

export class CreateEventComponent implements OnInit {

	createEventForm: FormGroup;
	event: Event = new Event(null, null, null, null, null, null, null, null, null ,null);
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private router: Router, private eventService: EventService) {
		console.log("Event Constructed")
	}

	ngOnInit(): void {
		this.createEventForm = this.formBuilder.group({
			eventAddress: ["", [Validators.maxLength(255), Validators.required]],
			eventAttendeeLimit: ["", [Validators.maxLength(5), Validators.required]],
			eventDetail: ["", [Validators.maxLength(500), Validators.required]],
			eventEndDateTime: ["", [Validators.maxLength(6), Validators.required]],
			eventImage: ["", [Validators.maxLength(255), Validators.required]],
			eventName: ["", [Validators.maxLength(64), Validators.required]],
			eventPrice: ["", [Validators.maxLength(7), Validators.required]],
			eventStartDateTime: ["", [Validators.maxLength(6), Validators.required]]
		});
	}

	createEvent(): void {

		let createEvent = new Event(null, null, this.createEventForm.value.eventAddress, this.createEventForm.value.eventAttendeeLimit, this.createEventForm.value.eventDetail, this.createEventForm.value.eventEndDateTime, this.createEventForm.value.eventImage, this.createEventForm.value.eventName, this.createEventForm.value.eventPrice, this.createEventForm.value.eventStartDateTime);

		this.eventService.createEvent(createEvent)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert(status.message);
					setTimeout(function() {
						$("#createEvent").modal('hide');
					}, 500);
					this.router.navigate(["home"]);
				}
			});
	}


}