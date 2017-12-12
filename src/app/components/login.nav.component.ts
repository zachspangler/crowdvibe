import {Component} from "@angular/core";
import {Profile} from "../classes/profile";
import {ProfileService} from "../services/profile.service";
import {VOID_VALUE} from "@angular/animations/browser/src/render/transition_animation_engine";


@Component({
	selector: "login-nav",
	templateUrl: "./templates/login-nav.html"
})

export class LoginNavComponent {


//observable used for searching Profiles by name
	termStream = new Subject<string>();

	profile: Profile = new Profile(null, null, null, null, null, null, null, null);

	constructor(private profileService: ProfileService, private router: Router) {
		this.termStream
			.subscribe(term => this.filterProfileByName(term));

	}

	ngOnInit(): void {
		this.reloadProfile();

	}

	reloadProfile(): void {
		this.reloadProfile.getAllProfiles()
			.subscribe(profile => this.profile = profile);

	}

	filterProfileByName(term : string ) : void {
		this.profileService.getProfileByProfileName(term)
			.debounceTime(30000)
			.subscribe(profile => {
				this.profile = profile;
				if (this.filteredProfiles !== null) {
					console.log("I work");
					console.log(this.profile);
				}
			});
	}
}




