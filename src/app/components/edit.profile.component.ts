

import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";
import {setTimeout} from "timers";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

@Component({
	selector: "edit-profile",
	templateUrl: "./templates/edit-profile.html"
})

export class EditProfileComponent {
	//
	//
	// editProfileForm: FormGroup;
	//
	// editProfile: editProfile = new editProfile(null, null, null, null, null, null, null, null);
	// status: Status = null;
	//
	// constructor(private formBuilder: FormBuilder, private router: Router, private profileService: ProfileService) {
	// 	console.log("Profile Updated")
	// }
	//
	// ngOnInit(): void {
	// 	this.editProfileForm = this.formBuilder.group({
	// 		profileBio: ["", [Validators.maxLength(255), Validators.required]],
	// 		profileEmail: ["", [Validators.maxLength(128), Validators.required]],
	// 		profileFirstName: ["", [Validators.maxLength(32), Validators.required]],
	// 		profileLastName: ["", [Validators.maxLength(32), Validators.required]],
	// 		profileUserName: ["", [Validators.maxLength(32), Validators.required]],
	// 		profileImage: ["", [Validators.maxLength(255)]],
	// 		profilePassword: ["", [Validators.maxLength(48), Validators.required]],
	// 		profilePasswordConfirm: ["", [Validators.maxLength(48), Validators.required]]
	// 	});
	// }
	//
	// editProfile(): void {
	//
	// 	let editProfile = editProfile()(this.editProfileForm.value.profileBio, this.editProfileForm.value.profileEmail, this.editProfileForm.value.profileFirstName, this.editProfileForm.value.profileLastName, this.editProfileForm.value.profileImage, this.editProfileForm.value.profilePassword, this.editProfileForm.value.profilePasswordConfirm, this.editProfileForm.value.profileUserName);
	//
	// 	this.profileService.editProfile(editProfile)
	// 		.subscribe(status => {
	// 			this.status = status;
	//
	// 			if(this.status.status === 200) {
	// 				alert(status.message);
	// 				setTimeout(function() {
	// 					$("#editProfile").modal('hide');
	// 				}, 500);
	// 				this.router.navigate([""]);
	// 			}
	// 		});
	// }
}