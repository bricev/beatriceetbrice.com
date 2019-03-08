import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { LocationComponent } from './location/location.component'
import { HousingComponent } from './housing/housing.component'

const routes: Routes = [
    { path: 'location', component: LocationComponent },
    { path: 'housing',  component: HousingComponent },
    { path: '**',       component: HomeComponent, pathMatch: 'full' },
];

@NgModule({
    imports: [ RouterModule.forRoot(routes) ],
    exports: [ RouterModule ]
})

export class AppRoutingModule {}
