import {Injectable} from "@angular/core";


import {Status} from "../classes/status";
import {Profile} from "../classes/profile";
import {Observable} from "rxjs/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class ProfileService {

	constructor(protected http: HttpClient) {
	}
}