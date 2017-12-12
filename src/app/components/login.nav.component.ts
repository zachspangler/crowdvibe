import {Component} from "@angular/core";
import {Profile} from "../classes/profile";
import {ProfileService} from "../services/profile.service";
import {VOID_VALUE} from "@angular/animations/browser/src/render/transition_animation_engine";
import {Router} from "@angular/router";
import {Subject} from 'rxjs/Subject';


@Component({
	selector: "login-nav",
	templateUrl: "./templates/login-nav.html"
})

export class LoginNavComponent {}

//
// //observable used for searching Profiles by name
// 	termStream = new Subject<string>();
//
// 	profile: Profile = new Profile(null, null, null, null, null, null, null, null);
//
// 	profiles: Profile[]=[];
//
// 	constructor(private profileService: ProfileService, private router: Router) {
// 		this.termStream
// 			.subscribe(term => this.filterProfileByName(term));
//
// 	}
//
// 	ngOnInit(): void {
// 		this.reloadProfile();
//
// 	}
//
// 	reloadProfile(): void {
// 		this.profileService.getProfileByProfileName(this.termStream)
// 			.subscribe(profile => this.profile = profile);
//
// 	}
// 	reloadApplicationCohorts()	 : void {
// 		this.applicationCohortService.getAllApplicationCohorts()
// 			.subscribe(applicationCohorts => this.applicationCohorts = applicationCohorts);
//
// 	}
//
// 	filterProfileByName(term : string ) : void {
// 		this.profileService.getProfileByProfileName(term)
// 			.debounceTime(30000)
// 			.subscribe(profile => {
// 				this.profile = profile;
// 				if (this.filteredProfiles !== null) {
// 					console.log("I work");
// 					console.log(this.profile);
// 				}
// 			});
// 	}
//
//
//
//

