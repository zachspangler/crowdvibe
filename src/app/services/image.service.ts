// import {Component, OnInit} from "@angular/core";
// import {Injectable} from "@angular/core";
// import {Http} from "@angular/http";
// import {Observable} from "rxjs/Observable";
// import {BaseService} from "./base.service";
// import {Image} from "../classes/image";
// import {Status} from "../classes/status";

// @Injectable()
// export class ImageService {
//     constructor(protected http: Http) {
//         super(http);
//     }
//
//     //define the API endpoint
//     private imageUrl = "api/image/";
//
//
//     // call to the image api and create a new image
//     createImage(image: Image): Observable<Status> {
//         return (this.http.post(this.imageUrl, image)
//             .map(this.extractData)
//             .catch(this.handleError));
//     }
//
// }