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

export class LoginNavComponent {
	filteredProfiles : Profile[] = [];




//observable used for searching Profiles by name
	termStream = new Subject<string>();

	profile: Profile = new Profile(null, null, null, null, null, null, null, null);

	profiles: Profile[] = [];

	constructor(private profileService: ProfileService, private router: Router) {
		this.termStream
			.subscribe(term => this.filterProfileByName(term));

	}

	ngOnInit(): void {
		this.reloadProfile();

	}

	reloadProfile(): void {
		this.profileService.getAllProfiles()
			.subscribe(profiles => this.profiles = profiles);

	}

	reloadApplicationCohorts(): void {
		this.profileService.getAllProfiles()
			.subscribe(profiles => this.profiles = profiles);

	}

	filterProfileByName(term: string): void {
		this.profileService.getAllProfiles()
			.debounceTime(30000)
			.subscribe(profiles => {
				this.profiles = profiles;
				if(this.filteredProfiles !== null) {
					console.log("I work");
					console.log(this.profile);
				}
			});
	}
}




