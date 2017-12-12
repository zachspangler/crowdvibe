import {Component, OnInit} from "@angular/core";
import {FileUploader} from "ng2-file-upload";
import {Cookie} from "ng2-cookies";
import {Observable} from "rxjs";
import "rxjs/add/observable/from";

@Component({
	selector: "profileImage",
	templateUrl: "./templates/image.php"
})

export class ImageComponent implements OnInit {
	public uploader: FileUploader = new FileUploader({
		itemAlias: "image",
		url: "./api/image/",
		headers: [{name: "X-XSRF-TOKEN", value: Cookie.get("XSRF-TOKEN")}],
		additionalParameter: {}
	});

	protected cloudinarySecureUrl : string = null;
	protected cloudinarySecureUrlObservable : Observable<string> = new Observable<string>();

	ngOnInit(): void {
		this.uploader.onSuccessItem = (item: any, response: string, status: number, headers: any) => {
			let reply = JSON.parse(response);
			this.cloudinarySecureUrl = reply.data;
			this.cloudinarySecureUrlObservable = Observable.from(this.cloudinarySecureUrl);
		};
	}

	uploadImage() :  void {
		this.uploader.uploadAll();
	}

	getCloudinaryId() : void {
		this.cloudinarySecureUrlObservable
			.subscribe(cloudinarySecureUrl => this.cloudinarySecureUrl = cloudinarySecureUrl);
	}
}