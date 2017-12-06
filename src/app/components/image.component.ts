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

	protected cloudinaryPublicId : string = null;
	protected cloudinaryPublicIdObservable : Observable<string> = new Observable<string>();

	ngOnInit(): void {
		this.uploader.onSuccessItem = (item: any, response: string, status: number, headers: any) => {
			let reply = JSON.parse(response);
			this.cloudinaryPublicId = reply.data;
			this.cloudinaryPublicIdObservable = Observable.from(this.cloudinaryPublicId);
		};
	}

	uploadImage() :  void {
		this.uploader.uploadAll();
	}

	getCloudinaryId() : void {
		this.cloudinaryPublicIdObservable
			.subscribe(cloudinaryPublicId => this.cloudinaryPublicId = cloudinaryPublicId);
	}
}