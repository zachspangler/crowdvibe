import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";

@Injectable()
export class SignOutService {

	constructor(protected http: HttpClient) {
	}

	private signOutUrl = "api/sign-out";

	getSignOut(): Observable<Status> {
		return (this.http.get<Status>(this.signOutUrl));
	}
}

