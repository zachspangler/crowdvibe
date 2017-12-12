import {Component, OnInit} from "@angular/core";
import {ProfileService} from "../services/profile.service";
import {Profile} from  "../classes/profile";
import {ActivatedRoute} from "@angular/router";
import {EventAttendanceService} from "../services/event.attendance.service";
import {EventAttendance} from "../classes/eventAttendance";
import {forEach} from "@angular/router/src/utils/collection";



@Component({
	templateUrl: "./templates/profile.html"
})

export class ProfileComponent implements OnInit {
	profile : Profile = new Profile(null, null, null, null, null, null, null, null);
	eventAttendances : EventAttendance[] = [];

    profileId : string	= this.route.snapshot.params["id"];

	constructor(private profileService : ProfileService, private route: ActivatedRoute, private eventAttendanceService : EventAttendanceService) {}
	ngOnInit() {
		this.getUser()
	}

	getUser() {
		this.profileService.getProfile(this.profileId)
			.subscribe(profile =>this.profile = profile);
	}

	// getEventAttendanceByEventAttendanceId() {
	// 	this.eventAttendanceService.getEventAttendanceByProfileId( this.profileId)
	// 		.subscribe(eventAttendance =>{
	// 			this.eventAttendances = eventAttendance
	// 			forEach(){
	//
	// 			}
	//
	//
	// 		});
	// }
}