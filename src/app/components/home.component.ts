import {Component, OnInit} from "@angular/core";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";
import {EventService} from "../services/event.service";
import {Event} from "../classes/event";
import {Status} from "../classes/status";
import {JwtHelperService} from "@auth0/angular-jwt";
import {ActivatedRoute} from "@angular/router";
import {AuthService} from "../services/auth.service";
import {Router} from "@angular/router";



@Component({
	templateUrl: "./templates/home.html"
})

export class HomeComponent implements OnInit{

	today: number = Date.now();


	profile: Profile = new Profile(null, null, null, null, null, null, null, null);
	event: Event = new Event (null, null, null, null, null, null, null, null, null, null);
	status: Status = null;

	events: Event[] = [];

	profileId : string = this.route.snapshot.params["id"];

	constructor(private authService : AuthService, private eventService: EventService, private profileService: ProfileService, private jwtHelperService: JwtHelperService, private route: ActivatedRoute, private router: Router) {}

	ngOnInit(): void {

		this.getProfile();
		this.listEvents()
	}

	getProfile() {
		// let profileToken = this.authService.decodeJwt(localStorage.getItem("jwt-token"));
		this.profileService.getProfile(this.profileId)
			.subscribe(profile =>this.profile = profile);
	}

	listEvents(): void {
		this.eventService.getAllEvents()
			.subscribe(events => this.events = events);
	}

	switchEvent(event : Event) : void {
		this.router.navigate(["/event/", event.eventId]);
	}
}
