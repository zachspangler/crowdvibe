//import needed @angularDependencies
import {RouterModule, Routes} from "@angular/router";

//import all needed Interceptors
import {APP_BASE_HREF} from "@angular/common";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./services/deep.dive.intercepters";

// import all components
import {SplashComponent} from "./components/splash.component";
import {CreateEvent, CreateEventComponent} from "./components/create.event.component";
import {EditEvent, EditEventComponent} from "./components/edit.event.component";
import {EditProfile, EditProfileComponent} from "./components/edit.profile.component";
import {Home, HomeComponent} from "./components/home.component";
import {LandingPage, LandingPageComponent} from "./components/landing.page.component";
import {Navbar, NavbarComponent} from "./components/navbar.component";
import {RateEvent, RateEventComponent} from "./components/rate.event.component";
import {RateProfile, RateProfileComponent} from "./components/rate.profile.component";
import {SignInComponent} from "./components/sign.in.component";
import {SignUpComponent} from "./components/sign.up.component";
import {SignOutComponent} from "./components/sign.out.component";


// import services



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
const services : any[] = [

];

// an array of misc providers
export const providers: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},
];

export const appRoutingProviders: any[] = [providers, services ];

export const routing = RouterModule.forRoot(routes);