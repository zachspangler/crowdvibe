//import needed @angularDependencies
import {RouterModule, Routes} from "@angular/router";

//import all needed Interceptors
import {APP_BASE_HREF} from "@angular/common";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./services/deep.dive.interceptor";

// import all components
import {SplashComponent} from "./components/splash.component";
import {CreateEventComponent} from "./components/create.event.component";
import {EditEventComponent} from "./components/edit.event.component";
import {EditProfileComponent} from "./components/edit.profile.component";
import {HomeComponent} from "./components/home.component";
import {LandingPageComponent} from "./components/landing.page.component";
import {NavbarComponent} from "./components/navbar.component";
import {RateEventComponent} from "./components/rate.event.component";
import {RateProfileComponent} from "./components/rate.profile.component";
import {SignInComponent} from "./components/sign.in.component";
import {SignUpComponent} from "./components/sign.up.component";
import {SignOutComponent} from "./components/sign.out.component";


// import services
import {AuthService} from "./services/auth.service";
import {CookieService} from "ng2-cookies";
import {JwtHelperService} from "@auth0/angular-jwt";
import {EventAttendanceService} from "./services/event.attendance.service";
import {EventService} from "./services/event.service";
import {ProfileService} from "./services/profile.service";
import {RatingService} from "./services/rating.service";
import {SessionService} from "./services/session.service";
import {SignInService} from "./services/sign.in.service";
import {SignUpService} from "./services/sign.up.service";


//an array of the components that will be passed off to the module
export const allAppComponents = [
	SplashComponent,
	CreateEventComponent,
	EditEventComponent,
	EditProfileComponent,
	HomeComponent,
	LandingPageComponent,
	NavbarComponent,
	RateEventComponent,
	RateProfileComponent,
	SignInComponent,
	SignUpComponent,
	SignOutComponent,
];

//an array of routes that will be passed of to the module
export const routes: Routes = [
	{path: "", component: SplashComponent},
	{path: "create-event", component: CreateEventComponent},
	{path: "edit-event", component: EditEventComponent},
	{path: "edit-profile", component: EditProfileComponent},
	{path: "home", component: HomeComponent},
	{path: "", component: LandingPageComponent},
	{path: "navbar", component: NavbarComponent},
	{path: "rate-event", component: RateEventComponent},
	{path: "rate-profile", component: RateProfileComponent},
	{path: "sign-in", component: SignInComponent},
	{path: "sign-up", component: SignUpComponent},
	{path: "sign-out", component: SignOutComponent},
];

// an array of services that will be passed off to the module
const services : any[] = [AuthService,CookieService,JwtHelperService,EventAttendanceService,EventService,ProfileService,RatingService,SessionService,SignInService,SignUpService];

// an array of misc providers
export const providers: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},
];

export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);