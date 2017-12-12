import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Image} from "../classes/image";
import {Status} from "../classes/status";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class ImageService {
    constructor(protected http: HttpClient) {}

    //define the API endpoint
    private imageUrl = "api/image/";


    // call to the image api and create a new image
    UploadImage(image: Image): Observable<Status> {
        return (this.http.post<Status>(this.imageUrl, image));

    }

}