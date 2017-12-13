import {Component, OnInit, ViewChild, Injectable} from "@angular/core";
import {Router} from "@angular/router";
import {Profile} from "../classes/profile";
import {ProfileService} from "../services/profile.service";
import {Status} from "../classes/status";
import {Subject} from 'rxjs/Subject';
import  "rxjs/operator/debounce";
@Component({
	templateUrl: "./templates/search-users.html"
})

@Injectable()
export class SearchUsersComponent {
	filteredProfiles : Profile[] = [];




//observable used for searching Profiles by name
	termStream = new Subject<string>();

	profile: Profile = new Profile(null, null, null, null, null, null, null, null);

	profiles: Profile[] = [];

	constructor(private profileService: ProfileService, private router: Router) {
		this.termStream
			.debounceTime(2000)
			.distinctUntilChanged()
			.subscribe(term => this.filterProfileByName(term));

	}

	ngOnInit(): void {
		//this.reloadProfile();

	}

	reloadProfile(): void {
		this.profileService.getAllProfiles()
			.subscribe(profiles => this.profiles = profiles);

	}

	filterProfileByName(name: string): void {
		this.profileService.getProfileByProfileUserName(name)
			.subscribe(profile => {
				this.profile = profile;
				if(this.filteredProfiles !== null) {
					console.log("I work");
					console.log(profile);
				}
			});
	}
}