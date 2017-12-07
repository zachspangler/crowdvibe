import {Component} from "@angular/core";

import {Router} from "@angular/router";
import {Observables} from "rxjs/Observables";
import {Status} from "../classes/status";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {CookieService} from "ng2-cookies";

declare var $: any;


@Component({
	templateUrl: "./templates/event.html"
})

export class EventComponent {}