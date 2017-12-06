/*
 this component is for signing up to use the site.
 */

import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {SignUpService} from "../services/sign.up.service";
import {SignUp} from "../classes/sign.up";
import {setTimeout} from "timers";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

//declare $ for jquery
declare let $: any;

@Component({
	selector: "sign-up",
	templateUrl: "./templates/sign-up.html"
})

export class SignUpComponent implements OnInit {

	signUpForm: FormGroup;

	signUp: SignUp = new SignUp(null, null, null, null, null, null, null, null);
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private router: Router, private signUpService: SignUpService) {
		console.log("Profile Constructed")
	}

	ngOnInit(): void {
		this.signUpForm = this.formBuilder.group({
			profileBio: ["", [Validators.maxLength(255), Validators.required]],
			profileEmail: ["", [Validators.maxLength(128), Validators.required]],
			profileFirstName: ["", [Validators.maxLength(32), Validators.required]],
			profileLastName: ["", [Validators.maxLength(32), Validators.required]],
			profileUsername: ["", [Validators.maxLength(32), Validators.required]],
			profileImage: ["https://static.pexels.com/photos/242616/pexels-photo-242616.jpeg", [Validators.maxLength(255), Validators.required]],
			password: ["", [Validators.maxLength(48), Validators.required]],
			passwordConfirm: ["", [Validators.maxLength(48), Validators.required]]
		});
	}

	createSignUp(): void {

		let signUp = new SignUp(this.signUpForm.value.profileBio, this.signUpForm.value.profileEmail, this.signUpForm.value.profileFirstName, this.signUpForm.value.password, this.signUpForm.value.passwordConfirm, this.signUpForm.value.profileImage, this.signUpForm.value.profileLastName, this.signUpForm.value.profileUserName);

		this.signUpService.createProfile(signUp)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert(status.message);
					setTimeout(function() {
						$("#join").modal('hide');
					}, 500);
					this.router.navigate([""]);
				}
			});
	}
}