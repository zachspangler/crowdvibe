import {Component} from "@angular/core";
import {Profile} from "../classes/profile";


@Component({
	selector: "login-nav",
	templateUrl: "./templates/login-nav.html"
})

export class LoginNavComponent {}



//observable used for searching Profiles by name
termStream = new Subject<string>();

 profileUsername : Profile  profile = new Profile(null,null, null, null, null, null, null, null);
