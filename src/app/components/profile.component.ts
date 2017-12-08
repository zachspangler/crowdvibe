import {Component, OnInit} from "@angular/core";
import {ProfileService} from "../services/profile.service";
import {Profile} from  "../classes/profile";
import {ActivatedRoute} from "@angular/router";



@Component({
	templateUrl: "./templates/profile.html"
})

export class ProfileComponent implements OnInit {
	profile : Profile = new Profile(null, null, null, null, null, null, null, null);

	constructor(private profileService : ProfileService, private route: ActivatedRoute) {}
	ngOnInit() {
		this.getUser()
	}
	getUser() {
		let profileId : string	= this.route.snapshot.params["id"];
		this.profileService.getProfile(profileId)
			.subscribe(profile =>this.profile = profile);
	}


}