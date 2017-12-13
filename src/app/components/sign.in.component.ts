import {Component, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable"
import {Status} from "../classes/status";
import {SignInService} from "../services/sign.in.service";
import {SignIn} from "../classes/sign.in";
import {CookieService} from "ng2-cookies";

declare var $: any;


@Component({
	selector: "sign-in",
	templateUrl: "./templates/sign-in.html"
})

export class SignInComponent {

	@ViewChild("signInForm") signInForm: any;

	signin: SignIn = new SignIn(null, null);
	status: Status = null;

	constructor(private SignInService: SignInService, private router: Router, private cookieService : CookieService) {
	}

	signIn(): void {
		localStorage.clear();
		this.SignInService.postSignIn(this.signin).subscribe(status => {
			this.status = status;

			if(this.status.status === 200) {
				this.signInForm.reset();
				setTimeout(function(){$("#login").modal('hide');}, 500);
				this.router.navigate(["home"]);
			} else {
				console.log("failed login");
			}
		});
	}
}