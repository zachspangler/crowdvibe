//import needed @angularDependencies
import {RouterModule, Routes} from "@angular/router";

//import all needed Interceptors
import {APP_BASE_HREF} from "@angular/common";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./services/deep.dive.interceptor";

// import all components
import {SplashComponent} from "./components/splash.component";
import {AttendingEventComponent} from "./components/attending.event.component";
import {CreateEventComponent} from "./components/create.event.component";
import {EditEventComponent} from "./components/edit.event.component";
import {EditProfileComponent} from "./components/edit.profile.component";
import {HomeComponent} from "./components/home.component";
import {LandingPageComponent} from "./components/landing.page.component";
import {NavbarComponent} from "./components/main.nav.component";
import {LoginNavComponent} from "./components/login.nav.component";
import {EventComponent} from "./components/event.component";
import {ProfileComponent} from "./components/profile.component";
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
	AttendingEventComponent,
	CreateEventComponent,
	EditEventComponent,
	EditProfileComponent,
	HomeComponent,
	LandingPageComponent,
	LoginNavComponent,
	NavbarComponent,
	EventComponent,
	ProfileComponent,
	SignInComponent,
	SignUpComponent,
	SignOutComponent,
];

//an array of routes that will be passed of to the module
export const routes: Routes = [
	{path: "home", component: HomeComponent},
	{path: "", component: LandingPageComponent},
	{path: "event", component: EventComponent},
	{path: "profile", component: ProfileComponent},
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