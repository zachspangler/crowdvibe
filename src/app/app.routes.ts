import {RouterModule, Routes} from "@angular/router";
import {SplashComponent} from "./components/splash.component";
import {UserService} from "./services/user.service";
import {APP_BASE_HREF} from "@angular/common";


export const allAppComponents = [SplashComponent];

export const routes: Routes = [
	{path: "", component: SplashComponent}
];

export const appRoutingProviders: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	UserService
];

export const routing = RouterModule.forRoot(routes);