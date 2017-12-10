import {Injectable} from "@angular/core";

import {HttpClient} from "@angular/common/http";
import {Status} from "../classes/status";
import {Rating} from "../classes/rating";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class RatingService {

	constructor(protected http: HttpClient) {

	}


	//define the API endpoint
	private ratingUrl = "api/rating";

	//call to the Rating API and get a rating object by its Id
	getRating(id: string): Observable<Rating> {
		return (this.http.get<Rating>(this.ratingUrl + id));
	}

	//call to the API to grab an array of ratings based on the user input
	getRatingByRatingEventAttendanceId(ratingEventAttendanceId: string):
	Observable<Rating[]> {
		return (this.http.get<Rating[]>(this.ratingUrl + "?ratingEventAttendanceId=" + ratingEventAttendanceId));
	}

	//call to the API to grab an array of ratings based on the user input
	getRatingByRatingRateeProfileId(ratingRateeProfileId: number):
	Observable<Rating[]> {
		return (this.http.get<Rating[]>(this.ratingUrl + "?ratingRateeProfileId=" + ratingRateeProfileId));
	}

	//call to the API to grab an array of ratings based on the user input
	getRatingByRatingEventId(ratingEventId: number):
	Observable<Rating[]> {
		return (this.http.get<Rating[]>(this.ratingUrl + "?ratingEventId=" + ratingEventId));
	}
}
