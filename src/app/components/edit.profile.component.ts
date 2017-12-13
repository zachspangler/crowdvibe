import {Component, OnInit, ViewChild} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {JwtHelperService} from "@auth0/angular-jwt";
import {ImageComponent} from "./image.component";

@Component({
	selector: "edit-profile",
	templateUrl: "./templates/edit-profile.html"
})

export class EditProfileComponent implements OnInit {

	editProfileForm: FormGroup;
	profile: Profile = new Profile(null, null, null, null, null, null, null, null);
	@ViewChild(ImageComponent) imageComponent: ImageComponent;
	cloudinarySecureUrl: string;
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private jwtHelperService: JwtHelperService, private profileService: ProfileService, private route: ActivatedRoute) {
	}

	ngOnInit(): void {
		let profileToken = this.jwtHelperService.decodeToken(localStorage.getItem("jwt-token"));
		let profileId = profileToken.auth.profileId;
		this.profileService.getProfile(profileId)
			.subscribe(user => {
				this.editProfile = profileId;
				this.editProfileForm.patchValue(this.editProfile);
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

	applyFormChanges(): void {
		this.editProfileForm.valueChanges.subscribe(values => {
			for(let field in values) {
				this.profile[field] = values[field];
			}
		});
	}

	editProfile(): void {
		this.profileService.editProfile(this.profile)
			.subscribe(status => this.status = status);
	}

    onCloudinarySecureUrlChange(newCloudinarySecureUrl: string): void {
        this.cloudinarySecureUrl = newCloudinarySecureUrl;
        this.editProfile();
    }
}
