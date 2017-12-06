import {Injectable} from "@angular/core";

import {Status} from "../classes/status";
import {Profile} from "../classes/profile";
import {Observable} from "rxjs/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class ProfileService {

	constructor(protected http: HttpClient) {

	}

	// //define the API endpoint
	// private profileUrl = "api/profile/";
	//
	// //reach out to the profile  API and delete the profile in question
	// deleteProfile(id: string): Observable<Status> {
	// 	return (this.http.delete<Status>(this.profileUrl + id));
	// }
	//
	// // call to the Profile API and edit the profile in question
	// editProfile(id: string, profile: Profile): Observable<Status> {
	// 	return (this.http.put<Status>(this.profileUrl/id, profile));
	// }
	//
	// // call to the Profile API and get a Profile object by its id
	// getProfile(id: string): Observable<Profile> {
	// 	return (this.http.get<Profile>(this.profileUrl + id));
	// }
	//
	// // call to the API to grab an array of profiles based on the user input
	// getProfileByProfileEmail(profileEmail: string): Observable<Profile[]> {
	// 	return (this.http.get<Profile[]>(this.profileUrl + "?profileEmail=" + profileEmail));
	//
	// }
	//
	// // call to the API to grab an array of profiles based on the user input
	// getProfileByProfileUserName(profileUserName: string): Observable<Profile[]> {
	// 	return (this.http.get<Profile[]>(this.profileUrl + "?profileUserName=" + profileUserName));
	// }

	// // call to the API to grab an array of profiles based on the user input
	// getProfileByProfileName(profileName: string): Observable<Profile[]> {
	// 	return (this.http.get<Profile[]>(this.profileUrl + "?profileName=" + profileName));
}