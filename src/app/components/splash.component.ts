import {Component, OnInit} from "@angular/core";
import {User} from "../classes/user";
import {UserService} from "../services/user.service";

@Component({
	templateUrl: "./templates/splash.html"
})

export class SplashComponent implements OnInit {
	users: User[] = [];

	constructor(private userService: UserService) {}

	ngOnInit(): void {
		this.userService.getAllUsers()
			.subscribe(users => this.users = users);
	}
}