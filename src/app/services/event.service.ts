import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Status} from "../classes/status";
import {Event} from "../classes/event";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class EventService {
	constructor(protected http: HttpClient) {

	}

	// define the API endpoint
	private eventURL = "api/event/";

	//call out to the event API and delete the event in question.
	deleteEvent(id: number) : Observable<Status> {
		return(this.http.delete<Status>(this.eventURL + id))

	}

	// call out to the event API and edit the event in question
	editEvent(event : Event) : Observable<Status> {
		return (this.http.put<Status>(this.eventURL + event.id, event));
	}

	// call to event API and create the event in question
	createEvent(event : Event) : Observable<Status> {
		return(this.http.post<Status>(this.eventURL, event));
	}

	// call to the tweet API and get a tweet object based on its Id
	getEvent(id : number) : Observable<Event> {
		return (this.http.get<Event>(this.eventURL + id));
	}

	// call to the event API and get an event based on profile id
	getEventByEventProfileId (eventProfileId : number) : Observable<Event[]> {
		return (this.http.get<Event[]>(this.eventURL + eventProfileId));
	}

	// call to the event API and get an event based on its name
	getEventByEventName(eventName : string) : Observable<Event[]> {
		return (this.http.get<Event[]>(this.eventURL + eventName));
	}

	// call to the event API and get an event based on eventStartDateTime
	getEventByEventStartDateTime(eventStartDateTime : string) : Observable<Event[]> {
		return (this.http.get<Event[]>(this.eventURL + eventStartDateTime));
	}

	// call to the event API and get an array of all events in the database
	getAllEvents () : Observable<Event[]> {
		return (this.http.get<Event[]>(this.eventURL));
	}
}

