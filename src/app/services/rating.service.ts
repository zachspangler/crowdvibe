import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Status} from "../classes/status";
import {Rating} from "../classes/rating";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class RatingService {

	constructor(protected http: HttpClient) {
	}
}