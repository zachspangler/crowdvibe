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
	createEventAttendance(eventAttendance : EventAttendance) : Observable<Status>{
		return(this.http.post<Status>(this.eventAttendanceUrl, eventAttendance));
	}
//grabs event attendance based on its composite key
	getEventAttendanceByCompositeKey(eventAttendanceProfileId : number, eventAttendanceEventId : number) : Observable <EventAttendance> {
return (this.http.get<EventAttendance>(this.eventAttendanceUrl+ "?eventAttendanceProfileId=" + eventAttendanceProfileId + "&eventAttendanceEventId=" + eventAttendanceEventId))
	}
	getEventAttendanceByEventId (eventAttendanceEventId : string) : Observable<EventAttendance[]>{
		return(this.http.get<EventAttendance[]>(this.eventAttendanceUrl + eventAttendanceEventId))
	}


}