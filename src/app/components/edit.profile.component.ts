import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

declare var $: any;

@Component({
	selector: "edit-profile",
	templateUrl: "./templates/edit-profile.html"
})

export class EditProfileComponent implements OnInit {

	editProfileForm: FormGroup;
	deleted: boolean = false;
	profile: Profile = new Profile(null, null, null, null, null, null, null, null);
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private profileService: ProfileService, private route: ActivatedRoute) {}

	ngOnInit(): void {
		this.route.params.forEach((params: Params) => {
			let profileId = params["profileId"];
			this.profileService.getProfile(profileId)
				.subscribe(profile => {
					this.profile = profile;
					this.editProfileForm.patchValue(profile);
				});
		});

		this.editProfileForm = this.formBuilder.group({
			profileBio: ["", [Validators.maxLength(255), Validators.required]],
			profileEmail: ["", [Validators.maxLength(128), Validators.required]],
			profileFirstName: ["", [Validators.maxLength(32), Validators.required]],
			profileLastName: ["", [Validators.maxLength(32), Validators.required]],
			profileUserName: ["", [Validators.maxLength(32), Validators.required]],
			profileImage: ["", [Validators.maxLength(255)]],
			profilePassword: ["", [Validators.maxLength(48), Validators.required]],
		});

		this.applyFormChanges();
	}

	applyFormChanges() : void {
		this.editProfileForm.valueChanges.subscribe(values => {
			for(let field in values) {
				this.profile[field] = values[field];
			}
		});
	}

	// deleteProfile() : void {
	// 	this.profileService.deleteProfile(this.profile.profileId)
	// 		.subscribe(status => {
	// 			this.status = status;
	// 			if(this.status.status === 200) {
	// 				this.deleted = true;
	// 				this.profile = new Profile(null, null, null, null, null, null, null, null);
	// 			}
	// 		});
	// }

	editProfile() : void {
		this.profileService.editProfile(this.profile)
			.subscribe(status => this.status = status);
	}
}
