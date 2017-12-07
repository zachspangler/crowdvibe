import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {Status} from "../classes/status";
import {FormBuilder} from "@angular/forms";


@Component({
	templateUrl: "./templates/event.html"
})

export class EventComponent implements OnInit{
		event: Event = new Event(null, null, null, null, null, null, null, null, null, null);

		constructor(private formBuilder: FormBuilder, private eventService: EventService, private route: ActivatedRoute) {}



		ngOnInit() : void {
			this.route.snapshot.params["event"]
}

}