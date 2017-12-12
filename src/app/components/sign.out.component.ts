import {Component} from "@angular/core";
import {Status} from "../classes/status";
import {SignOutService} from "../services/sign.out.service";
import {Router} from "@angular/router";
import {CookieService} from "ng2-cookies";

@Component({
	selector: "sign-out",
	templateUrl: "./templates/sign-out.html"
})

export class SignOutComponent {

	status: Status = null;

	constructor(
		private signOutService: SignOutService,
		private router: Router) {}

	signOut() : void {
		localStorage.clear("jwt-token");
		this.signOutService.getSignOut();
		window.location.replace("");
	}
}
}