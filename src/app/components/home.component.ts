import {Component, OnInit} from "@angular/core";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {Status} from "../classes/status";
import {JwtHelperService} from "@auth0/angular-jwt";
import {ActivatedRoute} from "@angular/router";
import {Router} from "@angular/router";


@Component({
	templateUrl: "./templates/home.html"
})

export class HomeComponent implements OnInit {

	today: number = Date.now();

	eventId: string;
	profile: Profile = new Profile(null, null, null, null, null, null, null, null);
	event: Event = new Event(null, null, null, null, null, null, null, null, null, null);
	status: Status = null;

	events: Event[] = [];
	hosts: Profile[] = [];

	constructor(private eventService: EventService, private profileService: ProfileService, private jwtHelperService: JwtHelperService, private route: ActivatedRoute, private router: Router) {
	}

	ngOnInit(): void {
		this.getProfile();
		this.listEvents()
	}

	getProfile() {
		let profileToken = this.jwtHelperService.decodeToken(localStorage.getItem("jwt-token"));
		let profileId = profileToken.auth.profileId;
		this.profileService.getProfile(profileId)
			.subscribe(profile => this.profile = profile);
	}

	listEvents(): void {
		this.eventService.getAllEvents()
			.subscribe(events => {
				this.events = events;
				this.listHosts();
			});
	}

	listHosts(): void {
		let hostProfileIds = this.events
			.map(event => event.eventProfileId)
			.filter((profileId, index, profileIds) => profileIds.lastIndexOf(profileId) === index);
		this.hosts = [];
		hostProfileIds.map(profileId => this.profileService.getProfile(profileId)
			.subscribe(profile => this.hosts.push(profile)));
	}

	getHostByProfileId(profileId: string) {
		return(this.hosts.find(profile => profile.profileId === profileId));
	}

	switchEvent(event: Event): void {
		this.router.navigate(["/event/", event.eventId]);
        //this.router.navigate([""]);
    }
}