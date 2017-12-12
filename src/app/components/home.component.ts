import {Component, OnInit} from "@angular/core";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {Status} from "../classes/status";
import {JwtHelperService} from "@auth0/angular-jwt";
import {ActivatedRoute} from "@angular/router";
import {AuthService} from "../services/auth.service";



@Component({
	templateUrl: "./templates/home.html"
})

export class HomeComponent implements OnInit{

	today: number = Date.now();


	profile: Profile = new Profile(null, null, null, null, null, null, null, null);
	event: Event = new Event (null, null, null, null, null, null, null, null, null, null);
	status: Status = null;

	events: Event[] = [];

	constructor(private authService : AuthService, private eventService: EventService, private profileService: ProfileService, private jwtHelperService: JwtHelperService, private route: ActivatedRoute) {}

	ngOnInit(): void {
		console.log(this.getProfile(),this.listEvents());

		this.getProfile();
		this.listEvents();
	}

	getProfile() {
		// let profileToken = this.jwtHelperService.decodeToken(localStorage.getItem("jwt-token"));
		this.profileService.getProfile(this.id)
			.subscribe(profile => this.profile = profile);
	}

	listEvents(): void {
		this.eventService.getAllEvents()
			.subscribe(events => this.events = events);
	}
}
