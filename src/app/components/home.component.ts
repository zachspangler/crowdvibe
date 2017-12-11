import {Component, OnInit} from "@angular/core";
import {EventService} from "../services/event.service";



@Component({
	templateUrl: "./templates/home.html"
})

export class HomeComponent {}
//
// 	ngOnInit() {
// 		this.refreshData();
// 		this.interval = setInterval(() => {
// 			this.refreshData();
// 		}, 5000);
// 	}
//
// 	refreshData(){
// 		this.EventService.getData()
// 			.subscribe(data => {
// 				this.data = data;
// 			})
// 	);
// }