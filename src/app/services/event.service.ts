import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Status} from "../classes/status";
import {Event} from "../classes/event";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class EventService {

	constructor(protected http: HttpClient) {
	}
}