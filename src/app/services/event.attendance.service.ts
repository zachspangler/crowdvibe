import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Status} from "../classes/status";
import {EventAttendance} from "../classes/eventAttendance";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class EventAttendanceService {

	constructor(protected http: HttpClient) {
	}

	//define rhe API endpoint
	private eventAttendanceUrl = "/api/eventAttendance";

	// call the API and create a new event attendance
	createEventAttendance(eventAttendance : eventAttendance) : observable<status>{
		return(this.http.post<status>(this.eventAttendanceUrl, eventAttendance));
	}

}