import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Status} from "../classes/status";
import {EventAttendance} from "../classes/eventAttendance";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class EventAttendanceService {

	constructor(protected http: HttpClient) {
	}
}