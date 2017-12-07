import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {EventAttendanceService} from "../services/event.attendance.service";
import {EventAttendance} from "../classes/eventAttendance";
import {setTimeout} from "timers";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

//declare $ for jquery
declare let $: any;

@Component({
	selector: "attending-eventAttendance",
	templateUrl: "./templates/attending-confirmation.html"
})

export class EventAttendanceComponent {
	createEventAttendanceForm: FormGroup;
	eventAttendance: EventAttendance = new EventAttendance(null,null,null,null,null);
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private router: Router, private eventAttendanceService: EventAttendanceService){
		console.log("Attendance Recorded")
	}

	ngOnInit(): void{
		this.createEventAttendanceForm = this.formBuilder.group({
			eventAttendanceNumberAttending: ["",[Validators.maxLength(500), Validators.required]]
		});
	}
	createEventAttendance(): void{

		let createEventAttendance = new EventAttendance(null,null,null, 0, this.createEventAttendanceForm.value.eventAttendanceNumberAttending);

		this.eventAttendanceService.createEventAttendance(createEventAttendance)
			.subscribe(status=>{
				this.status = status;

				if(this.status.status === 500){
					alert(status.message);
					setTimeout(function(){
						$("#createEventAttendance").modal('hide');
					}, 500);
					this.router.navigate(["home"])
				}
			})
	}

}



